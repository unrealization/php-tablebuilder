<?php
declare(strict_types=1);

namespace unrealization\TableIndexes;

use unrealization\TableColumns\GenericColumn;

class FullTextIndex extends GenericIndex
{
	public function __construct(array|GenericColumn|string $columns, ?string $name = null)
	{
		parent::__construct(self::FULLTEXT, $columns, $name);
	}
}
