<?php
declare(strict_types=1);

namespace unrealization\TableActions\Create;

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
use unrealization\TableColumns\SmallIntColumn;
use unrealization\TableColumns\TinyIntColumn;
use unrealization\TableColumns\MediumIntColumn;
use unrealization\TableColumns\DoubleColumn;

trait Columns
{
	abstract public function addColumn(ColumnAction|GenericColumn $column): TableAction;

	public function bigint(string $name, bool $unsigned = false, bool $nullable = false, bool $autoIncrement = false, $default = -INF): self
	{
		return $this->addColumn(ColumnAction::create(BigIntColumn::class, ColumnAction::MODE_CREATE, $name, $unsigned, $nullable, $autoIncrement, $default));
	}

	public function date(string $name, bool $nullable = false, $default = -INF): self
	{
		return $this->addColumn(ColumnAction::create(DateColumn::class, ColumnAction::MODE_CREATE, $name, $nullable, $default));
	}

	public function datetime(string $name, bool $nullable = false, $default = -INF): self
	{
		return $this->addColumn(ColumnAction::create(DateTimeColumn::class, ColumnAction::MODE_CREATE, $name, $nullable, $default));
	}

	public function decimal(string $name, ?int $size = null, ?int $precision = null, bool $unsigned = false, bool $nullable = false, $default = -INF): self
	{
		return $this->addColumn(ColumnAction::create(DecimalColumn::class, ColumnAction::MODE_CREATE, $name, $size, $precision, $unsigned, $nullable, $default));
	}

	public function double(string $name, bool $unsigned = false, bool $nullable = false, $default = -INF): self
	{
		return $this->addColumn(ColumnAction::create(DoubleColumn::class, ColumnAction::MODE_CREATE, $name, $unsigned, $nullable, $default));
	}

	public function float(string $name, bool $unsigned = false, bool $nullable = false, $default = -INF): self
	{
		return $this->addColumn(ColumnAction::create(FloatColumn::class, ColumnAction::MODE_CREATE, $name, $unsigned, $nullable, $default));
	}

	public function int(string $name, bool $unsigned = false, bool $nullable = false, bool $autoIncrement = false, $default = -INF): self
	{
		return $this->addColumn(ColumnAction::create(IntColumn::class, ColumnAction::MODE_CREATE, $name, $unsigned, $nullable, $autoIncrement, $default));
	}

	public function mediumint(string $name, bool $unsigned = false, bool $nullable = false, bool $autoIncrement = false, $default = -INF): self
	{
		return $this->addColumn(ColumnAction::create(MediumIntColumn::class, ColumnAction::MODE_CREATE, $name, $unsigned, $nullable, $autoIncrement, $default));
	}

	public function smallint(string $name, bool $unsigned = false, bool $nullable = false, bool $autoIncrement = false, $default = -INF): self
	{
		return $this->addColumn(ColumnAction::create(SmallIntColumn::class, ColumnAction::MODE_CREATE, $name, $unsigned, $nullable, $autoIncrement, $default));
	}

	public function text(string $name, bool $nullable = false, ?string $characterSet = null, ?string $collation = null, $default = -INF): self
	{
		return $this->addColumn(ColumnAction::create(TextColumn::class, ColumnAction::MODE_CREATE, $name, $nullable, $characterSet, $collation, $default));
	}

	public function time(string $name, bool $nullable = false, $default = -INF): self
	{
		return $this->addColumn(ColumnAction::create(TimeColumn::class, ColumnAction::MODE_CREATE, $name, $nullable, $default));
	}

	public function timestamp(string $name, bool $nullable = false, $default = -INF): self
	{
		return $this->addColumn(ColumnAction::create(TimeStampColumn::class, ColumnAction::MODE_CREATE, $name, $nullable, $default));
	}

	public function tinyint(string $name, bool $unsigned = false, bool $nullable = false, bool $autoIncrement = false, $default = -INF): self
	{
		return $this->addColumn(ColumnAction::create(TinyIntColumn::class, ColumnAction::MODE_CREATE, $name, $unsigned, $nullable, $autoIncrement, $default));
	}

	public function varchar(string $name, int $size, bool $nullable = false, ?string $characterSet = null, ?string $collation = null, $default = -INF): self
	{
		return $this->addColumn(ColumnAction::create(VarCharColumn::class, ColumnAction::MODE_CREATE, $name, $size, $nullable, $characterSet, $collation, $default));
	}
}
