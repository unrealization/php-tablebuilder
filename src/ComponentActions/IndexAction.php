<?php
declare(strict_types=1);

namespace unrealization\ComponentActions;

use unrealization\TableIndexes\GenericIndex;

class IndexAction extends GenericAction
{
	private GenericIndex $index;

	/**
	 * Create an index object wrapped in an IndexAction.
	 * @param string $indexClass
	 * @param string $mode
	 * @param mixed ...$parameters
	 * @return static
	 */
	public static function create(string $indexClass, string $mode, ...$parameters): static
	{
		if (!is_subclass_of($indexClass, GenericIndex::class))
		{
			throw new \InvalidArgumentException('Invalid index class: '.$indexClass);
		}

		$index = new $indexClass(...$parameters);
		return new self($index, $mode);
	}

	/**
	 * Create an IndexAction from an existing index object.
	 * @param GenericIndex $index
	 * @param string $mode
	 */
	public function __construct(GenericIndex $index, string $mode = self::MODE_CREATE)
	{
		$this->index = $index;
		$this->mode = $mode;
	}

	/**
	 * 
	 * {@inheritDoc}
	 * @see \unrealization\ComponentActions\GenericAction::getName()
	 */
	public function getName(): string
	{
		return $this->index->getName();
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
				$sql = 'ADD '.$this->index->getQuerySnippet();
				break;
			case self::MODE_DROP:
				$indexName = $this->getName();

				if ($indexName === 'PRIMARY')
				{
					$sql = 'DROP PRIMARY KEY';
				}
				else
				{
					$sql = 'DROP INDEX `'.$this->getName().'`';
				}
				break;
			case self::MODE_CREATE:
			default:
				$sql = $this->index->getQuerySnippet();
				break;
		}

		return $sql;
	}
}
