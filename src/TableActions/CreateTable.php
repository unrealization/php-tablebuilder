<?php
declare(strict_types=1);

namespace unrealization\TableActions;

use unrealization\ComponentActions\ColumnAction;
use unrealization\TableActions\Create\Indexes;
use unrealization\TableActions\Create\Columns;
use unrealization\ComponentActions\IndexAction;

class CreateTable extends TableAction
{
	use Columns;
	use Indexes;

	/**
	 * 
	 * {@inheritDoc}
	 * @see \unrealization\TableActions\TableAction::getQuery()
	 */
	public function getQuery(): string
	{
		if (empty($this->columns))
		{
			throw new \Exception('The table '.$this->name.' has no columns.');
		}

		$sql = 'CREATE TABLE `'.$this->name.'` (';
		$columnStatements = array();

		/**
		 * @var ColumnAction $column
		 */
		foreach ($this->columns as $column)
		{
			$columnStatements[] = $column->getQuerySnippet();
		}

		$sql .= implode(',', $columnStatements);
		$indexStatements = array();

		if (!empty($this->indexes))
		{
			/**
			 * @var IndexAction $index
			 */
			foreach ($this->indexes as $index)
			{
				$indexStatements[] = $index->getQuerySnippet();
			}

			$sql .= ','.implode(',', $indexStatements);
		}

		$sql .= ')';

		if (!is_null($this->characterSet))
		{
			$sql .= ' DEFAULT CHARSET='.$this->characterSet;
		}

		if (!is_null($this->collation))
		{
			$sql .= ' COLLATE='.$this->collation;
		}

		$sql .= ';';
		return $sql;
	}
}
