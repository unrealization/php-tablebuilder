<?php
declare(strict_types=1);

namespace unrealization\TableColumns;

class DateTimeColumn extends GenericColumn
{
	public function __construct(string $name, bool $nullable = false, $autoUpdate = false, $default = -INF)
	{
		parent::__construct($name, 'DATETIME');
		$this->setNullable($nullable);
		$this->setAutoUpdate($autoUpdate);
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
				switch ($default) {
					case 'CURRENT_TIMESTAMP':
					case 'NOW()':
					case 'CURRENT_DATE':
					case 'CURRENT_TIME':
					case 'LOCALTIME':
					case 'LOCALTIMESTAMP':
						return $default;
					default:
						$default = new \DateTime($default);
						break;
				}
			}
		}

		return '\''.$default->format('Y-m-d H:i:s').'\'';
	}
}
