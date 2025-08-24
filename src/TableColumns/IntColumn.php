<?php
declare(strict_types=1);

namespace unrealization\TableColumns;

class IntColumn extends GenericColumn
{
	public function __construct(string $name, bool $unsigned = false, bool $nullable = false, bool $autoIncrement = false, $default = -INF)
	{
		parent::__construct($name, 'INT');
		$this->setUnsigned($unsigned);
		$this->setNullable($nullable);
		$this->setAutoIncrement($autoIncrement);
		$this->setDefault($default);
	}

	protected function convertDefaultValue($default): int
	{
		return (int)$this->filterDefaultValue($default, FILTER_VALIDATE_INT);
	}
}
