<?php
declare(strict_types=1);

namespace unrealization;

use unrealization\TableActions\TableAction;

class Migration
{
	/**
	 * Check if and when a migration has run.
	 * @param string $id
	 * @param \PDO $db
	 * @param string $migrationTable
	 * @param bool $allowFailure
	 * @return \DateTime|NULL
	 */
	public static function status(string $id, \PDO $db, string $migrationTable = 'migrations', bool $allowFailure = false): ?\DateTime
	{
		$sql = 'SELECT `completed` FROM `'.$migrationTable.'` WHERE `id`=:id';
		$statement = $db->prepare($sql);
		$statement->bindValue('id', $id);

		try
		{
			$statement->execute();
		}
		catch (\PDOException $e)
		{
			if ($allowFailure)
			{
				return null;
			}

			throw new \Exception('Cannot check migration status.', previous: $e);
		}

		if ($statement->rowCount() === 0)
		{
			return null;
		}

		$response = $statement->fetch(\PDO::FETCH_ASSOC);
		$completed = new \DateTime($response['completed']);
		return $completed;
	}

	/**
	 * Try to run a migration.
	 * @param string $id
	 * @param \PDO $db
	 * @param TableAction $action
	 * @param string $migrationTable
	 * @return bool
	 */
	public static function migrate(string $id, \PDO $db, TableAction $action, string $migrationTable = 'migrations'): bool
	{
		if (!is_null(self::status($id, $db, $migrationTable, true)))
		{
			return false;
		}

		$statement = $db->prepare($action->getQuery());

		if (!$statement->execute())
		{
			throw new \Exception('Failed to execute migration '.$id);
		}

		self::log($id, $db, $migrationTable);
		return true;
	}

	/**
	 * Try to log a migration.
	 * @param string $id
	 * @param \PDO $db
	 * @param string $migrationTable
	 * @return bool
	 */
	public static function log(string $id, \PDO $db, string $migrationTable = 'migrations'): bool
	{
		$sql = 'INSERT INTO `'.$migrationTable.'` (`id`) VALUES (:id)';
		$statement = $db->prepare($sql);
		$statement->bindValue('id', $id);

		try
		{
			$logged = $statement->execute();
		}
		catch (\PDOException $e)
		{
			return false;
		}

		return $logged;
	}
}
