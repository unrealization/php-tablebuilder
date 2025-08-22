<?php
declare(strict_types=1);

namespace unrealization\TableColumns;

class TimeStampColumn extends GenericColumn
{
	public function __construct(string $name, bool $nullable = false, $default = -INF)
	{
		parent::__construct($name, self::TIMESTAMP);
		$this->setNullable($nullable);
		$this->setDefault($default);
	}

	protected function convertDefaultValue($default): string
	{
		if (!($default instanceof \DateTime))
		{
			if (is_numeric($default))
			{
				$defaultDate = new \DateTime();
				$defaultDate->setTimestamp((int)$default);
				$default = $defaultDate;
			}
			else
			{
				$default = new \DateTime($default);
			}
		}

		return '\''.$default->format('Y-m-d H:i:s').'\'';
	}
}
