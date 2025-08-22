<?php
declare(strict_types=1);

namespace unrealization;

use unrealization\TableActions\TableAction;

interface MigrationInterface
{
	/**
	 * Compose the TableAction for the migration.
	 * @return TableAction
	 */
	public static function migrate(): TableAction;
}
