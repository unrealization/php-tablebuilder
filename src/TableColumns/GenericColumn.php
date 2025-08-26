<?php
declare(strict_types=1);

namespace unrealization\TableColumns;

abstract class GenericColumn
{
	private string $name;
	private string $type;
	private ?int $size = null;
	private ?int $precision = null;
	private bool $unsigned = false;
	private bool $nullable = false;
	private bool $autoIncrement = false;
	private array $enumValues = array();
	private ?string $characterSet = null;
	private ?string $collation = null;
	private $default = -INF;

	abstract protected function convertDefaultValue($default): int|float|string;

	public function __construct(string $name, string $type)
	{
		$this->name = $name;
		$this->type = $type;
	}

	final public function getQuerySnippet(): string
	{
		$sql = '`'.$this->name.'` '.$this->type;

		if (!is_null($this->size))
		{
			$sql .= '('.$this->size;

			if (!is_null($this->precision))
			{
				$sql .= ','.$this->precision;
			}

			$sql .= ')';
		}

		if (!empty($this->enumValues))
		{
			$sql .= '('.implode(',', $this->enumValues).')';
		}

		if ($this->unsigned)
		{
			$sql .= ' UNSIGNED';
		}

		if (!$this->nullable)
		{
			$sql .= ' NOT NULL';
		}

		if ($this->autoIncrement)
		{
			$sql .= ' AUTO_INCREMENT';
		}

		if (!is_null($this->characterSet))
		{
			$sql .= ' CHARACTER SET '.$this->characterSet;
		}

		if (!is_null($this->collation))
		{
			$sql .= ' COLLATE '.$this->collation;
		}

		if ($this->default !== -INF)
		{
			$sql .= ' DEFAULT ';

			if (is_null($this->default))
			{
				$sql .= 'NULL';
			}
			else
			{
				$sql .= $this->default;
			}
		}

		return $sql;
	}

	final public function getName(): string
	{
		return $this->name;
	}

	final protected function setSize(?int $size): static
	{
		$this->size = $size;
		return $this;
	}

	final protected function setPrecision(?int $precision): static
	{
		$this->precision = $precision;
		return $this;
	}

	final protected function setUnsigned(bool $unsigned): static
	{
		$this->unsigned = $unsigned;
		return $this;
	}

	final protected function setNullable(bool $nullable): static
	{
		$this->nullable = $nullable;
		return $this;
	}

	final protected function setAutoIncrement(bool $autoIncrement): static
	{
		$this->autoIncrement = $autoIncrement;
		return $this;
	}

	final protected function setEnumValues(array $enumValues): static
	{
		$this->enumValues = array();

		foreach ($enumValues as $value)
		{
			$this->enumValues[] = $this->convertDefaultValue($value);
		}

		return $this;
	}

	final protected function setCharacterSet(?string $characterSet): static
	{
		$this->characterSet = $characterSet;
		return $this;
	}

	final protected function setCollation(?string $collation): static
	{
		$this->collation = $collation;
		return $this;
	}

	final protected function setDefault($default = -INF): static
	{
		if (($default === -INF) || ($default === INF))
		{
			$this->default = -INF;
			return $this;
		}

		if (is_null($default))
		{
			$this->default = null;
			return $this;
		}

		$this->default = $this->convertDefaultValue($default);
		return $this;
	}

	final protected function filterDefaultValue($default, int $filterOption)
	{
		$value = filter_var($default, $filterOption);

		if ($value === false)
		{
			throw new \InvalidArgumentException('Invalid default for '.$this->type.' : '.$default);
		}

		return $value;
	}
}
