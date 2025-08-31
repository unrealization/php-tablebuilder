#!/usr/bin/env php
<?php
declare(strict_types=1);

use unrealization\MigrationInterface;
use unrealization\Migration;

function getMigrations(string $migrationDirectory, bool $ignoreProblems = false): array
{
	$fileList = array();
	$dirList = new \DirectoryIterator($migrationDirectory);

	/**
	 * @var \DirectoryIterator $dirEntry
	 */
	foreach ($dirList as $dirEntry)
	{
		if ($dirEntry->isDot())
		{
			continue;
		}

		if ($dirEntry->getExtension() !== 'php')
		{
			continue;
		}

		$fileList[$dirEntry->getBasename('.php')] = clone $dirEntry;
	}

	ksort($fileList);
	$migrationInfo = array(
		'dbConnection'			=> null,
		'migrationTable'		=> null,
		'migrations'			=> array()
	);

	foreach ($fileList as $file)
	{
		try
		{
			require_once($file->getPathname());
		}
		catch (\Exception $e)
		{
			if ($ignoreProblems)
			{
				error_log('Ignoring exception: '.$e->getMessage());
				continue;
			}

			throw new \Exception('Error loading migration file '.$file->getPathname(), previous: $e);
		}

		$migrationClass = 'Migration_'.$file->getBasename('.php');

		if (!class_exists($migrationClass))
		{
			continue;
		}

		if (!is_subclass_of($migrationClass, MigrationInterface::class))
		{
			error_log('Incorrect migration class in '.$file->getBasename());
			continue;
		}

		$migrationInfo['migrations'][] = $migrationClass;
	}

	if (!$ignoreProblems)
	{
		if (!isset($dbConnection))
		{
			throw new \Exception('DB connection is not set.');
		}

		if (!($dbConnection instanceof \PDO))
		{
			throw new \Exception('DB connection incorrect.');
		}

		if (!isset($migrationTable))
		{
			throw new \Exception('Migration table is not set.');
		}

		$migrationInfo['dbConnection'] = $dbConnection;
		$migrationInfo['migrationTable'] = $migrationTable;
	}

	return $migrationInfo;
}

