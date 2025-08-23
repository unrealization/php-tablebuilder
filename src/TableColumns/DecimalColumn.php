<?php
declare(strict_types=1);

namespace unrealization\TableColumns;

class DecimalColumn extends GenericColumn
{
	public function __construct(string $name, ?int $size = null, ?int $precision = null, bool $unsigned = false, bool $nullable = false, $default = -INF)
	{
		parent::__construct($name, 'DECIMAL');
		$this->setSize($size);
		$this->setPrecision($precision);
		$this->setUnsigned($unsigned);
		$this->setNullable($nullable);
		$this->setDefault($default);
	}

	protected function convertDefaultValue($default): float
	{
		return (float)$this->filterDefaultValue($default, FILTER_VALIDATE_FLOAT);
	}
}
