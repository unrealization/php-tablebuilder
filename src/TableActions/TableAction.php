<?php
declare(strict_types=1);

namespace unrealization\TableActions;

use unrealization\TableColumns\GenericColumn;
use unrealization\TableIndexes\GenericIndex;
use unrealization\ComponentActions\ColumnAction;
use unrealization\ComponentActions\IndexAction;

abstract class TableAction
{
	protected string $name;
	protected ?string $characterSet;
	protected ?string $collation;
	protected array $columns = array();
	protected array $indexes = array();

	/**
	 * Assemble the query.
	 * @return string
	 */
	abstract public function getQuery(): string;

	/**
	 * Create a table action object.
	 * @param string $name
	 * @param string|null $characterSet
	 * @param string|null $collation
	 */
	final public function __construct(string $name, ?string $characterSet = null, ?string $collation = null)
	{
		$this->checkName($name);
		$this->name = $name;
		$this->characterSet = $characterSet;
		$this->collation = $collation;
	}

	/**
	 * Check if the name is valid.
	 * @param string $name
	 */
	final protected function checkName(string $name): void
	{
		if (preg_match('@[^A-Za-z0-9_-]@', $name))
		{
			throw new \InvalidArgumentException('Invalid name: '.$name);
		}
	}

	/**
	 * Check column names for validity and duplication.
	 * @param string $name
	 */
	final protected function checkColumnName(string $name): void
	{
		$this->checkName($name);

		if (array_key_exists($name, $this->columns))
		{
			throw new \Exception('Duplicate column name '.$name);
		}
	}

	/**
	 * Check index names for validity and duplication.
	 * @param string $name
	 */
	final protected function checkIndexName(string $name): void
	{
		$this->checkName($name);

		if (array_key_exists($name, $this->indexes))
		{
			throw new \Exception('Duplicate index name '.$name);
		}
	}

	/**
	 * Add a column action to the table action.
	 * @param ColumnAction|GenericColumn $column
	 * @return static
	 */
	final public function addColumn(ColumnAction|GenericColumn $column): static
	{
		if ($column instanceof GenericColumn)
		{
			$column = new ColumnAction($column);
		}

		$columnName = $column->getName();
		$this->checkColumnName($columnName);
		$this->columns[$columnName] = $column;
		return $this;
	}

	/**
	 * Add in index action to the table action.
	 * @param IndexAction|GenericIndex $index
	 * @return static
	 */
	final public function addIndex(IndexAction|GenericIndex $index): static
	{
		if ($index instanceof GenericIndex)
		{
			$index = new IndexAction($index);
		}

		$indexName = $index->getName();
		$this->checkIndexName($indexName);
		$this->indexes[$indexName] = $index;
		return $this;
	}
}
