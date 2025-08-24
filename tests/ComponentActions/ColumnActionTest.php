<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use unrealization\TableColumns\IntColumn;
use unrealization\ComponentActions\ColumnAction;
use unrealization\TableColumns\GenericColumn;

class ColumnActionTest extends TestCase
{
	/**
	 * @covers unrealization\ComponentActions\ColumnAction
	 * @uses unrealization\TableColumns\GenericColumn
	 * @uses unrealization\TableColumns\IntColumn
	 */
	public function testColumnAction()
	{
		$column = new IntColumn('test');

		$columnAction = new ColumnAction($column, ColumnAction::MODE_ALTER);
		$this->assertInstanceOf(ColumnAction::class, $columnAction);
		$this->assertSame('test', $columnAction->getName());
		$this->assertSame('ADD COLUMN `test` INT NOT NULL', $columnAction->getQuerySnippet());
		$columnAction->setPosition(ColumnAction::POSITION_AFTER, new IntColumn('id'));
		$this->assertSame('ADD COLUMN `test` INT NOT NULL AFTER `id`', $columnAction->getQuerySnippet());
		$columnAction->setPosition(ColumnAction::POSITION_AFTER, 'id');
		$this->assertSame('ADD COLUMN `test` INT NOT NULL AFTER `id`', $columnAction->getQuerySnippet());
		$columnAction->setPosition(ColumnAction::POSITION_FIRST);
		$this->assertSame('ADD COLUMN `test` INT NOT NULL FIRST', $columnAction->getQuerySnippet());
		$columnAction->changeFrom(new IntColumn('test2'));
		$this->assertSame('CHANGE COLUMN `test2` `test` INT NOT NULL FIRST', $columnAction->getQuerySnippet());
		$columnAction->changeFrom('test2');
		$this->assertSame('CHANGE COLUMN `test2` `test` INT NOT NULL FIRST', $columnAction->getQuerySnippet());
		$columnAction->setPosition(null);
		$this->assertSame('CHANGE COLUMN `test2` `test` INT NOT NULL', $columnAction->getQuerySnippet());
		$columnAction->changeFrom(null);
		$this->assertSame('ADD COLUMN `test` INT NOT NULL', $columnAction->getQuerySnippet());

		$columnAction = new ColumnAction($column, ColumnAction::MODE_CREATE);
		$this->assertInstanceOf(ColumnAction::class, $columnAction);
		$this->assertSame('test', $columnAction->getName());
		$this->assertSame('`test` INT NOT NULL', $columnAction->getQuerySnippet());

		$columnAction = new ColumnAction($column, ColumnAction::MODE_DROP);
		$this->assertInstanceOf(ColumnAction::class, $columnAction);
		$this->assertSame('test', $columnAction->getName());
		$this->assertSame('DROP COLUMN `test`', $columnAction->getQuerySnippet());
	}

	/**
	 * @covers unrealization\ComponentActions\ColumnAction
	 * @uses unrealization\TableColumns\GenericColumn
	 * @uses unrealization\TableColumns\IntColumn
	 */
	public function testCreate()
	{
		$columnAction = ColumnAction::create(IntColumn::class, ColumnAction::MODE_CREATE, 'test', true, autoIncrement: true);
		$this->assertInstanceOf(ColumnAction::class, $columnAction);
		$this->assertSame('test', $columnAction->getName());
		$this->assertSame('`test` INT UNSIGNED NOT NULL AUTO_INCREMENT', $columnAction->getQuerySnippet());
	}

	/**
	 * @covers unrealization\ComponentActions\ColumnAction
	 */
	public function testCreateInvalidClass()
	{
		$this->expectException(\InvalidArgumentException::class);
		ColumnAction::create(\DateTime::class, ColumnAction::MODE_CREATE, 'test');
	}
}
