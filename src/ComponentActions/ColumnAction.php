<?php
declare(strict_types=1);

namespace unrealization\ComponentActions;

use unrealization\TableColumns\GenericColumn;
use unrealization\TableColumns\IntegerColumn;

class ColumnAction extends GenericAction
{
	public const POSITION_AFTER = 'AFTER';
	public const POSITION_FIRST = 'FIRST';

	private GenericColumn $column;
	private ?string $position = null;
	private ?GenericColumn $relativeTo = null;
	private ?GenericColumn $changeFrom = null;

	/**
	 * Create a column object wrapped in a ColumnAction.
	 * @param string $columnClass
	 * @param string $mode
	 * @param mixed ...$parameters
	 * @return static
	 */
	public static function create(string $columnClass, string $mode, ...$parameters): static
	{
		if (!is_subclass_of($columnClass, GenericColumn::class))
		{
			throw new \InvalidArgumentException('Invalid column class: '.$columnClass);
		}

		$column = new $columnClass(...$parameters);
		return new self($column, $mode);
	}

	/**
	 * Create a ColumnAction from an existing column object.
	 * @param GenericColumn $column
	 * @param string $mode
	 */
	public function __construct(GenericColumn $column, string $mode = self::MODE_CREATE)
	{
		$this->column = $column;
		$this->mode = $mode;
	}

	/**
	 * 
	 * {@inheritDoc}
	 * @see \unrealization\ComponentActions\GenericAction::getName()
	 */
	public function getName(): string
	{
		return $this->column->getName();
	}

	/**
	 * 
	 * {@inheritDoc}
	 * @see \unrealization\ComponentActions\GenericAction::getQuerySnippet()
	 */
	public function getQuerySnippet(): string
	{
		$sql = '';

		switch ($this->mode)
		{
			case self::MODE_ALTER:
				$sql = '';

				if (!is_null($this->changeFrom))
				{
					$sql .= 'CHANGE COLUMN `'.$this->changeFrom->getName().'` ';
				}
				else
				{
					$sql .= 'ADD COLUMN ';
				}

				$sql .= $this->column->getQuerySnippet();

				if (!is_null($this->position))
				{
					$sql .= ' '.$this->position;

					if (!is_null($this->relativeTo))
					{
						$sql .= ' `'.$this->relativeTo->getName().'`';
					}
				}
				break;
			case self::MODE_DROP:
				$sql = 'DROP COLUMN `'.$this->getName().'`';
				break;
			case self::MODE_CREATE:
			default:
				$sql = $this->column->getQuerySnippet();
				break;
		}

		return $sql;
	}

	public function setPosition(?string $position, GenericColumn|string|null $column = null): self
	{
		$this->position = $position;

		if ((is_null($this->position)) || ($this->position === self::POSITION_FIRST))
		{
			$this->relativeTo = null;
			return $this;
		}

		if ($column instanceof GenericColumn)
		{
			$this->relativeTo = $column;
			return $this;
		}

		$this->relativeTo = new IntegerColumn($column);
		return $this;
	}

	public function changeFrom(GenericColumn|string|null $column): self
	{
		if (is_null($column))
		{
			$this->changeFrom = null;
			return $this;
		}

		if ($column instanceof GenericColumn)
		{
			$this->changeFrom = $column;
			return $this;
		}

		$this->changeFrom = new IntegerColumn($column);
		return $this;
	}
}
