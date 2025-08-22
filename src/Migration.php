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

		if ($allowFailure)
		{
			try
			{
				$statement->execute();
			}
			catch (\PDOException $e)
			{
				error_log('Cannot check migration status.');
				return null;
			}
		}
		else
		{
			$statement->execute();
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
			error_log('Migration '.$id.' has run already.');
			return true;
		}

		$statement = $db->prepare($action->getQuery());

		try
		{
			$statement->execute();
		}
		catch (\PDOException $e)
		{
			error_log('Error running the migration: '.$e->getMessage());
			return false;
		}

		$completed = new \DateTime();
		$sql = 'INSERT INTO `'.$migrationTable.'` (`id`,`completed`) VALUES (:id, :completed)';
		$statement = $db->prepare($sql);
		$statement->bindValue('id', $id);
		$statement->bindValue('completed', $completed->format('Y-m-d H:i:s'));

		try
		{
			$statement->execute();
		}
		catch (\PDOException $e)
		{
			error_log('Cannot log migration.');
		}

		return true;
	}
}
