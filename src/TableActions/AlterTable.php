<?php
declare(strict_types=1);

namespace unrealization\TableActions;

use unrealization\TableActions\Alter\Columns;
use unrealization\TableActions\Alter\Indexes;
use unrealization\ComponentActions\ColumnAction;
use unrealization\ComponentActions\IndexAction;

class AlterTable extends TableAction
{
	use Columns;
	use Indexes;

	private ?string $renameTo = null;

	/**
	 * 
	 * {@inheritDoc}
	 * @see \unrealization\TableActions\TableAction::getQuery()
	 */
	public function getQuery(): string
	{
		$update = false;
		$sql = 'ALTER TABLE `'.$this->name.'`';

		if (!is_null($this->characterSet))
		{
			$sql .= ' DEFAULT CHARACTER SET '.$this->characterSet;
			$update = true;
		}

		if (!is_null($this->collation))
		{
			$sql .= ' COLLATE='.$this->collation;
			$update = true;
		}

		if (!empty($this->columns))
		{
			if ($update)
			{
				$sql .= ',';
			}

			$columnStatements = array();

			/**
			 * @var ColumnAction $column
			 */
			foreach ($this->columns as $column)
			{
				$columnStatements[] = $column->getQuerySnippet();
			}

			$sql .= ' '.implode(',', $columnStatements);
			$update = true;
		}

		if (!empty($this->indexes))
		{
			if ($update)
			{
				$sql .= ',';
			}

			$indexStatements = array();

			/**
			 * @var IndexAction $index
			 */
			foreach ($this->indexes as $index)
			{
				$indexStatements[] = $index->getQuerySnippet();
			}

			$sql .= ' '.implode(',', $indexStatements);
			$update = true;
		}

		if (!is_null($this->renameTo))
		{
			if ($update)
			{
				$sql .= ',';
			}

			$sql .= ' RENAME TO `'.$this->renameTo.'`';
			$update = true;
		}

		$sql .= ';';

		if (!$update)
		{
			throw new \Exception('The table '.$this->name.' has not been changed.');
		}

		return $sql;
	}

	/**
	 * Rename the table.
	 * @param string $name
	 * @return self
	 */
	public function rename(string $name): self
	{
		$this->checkName($name);
		$this->renameTo = $name;
		return $this;
	}
}
