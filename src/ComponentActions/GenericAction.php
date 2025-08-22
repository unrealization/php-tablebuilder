<?php
declare(strict_types=1);

namespace unrealization\ComponentActions;

abstract class GenericAction
{
	public const MODE_ALTER = 'ALTER';
	public const MODE_CREATE = 'CREATE';
	public const MODE_DROP = 'DROP';

	protected string $mode;

	/**
	 * Create an action object.
	 * @param string $class
	 * @param string $mode
	 * @param mixed ...$parameters
	 * @return static
	 */
	abstract public static function create(string $class, string $mode, ...$parameters): static;
	/**
	 * Get the name of the stored object.
	 * @return string
	 */
	abstract public function getName(): string;
	/**
	 * Assemble the query snippet for the stored object.
	 * @return string
	 */
	abstract public function getQuerySnippet(): string;
}
