<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use unrealization\TableColumns\IntegerColumn;

class IntegerColumnTest extends TestCase
{
	/**
	 * @covers unrealization\TableColumns\IntegerColumn
	 * @covers unrealization\TableColumns\GenericColumn
	 */
	public function testIntegerColumn()
	{
		$column = new IntegerColumn('test');
		$this->assertInstanceOf(IntegerColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` INT NOT NULL', $column->getQuerySnippet());

		$column = new IntegerColumn('test', false, false, false, -INF);
		$this->assertInstanceOf(IntegerColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` INT NOT NULL', $column->getQuerySnippet());

		$column = new IntegerColumn('test', true, false, false, -INF);
		$this->assertInstanceOf(IntegerColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` INT UNSIGNED NOT NULL', $column->getQuerySnippet());

		$column = new IntegerColumn('test', false, true, false, -INF);
		$this->assertInstanceOf(IntegerColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` INT', $column->getQuerySnippet());

		$column = new IntegerColumn('test', false, false, false, 5);
		$this->assertInstanceOf(IntegerColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` INT NOT NULL DEFAULT 5', $column->getQuerySnippet());

		$column = new IntegerColumn('test', false, false, false, '12');
		$this->assertInstanceOf(IntegerColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` INT NOT NULL DEFAULT 12', $column->getQuerySnippet());

		$this->expectException(\InvalidArgumentException::class);
		new IntegerColumn('test', false, false, false, 'test');
	}
}