function initMigrations(string $migrationTable, string $migrationDirectory): void
{
	if (!is_dir($migrationDirectory))
	{
		mkdir($migrationDirectory);
	}

	$content = '<?php
declare(strict_types=1);

// Set up the database connection.
// You should probably find a better way than hardcoding this here.
// Ultimately what you need is a PDO object in $dbConnection.
$dbHost = \'\';
$dbPort = 3306;
$dbDatabase = \'\';
$dbUsername = \'\';
$dbPassword = \'\';
$dbConnection = new \PDO(\'mysql:host=\'.$dbHost.\'; port=\'.$dbPort.\'; dbname=\'.$dbDatabase, $dbUsername, $dbPassword);

$migrationTable = \''.$migrationTable.'\';
';
	file_put_contents($migrationDirectory.'/00000000_000000_init.php', $content);

	$content = '<?php
declare(strict_types=1);

use unrealization\MigrationInterface;
use unrealization\TableActions\TableAction;
use unrealization\TableBuilder;

class Migration_00000000_000100_migrationTable implements MigrationInterface
{
	public static function migrate(): TableAction
	{
		return TableBuilder::create(\''.$migrationTable.'\', \'utf8mb4\', \'utf8mb4_0900_ai_ci\')
			->varchar(\'id\', 128)
			->timestamp(\'completed\', default: \'CURRENT_TIMESTAMP\')
			->primaryKey(\'id\');
	}
}
';
	file_put_contents($migrationDirectory.'/00000000_000100_migrationTable.php', $content);
	error_log('You will need to edit '.$migrationDirectory.'/00000000_000000_init.php to set up the database connection.');
}

function createMigration(string $tableName, string $migrationDirectory): void
{
	$creationDate = new \DateTime();
	$content = '<?php
declare(strict_types=1);

use unrealization\MigrationInterface;
use unrealization\TableActions\TableAction;
use unrealization\TableBuilder;

class Migration_'.$creationDate->format('Ymd_His').'_'.$tableName.' implements MigrationInterface
{
	public static function migrate(): TableAction
	{
		// This will fail. This is just an example/boilerplate.
		// And maybe you don\'t even want to create a table.
		return TableBuilder::create(\''.$tableName.'\');
	}
}
';
	file_put_contents($migrationDirectory.'/'.$creationDate->format('Ymd_His').'_'.$tableName.'.php', $content);
	error_log('Migration created as '.$migrationDirectory.'/'.$creationDate->format('Ymd_His').'_'.$tableName.'.php');
}

function runMigrations(string $migrationDirectory): void
{
	try
	{
		$migrationInfo = getMigrations($migrationDirectory);
	}
	catch (\Exception $e)
	{
		error_log($e->getMessage());
		exit(1);
	}

	foreach ($migrationInfo['migrations'] as $migration)
	{
		error_log('Running migration '.$migration);

		try
		{
			$run = Migration::migrate($migration, $migrationInfo['dbConnection'], $migration::migrate(), $migrationInfo['migrationTable']);
		}
		catch (\PDOException $e)
		{
			error_log('Failed to run migration '.$migration);
			exit(1);
		}

		if ($run)
		{
			error_log('Done.');
		}
		else
		{
			error_log('Migration '.$migration.' has run already.');
		}
	}
}

function logMigrations(string $migrationDirectory): void
{
	try
	{
		$migrationInfo = getMigrations($migrationDirectory);
	}
	catch (\Exception $e)
	{
		error_log($e->getMessage());
		exit(1);
	}

	foreach ($migrationInfo['migrations'] as $migration)
	{
		$completed = Migration::status($migration, $migrationInfo['dbConnection'], $migrationInfo['migrationTable']);

		if (!is_null($completed))
		{
			error_log('Migration '.$migration.' has run already.');
			continue;
		}

		$logged = Migration::log($migration, $migrationInfo['dbConnection'], $migrationInfo['migrationTable']);

		if (!$logged)
		{
			error_log('Failed to log migration '.$migration);
			exit(1);
		}

		error_log('Logged migration '.$migration);
	}
}

function dumpQueries(string $migrationDirectory): void
{
	$migrationInfo = getMigrations($migrationDirectory, true);

	foreach ($migrationInfo['migrations'] as $migration)
	{
		try
		{
			$query = $migration::migrate()->getQuery();
		}
		catch (\Exception $e)
		{
			error_log($e->getMessage());
			continue;
		}

		echo $migration.' : '.PHP_EOL;
		echo $query.PHP_EOL.PHP_EOL;
	}
}

function checkStatus(string $migrationDirectory): void
{
	try
	{
		$migrationInfo = getMigrations($migrationDirectory);
	}
	catch (\Exception $e)
	{
		error_log($e->getMessage());
		exit(1);
	}

	foreach ($migrationInfo['migrations'] as $migration)
	{
		try
		{
			$completed = Migration::status($migration, $migrationInfo['dbConnection'], $migrationInfo['migrationTable']);
		}
		catch (\Exception $e)
		{
			error_log($e->getMessage());
			exit(1);
		}

		echo $migration.' : ';

		if ($completed instanceof \DateTime)
		{
			echo $completed->format('Y-m-d H:i:s').PHP_EOL;
		}
		else
		{
			echo 'PENDING'.PHP_EOL;
		}
	}
}

if (isset($GLOBALS['_composer_autoload_path']))
{
	require_once($GLOBALS['_composer_autoload_path']);
}
elseif (is_file(__DIR__.'/../autoload.php'))
{
	require_once(__DIR__.'/../autoload.php');
}
elseif (is_file(__DIR__.'/vendor/autoload.php'))
{
	require_once(__DIR__.'/vendor/autoload.php');
}
else
{
	error_log('Cannot find autoloader.');
	exit(1);
}

$command = 'help';

if (!empty($argv[1]))
{
	$command = $argv[1];
}

$migrationDirectory = getcwd().'/migrations';
$migrationTable = 'migrations';

switch ($command)
{
	case 'help':
		error_log('Available commands:');
		error_log('help');
		error_log('init [migrationTable: '.$migrationTable.'] [migrationDirectory: '.$migrationDirectory.']');
		error_log('create tableName [migrationDirectory: '.$migrationDirectory.']');
		error_log('run [migrationDirectory: '.$migrationDirectory.']');
		error_log('logOnly [migrationDirectory: '.$migrationDirectory.']');
		error_log('status [migrationDirectory: '.$migrationDirectory.']');
		error_log('dumpQueries [migrationDirectory: '.$migrationDirectory.']');
		break;
	case 'init':
		if (!empty($argv[2]))
		{
			$migrationTable = $argv[2];
		}

		if (!empty($argv[3]))
		{
			$migrationDirectory = $argv[3];
		}

		initMigrations($migrationTable, $migrationDirectory);
		break;
	case 'create':
		if ($argc < 3)
		{
			error_log('Insufficient number of arguments.');
			exit(1);
		}

		$tableName = $argv[2];

		if (!empty($argv[3]))
		{
			$migrationDirectory = $argv[3];
		}

		createMigration($tableName, $migrationDirectory);
		break;
	case 'run':
		if (!empty($argv[2]))
		{
			$migrationDirectory = $argv[2];
		}

		runMigrations($migrationDirectory);
		break;
	case 'logOnly':
		if (!empty($argv[2]))
		{
			$migrationDirectory = $argv[2];
		}

		logMigrations($migrationDirectory);
		break;
	case 'dumpQueries':
		if (!empty($argv[2]))
		{
			$migrationDirectory = $argv[2];
		}

		dumpQueries($migrationDirectory);
		break;
	case 'status':
		if (!empty($argv[2]))
		{
			$migrationDirectory = $argv[2];
		}

		checkStatus($migrationDirectory);
		break;
	default:
		error_log('Unknown command: '.$command);
		exit(1);
}

exit(0);
