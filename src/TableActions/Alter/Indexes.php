<?php
declare(strict_types=1);

namespace unrealization\TableActions\Alter;

use unrealization\ComponentActions\IndexAction;
use unrealization\TableIndexes\FullTextIndex;
use unrealization\TableIndexes\GenericIndex;
use unrealization\TableIndexes\Index;
use unrealization\TableIndexes\UniqueKey;
use unrealization\TableActions\TableAction;
use unrealization\TableColumns\GenericColumn;
use unrealization\TableIndexes\PrimaryKey;

trait Indexes
{
	abstract public function addIndex(IndexAction|GenericIndex $index): TableAction;

	public function dropIndex(GenericIndex|string $index): self
	{
		if (!($index instanceof GenericIndex))
		{
			$index = new Index(array(), $index);
		}

		return $this->addIndex(new IndexAction($index, IndexAction::MODE_DROP));
	}

	public function dropPrimaryKey()
	{
		return $this->addIndex(new IndexAction(new PrimaryKey(array()), IndexAction::MODE_DROP));
	}

	public function fullTextIndex(array|GenericColumn|string $columns, ?string $name = null): self
	{
		return $this->addIndex(IndexAction::create(FullTextIndex::class, IndexAction::MODE_ALTER, $columns, $name));
	}

	public function index(array|GenericColumn|string $columns, ?string $name = null): self
	{
		return $this->addIndex(IndexAction::create(Index::class, IndexAction::MODE_ALTER, $columns, $name));
	}

	public function primaryKey(array|GenericColumn|string $columns): self
	{
		return $this->addIndex(IndexAction::create(PrimaryKey::class, IndexAction::MODE_ALTER, $columns));
	}

	public function uniqueKey(array|GenericColumn|string $columns, ?string $name = null): self
	{
		return $this->addIndex(IndexAction::create(UniqueKey::class, IndexAction::MODE_ALTER, $columns, $name));
	}
}
