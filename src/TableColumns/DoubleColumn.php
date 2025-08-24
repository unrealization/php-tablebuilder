<?php
declare(strict_types=1);

namespace unrealization\TableColumns;

class DoubleColumn extends GenericColumn
{
	public function __construct(string $name, bool $unsigned = false, bool $nullable = false, $default = -INF)
	{
		parent::__construct($name, 'DOUBLE');
		$this->setUnsigned($unsigned);
		$this->setNullable($nullable);
		$this->setDefault($default);
	}

	protected function convertDefaultValue($default): float
	{
		return (float)$this->filterDefaultValue($default, FILTER_VALIDATE_FLOAT);
	}
}
