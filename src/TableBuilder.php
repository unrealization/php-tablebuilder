<?php
declare(strict_types=1);

namespace unrealization;

use unrealization\TableActions\AlterTable;
use unrealization\TableActions\CreateTable;
use unrealization\TableActions\DropTable;

class TableBuilder
{
	/**
	 * Create a new table.
	 * @param string $name
	 * @param string $characterSet
	 * @param string $collation
	 * @return CreateTable
	 */
	public static function create(string $name, ?string $characterSet = null, ?string $collation = null): CreateTable
	{
		return new CreateTable($name, $characterSet, $collation);
	}

	/**
	 * Update an existing table.
	 * @param string $name
	 * @param string $characterSet
	 * @param string $collation
	 * @return AlterTable
	 */
	public static function alter(string $name, ?string $characterSet = null, ?string $collation = null): AlterTable
	{
		return new AlterTable($name, $characterSet, $collation);
	}

	/**
	 * Drop an existing table.
	 * @param string $name
	 * @return DropTable
	 */
	public static function drop(string $name): DropTable
	{
		return new DropTable($name);
	}
}
