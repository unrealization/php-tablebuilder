<?php
declare(strict_types=1);

namespace unrealization\TableColumns;

class TextColumn extends GenericColumn
{
	public function __construct(string $name, bool $nullable = false, ?string $characterSet = null, ?string $collation = null, $default = -INF)
	{
		parent::__construct($name, 'TEXT');
		$this->setNullable($nullable);
		$this->setCharacterSet($characterSet);
		$this->setCollation($collation);
		$this->setDefault($default);
	}

	protected function convertDefaultValue($default): int|float|string
	{
		return '\''.$default.'\'';
	}
}
