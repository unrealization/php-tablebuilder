<?php
declare(strict_types=1);

namespace unrealization\TableActions\Alter;

use unrealization\ComponentActions\ColumnAction;
use unrealization\TableColumns\DateColumn;
use unrealization\TableColumns\GenericColumn;
use unrealization\TableColumns\BigIntColumn;
use unrealization\TableColumns\DateTimeColumn;
use unrealization\TableColumns\DecimalColumn;
use unrealization\TableColumns\FloatColumn;
use unrealization\TableColumns\IntColumn;
use unrealization\TableColumns\TextColumn;
use unrealization\TableColumns\VarCharColumn;
use unrealization\TableActions\TableAction;
use unrealization\TableColumns\TimeColumn;
use unrealization\TableColumns\TimeStampColumn;

trait Columns
{
	abstract public function addColumn(ColumnAction|GenericColumn $column): TableAction;

	public function dropColumn(GenericColumn|string $column): self
	{
		if (!($column instanceof GenericColumn))
		{
			$column = new IntColumn($column);
		}

		return $this->addColumn(new ColumnAction($column, ColumnAction::MODE_DROP));
	}

	public function bigint(string $name, bool $unsigned = false, bool $nullable = false, bool $autoIncrement = false, $default = -INF, ?string $position = null, GenericColumn|string|null $relativeTo = null, GenericColumn|string|null $changeFrom = null): self
	{
		return $this->addColumn(ColumnAction::create(BigIntColumn::class, ColumnAction::MODE_ALTER, $name, $unsigned, $nullable, $autoIncrement, $default)->setPosition($position, $relativeTo)->changeFrom($changeFrom));
	}

	public function date(string $name, bool $nullable = false, $default = -INF, ?string $position = null, GenericColumn|string|null $relativeTo = null, GenericColumn|string|null $changeFrom = null): self
	{
		return $this->addColumn(ColumnAction::create(DateColumn::class, ColumnAction::MODE_ALTER, $name, $nullable, $default)->setPosition($position, $relativeTo)->changeFrom($changeFrom));
	}

	public function datetime(string $name, bool $nullable = false, $default = -INF, ?string $position = null, GenericColumn|string|null $relativeTo = null, GenericColumn|string|null $changeFrom = null): self
	{
		return $this->addColumn(ColumnAction::create(DateTimeColumn::class, ColumnAction::MODE_ALTER, $name, $nullable, $default)->setPosition($position, $relativeTo)->changeFrom($changeFrom));
	}

	public function decimal(string $name, ?int $size = null, ?int $precision = null, bool $unsigned = false, bool $nullable = false, $default = -INF, ?string $position = null, GenericColumn|string|null $relativeTo = null, GenericColumn|string|null $changeFrom = null): self
	{
		return $this->addColumn(ColumnAction::create(DecimalColumn::class, ColumnAction::MODE_ALTER, $name, $size, $precision, $unsigned, $nullable, $default)->setPosition($position, $relativeTo)->changeFrom($changeFrom));
	}

	public function float(string $name, ?int $size = null, bool $unsigned = false, bool $nullable = false, $default = -INF, ?string $position = null, GenericColumn|string|null $relativeTo = null, GenericColumn|string|null $changeFrom = null): self
	{
		return $this->addColumn(ColumnAction::create(FloatColumn::class, ColumnAction::MODE_ALTER, $name, $size, $unsigned, $nullable, $default)->setPosition($position, $relativeTo)->changeFrom($changeFrom));
	}

	public function int(string $name, bool $unsigned = false, bool $nullable = false, bool $autoIncrement = false, $default = -INF, ?string $position = null, GenericColumn|string|null $relativeTo = null, GenericColumn|string|null $changeFrom = null): self
	{
		return $this->addColumn(ColumnAction::create(IntColumn::class, ColumnAction::MODE_ALTER, $name, $unsigned, $nullable, $autoIncrement, $default)->setPosition($position, $relativeTo)->changeFrom($changeFrom));
	}

	public function text(string $name, bool $nullable = false, ?string $characterSet = null, ?string $collation = null, $default = -INF, ?string $position = null, GenericColumn|string|null $relativeTo = null, GenericColumn|string|null $changeFrom = null): self
	{
		return $this->addColumn(ColumnAction::create(TextColumn::class, ColumnAction::MODE_ALTER, $name, $nullable, $characterSet, $collation, $default)->setPosition($position, $relativeTo)->changeFrom($changeFrom));
	}

	public function time(string $name, bool $nullable = false, $default = -INF, ?string $position = null, GenericColumn|string|null $relativeTo = null, GenericColumn|string|null $changeFrom = null): self
	{
		return $this->addColumn(ColumnAction::create(TimeColumn::class, ColumnAction::MODE_ALTER, $name, $nullable, $default)->setPosition($position, $relativeTo)->changeFrom($changeFrom));
	}

	public function timestamp(string $name, bool $nullable = false, $default = -INF, ?string $position = null, GenericColumn|string|null $relativeTo = null, GenericColumn|string|null $changeFrom = null): self
	{
		return $this->addColumn(ColumnAction::create(TimeStampColumn::class, ColumnAction::MODE_ALTER, $name, $nullable, $default)->setPosition($position, $relativeTo)->changeFrom($changeFrom));
	}

	public function varchar(string $name, int $size, bool $nullable = false, ?string $characterSet = null, ?string $collation = null, $default = -INF, ?string $position = null, GenericColumn|string|null $relativeTo = null, GenericColumn|string|null $changeFrom = null): self
	{
		return $this->addColumn(ColumnAction::create(VarCharColumn::class, ColumnAction::MODE_ALTER, $name, $size, $nullable, $characterSet, $collation, $default)->setPosition($position, $relativeTo)->changeFrom($changeFrom));
	}
}
