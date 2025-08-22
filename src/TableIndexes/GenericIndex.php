<?php
declare(strict_types=1);

namespace unrealization\TableIndexes;

use unrealization\TableColumns\GenericColumn;

class GenericIndex
{
	public const FULLTEXT = 'FULLTEXT';
	public const INDEX = 'INDEX';
	public const PRIMARY = 'PRIMARY KEY';
	public const UNIQUE = 'UNIQUE KEY';

	private string $name;
	private string $type;
	private array $columns;

	public function __construct(string $type, array|GenericColumn|string $columns, ?string $name = null)
	{
		$columns = $this->validateColumns($columns);

		if ($type === self::PRIMARY)
		{
			$this->name = 'PRIMARY';
		}
		elseif (is_null($name))
		{
			$columnNames = array();

			/**
			 * @var GenericColumn $column
			 */
			foreach ($columns as $column)
			{
				$columnNames[] = $column->getName();
			}

			$this->name = str_replace(' ', '_', $type).'_'.implode('_', $columnNames);
		}
		else
		{
			$this->name = $name;
		}

		$this->type = $type;
		$this->columns = $columns;
	}

	private function validateColumns(array|GenericColumn|string $columns): array
	{
		if (!is_array($columns))
		{
			$columns = array($columns);
		}

		$indexList = array_keys($columns);

		foreach ($indexList as $index)
		{
			if ($columns[$index] instanceof GenericColumn)
			{
				continue;
			}
			elseif (is_string($columns[$index]))
			{
				$columns[$index] = new GenericColumn($columns[$index], '');
			}
			else
			{
				throw new \InvalidArgumentException('Invalid element at index '.$index);
			}
		}

		return $columns;
	}

	final public function getQuerySnippet(): string
	{
		$columnNameList = array();

		foreach ($this->columns as $column)
		{
			$columnNameList[] = $column->getName();
		}

		$sql = $this->type;

		if ($this->type !== self::PRIMARY)
		{
			$sql .= ' `'.$this->name.'`';
		}

		$sql .= ' (`'.implode('`,`', $columnNameList).'`)';
		return $sql;
	}

	final public function getName(): string
	{
		return $this->name;
	}
}
