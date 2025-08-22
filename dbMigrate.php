#!/usr/bin/env php
<?php
declare(strict_types=1);

use unrealization\MigrationInterface;
use unrealization\Migration;

function getMigrations(string $migrationDirectory): array
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
	return $fileList;
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
	if (file_exists(__DIR__.'/../autoload.php'))
	{
		require_once(__DIR__.'/../autoload.php');
	}
	elseif (file_exists(__DIR__.'/vendor/autoload.php'))
	{
		require_once(__DIR__.'/vendor/autoload.php');
	}
	else
	{
		error_log('Cannot find autoloader.');
		exit(1);
	}
	
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
			->datetime(\'completed\')
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
	$fileList = getMigrations($migrationDirectory);

	foreach ($fileList as $file)
	{
		require_once($file->getPathname());

		if (!isset($dbConnection))
		{
			error_log('DB Connection is not set.');
			exit(1);
		}

		if (!($dbConnection instanceof \PDO))
		{
			error_log('DB Connection is incorrect.');
			exit(1);
		}

		if (!isset($migrationTable))
		{
			error_log('Migration table is not set.');
			exit(1);
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

		error_log('Running migraton '.$migrationClass);
		$success = Migration::migrate($migrationClass, $dbConnection, $migrationClass::migrate());

		if ($success)
		{
			error_log('Done.');
		}
		else
		{
			error_log('Failed.');
			exit(1);
		}
	}
}

function dumpQueries(string $migrationDirectory): void
{
	$fileList = getMigrations($migrationDirectory);

	foreach ($fileList as $file)
	{
		try
		{
			require_once($file->getPathname());
		}
		catch (\PDOException $e)
		{
			//Ignore DB setup problems.
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

		try
		{
			$query = $migrationClass::migrate()->getQuery();
		}
		catch (\Exception $e)
		{
			error_log('Incomplete migration class in '.$file->getBasename());
			continue;
		}

		echo $migrationClass.' : '.PHP_EOL;
		echo $query.PHP_EOL.PHP_EOL;
	}
}

function checkStatus(string $migrationDirectory): void
{
	$fileList = getMigrations($migrationDirectory);

	foreach ($fileList as $file)
	{
		require_once($file->getPathname());

		if (!isset($dbConnection))
		{
			error_log('DB Connection is not set.');
			exit(1);
		}

		if (!($dbConnection instanceof \PDO))
		{
			error_log('DB Connection is incorrect.');
			exit(1);
		}

		if (!isset($migrationTable))
		{
			error_log('Migration table is not set.');
			exit(1);
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

		echo $migrationClass.' : ';
		$completed = Migration::status($migrationClass, $dbConnection);

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

if (is_file(__DIR__.'/../autoload.php'))
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

$migrationDirectory = __DIR__.'/migrations';
$migrationTable = 'migrations';

switch ($command)
{
	case 'help':
		error_log('Available commands:');
		error_log('help');
		error_log('init [migrationTable: '.$migrationTable.'] [migrationDirectory: '.$migrationDirectory.']');
		error_log('create tableName [migrationDirectory: '.$migrationDirectory.']');
		error_log('run [migrationDirectory: '.$migrationDirectory.']');
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
			$migrationDirectory = $argv[2];
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
