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
use unrealization\TableColumns\MediumIntColumn;
use unrealization\TableColumns\SmallIntColumn;
use unrealization\TableColumns\TinyIntColumn;
use unrealization\TableColumns\DoubleColumn;
use unrealization\TableColumns\EnumColumn;
use unrealization\TableColumns\MediumTextColumn;
use unrealization\TableColumns\LongTextColumn;
use unrealization\TableColumns\TinyTextColumn;

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

	public function datetime(string $name, bool $nullable = false, bool $autoUpdate = false, $default = -INF, ?string $position = null, GenericColumn|string|null $relativeTo = null, GenericColumn|string|null $changeFrom = null): self
	{
		return $this->addColumn(ColumnAction::create(DateTimeColumn::class, ColumnAction::MODE_ALTER, $name, $nullable, $autoUpdate, $default)->setPosition($position, $relativeTo)->changeFrom($changeFrom));
	}

	public function decimal(string $name, ?int $size = null, ?int $precision = null, bool $unsigned = false, bool $nullable = false, $default = -INF, ?string $position = null, GenericColumn|string|null $relativeTo = null, GenericColumn|string|null $changeFrom = null): self
	{
		return $this->addColumn(ColumnAction::create(DecimalColumn::class, ColumnAction::MODE_ALTER, $name, $size, $precision, $unsigned, $nullable, $default)->setPosition($position, $relativeTo)->changeFrom($changeFrom));
	}

	public function double(string $name, bool $unsigned = false, bool $nullable = false, $default = -INF, ?string $position = null, GenericColumn|string|null $relativeTo = null, GenericColumn|string|null $changeFrom = null): self
	{
		return $this->addColumn(ColumnAction::create(DoubleColumn::class, ColumnAction::MODE_ALTER, $name, $unsigned, $nullable, $default)->setPosition($position, $relativeTo)->changeFrom($changeFrom));
	}

	public function enum(string $name, array $enumValues, bool $nullable = false, ?string $characterSet = null, ?string $collation = null, $default = -INF, ?string $positon = null, GenericColumn|string|null $relativeTo = null, GenericColumn|string|null $changeFrom): self
	{
		return $this->addColumn(ColumnAction::create(EnumColumn::class, ColumnAction::MODE_ALTER, $name, $enumValues, $nullable, $characterSet, $collation, $default)->setPosition($positon, $relativeTo)->changeFrom($changeFrom));
	}

	public function float(string $name, bool $unsigned = false, bool $nullable = false, $default = -INF, ?string $position = null, GenericColumn|string|null $relativeTo = null, GenericColumn|string|null $changeFrom = null): self
	{
		return $this->addColumn(ColumnAction::create(FloatColumn::class, ColumnAction::MODE_ALTER, $name, $unsigned, $nullable, $default)->setPosition($position, $relativeTo)->changeFrom($changeFrom));
	}

	public function int(string $name, bool $unsigned = false, bool $nullable = false, bool $autoIncrement = false, $default = -INF, ?string $position = null, GenericColumn|string|null $relativeTo = null, GenericColumn|string|null $changeFrom = null): self
	{
		return $this->addColumn(ColumnAction::create(IntColumn::class, ColumnAction::MODE_ALTER, $name, $unsigned, $nullable, $autoIncrement, $default)->setPosition($position, $relativeTo)->changeFrom($changeFrom));
	}

	public function longtext(string $name, bool $nullable = false, ?string $characterSet = null, ?string $collation = null, $default = -INF, ?string $position = null, GenericColumn|string|null $relativeTo = null, GenericColumn|string|null $changeFrom = null): self
	{
		return $this->addColumn(ColumnAction::create(LongTextColumn::class, ColumnAction::MODE_ALTER, $name, $nullable, $characterSet, $collation, $default)->setPosition($position, $relativeTo)->changeFrom($changeFrom));
	}

	public function mediumint(string $name, bool $unsigned = false, bool $nullable = false, bool $autoIncrement = false, $default = -INF, ?string $position = null, GenericColumn|string|null $relativeTo = null, GenericColumn|string|null $changeFrom = null): self
	{
		return $this->addColumn(ColumnAction::create(MediumIntColumn::class, ColumnAction::MODE_ALTER, $name, $unsigned, $nullable, $autoIncrement, $default)->setPosition($position, $relativeTo)->changeFrom($changeFrom));
	}

	public function mediumtext(string $name, bool $nullable = false, ?string $characterSet = null, ?string $collation = null, $default = -INF, ?string $position = null, GenericColumn|string|null $relativeTo = null, GenericColumn|string|null $changeFrom = null): self
	{
		return $this->addColumn(ColumnAction::create(MediumTextColumn::class, ColumnAction::MODE_ALTER, $name, $nullable, $characterSet, $collation, $default)->setPosition($position, $relativeTo)->changeFrom($changeFrom));
	}

	public function smallint(string $name, bool $unsigned = false, bool $nullable = false, bool $autoIncrement = false, $default = -INF, ?string $position = null, GenericColumn|string|null $relativeTo = null, GenericColumn|string|null $changeFrom = null): self
	{
		return $this->addColumn(ColumnAction::create(SmallIntColumn::class, ColumnAction::MODE_ALTER, $name, $unsigned, $nullable, $autoIncrement, $default)->setPosition($position, $relativeTo)->changeFrom($changeFrom));
	}

	public function text(string $name, bool $nullable = false, ?string $characterSet = null, ?string $collation = null, $default = -INF, ?string $position = null, GenericColumn|string|null $relativeTo = null, GenericColumn|string|null $changeFrom = null): self
	{
		return $this->addColumn(ColumnAction::create(TextColumn::class, ColumnAction::MODE_ALTER, $name, $nullable, $characterSet, $collation, $default)->setPosition($position, $relativeTo)->changeFrom($changeFrom));
	}

	public function time(string $name, bool $nullable = false, $default = -INF, ?string $position = null, GenericColumn|string|null $relativeTo = null, GenericColumn|string|null $changeFrom = null): self
	{
		return $this->addColumn(ColumnAction::create(TimeColumn::class, ColumnAction::MODE_ALTER, $name, $nullable, $default)->setPosition($position, $relativeTo)->changeFrom($changeFrom));
	}

	public function timestamp(string $name, bool $nullable = false, bool $autoUpdate = false, $default = -INF, ?string $position = null, GenericColumn|string|null $relativeTo = null, GenericColumn|string|null $changeFrom = null): self
	{
		return $this->addColumn(ColumnAction::create(TimeStampColumn::class, ColumnAction::MODE_ALTER, $name, $nullable, $autoUpdate, $default)->setPosition($position, $relativeTo)->changeFrom($changeFrom));
	}

	public function tinyint(string $name, bool $unsigned = false, bool $nullable = false, bool $autoIncrement = false, $default = -INF, ?string $position = null, GenericColumn|string|null $relativeTo = null, GenericColumn|string|null $changeFrom = null): self
	{
		return $this->addColumn(ColumnAction::create(TinyIntColumn::class, ColumnAction::MODE_ALTER, $name, $unsigned, $nullable, $autoIncrement, $default)->setPosition($position, $relativeTo)->changeFrom($changeFrom));
	}

	public function tinytext(string $name, bool $nullable = false, ?string $characterSet = null, ?string $collation = null, $default = -INF, ?string $position = null, GenericColumn|string|null $relativeTo = null, GenericColumn|string|null $changeFrom = null): self
	{
		return $this->addColumn(ColumnAction::create(TinyTextColumn::class, ColumnAction::MODE_ALTER, $name, $nullable, $characterSet, $collation, $default)->setPosition($position, $relativeTo)->changeFrom($changeFrom));
	}

	public function varchar(string $name, int $size, bool $nullable = false, ?string $characterSet = null, ?string $collation = null, $default = -INF, ?string $position = null, GenericColumn|string|null $relativeTo = null, GenericColumn|string|null $changeFrom = null): self
	{
		return $this->addColumn(ColumnAction::create(VarCharColumn::class, ColumnAction::MODE_ALTER, $name, $size, $nullable, $characterSet, $collation, $default)->setPosition($position, $relativeTo)->changeFrom($changeFrom));
	}
}
