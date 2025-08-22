<?php
declare(strict_types=1);

namespace unrealization\TableActions\Create;

use unrealization\TableIndexes\GenericIndex;
use unrealization\TableIndexes\Index;
use unrealization\TableIndexes\PrimaryKey;
use unrealization\TableIndexes\UniqueKey;
use unrealization\TableIndexes\FullTextIndex;
use unrealization\ComponentActions\IndexAction;
use unrealization\TableColumns\GenericColumn;
use unrealization\TableActions\TableAction;

trait Indexes
{
	abstract public function addIndex(IndexAction|GenericIndex $index): TableAction;

	public function fullTextIndex(array|GenericColumn|string $columns, ?string $name = null): self
	{
		return $this->addIndex(IndexAction::create(FullTextIndex::class, IndexAction::MODE_CREATE, $columns, $name));
	}

	public function index(array|GenericColumn|string $columns, ?string $name = null): self
	{
		return $this->addIndex(IndexAction::create(Index::class, IndexAction::MODE_CREATE, $columns, $name));
	}

	public function primaryKey(array|GenericColumn|string $columns): self
	{
		return $this->addIndex(IndexAction::create(PrimaryKey::class, IndexAction::MODE_CREATE, $columns));
	}

	public function uniqueKey(array|GenericColumn|string $columns, ?string $name = null): self
	{
		return $this->addIndex(IndexAction::create(UniqueKey::class, IndexAction::MODE_CREATE, $columns, $name));
	}
}
