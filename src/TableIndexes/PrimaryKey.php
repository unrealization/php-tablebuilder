<?php
declare(strict_types=1);

namespace unrealization\TableIndexes;

use unrealization\TableColumns\GenericColumn;

class PrimaryKey extends GenericIndex
{
	public function __construct(array|GenericColumn|string $columns)
	{
		parent::__construct('PRIMARY KEY', $columns);
	}
}
