<?php
declare(strict_types=1);

namespace unrealization\TableColumns;

class EnumColumn extends GenericColumn
{
	public function __construct(string $name, array $enumValues, bool $nullable = false, ?string $characterSet = null, ?string $collation = null, $default = -INF)
	{
		parent::__construct($name, 'ENUM');
		$this->setNullable($nullable);
		$this->setEnumValues($enumValues);
		$this->setCharacterSet($characterSet);
		$this->setCollation($collation);
		$this->setDefault($default);
	}

	protected function convertDefaultValue($default): int|float|string
	{
		return '\''.$default.'\'';
	}
}
