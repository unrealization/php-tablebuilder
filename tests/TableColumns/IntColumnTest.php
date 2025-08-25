<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use unrealization\TableColumns\IntColumn;

class IntColumnTest extends TestCase
{
	/**
	 * @covers unrealization\TableColumns\IntColumn
	 * @covers unrealization\TableColumns\GenericColumn
	 */
	public function testIntColumn()
	{
		$column = new IntColumn('test');
		$this->assertInstanceOf(IntColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` INT NOT NULL', $column->getQuerySnippet());

		$column = new IntColumn('test', false, false, false, -INF);
		$this->assertInstanceOf(IntColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` INT NOT NULL', $column->getQuerySnippet());

		$column = new IntColumn('test', true, false, false, -INF);
		$this->assertInstanceOf(IntColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` INT UNSIGNED NOT NULL', $column->getQuerySnippet());

		$column = new IntColumn('test', false, true, false, -INF);
		$this->assertInstanceOf(IntColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` INT', $column->getQuerySnippet());

		$column = new IntColumn('test', false, false, true, -INF);
		$this->assertInstanceOf(IntColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` INT NOT NULL AUTO_INCREMENT', $column->getQuerySnippet());

		$column = new IntColumn('test', false, false, false, 5);
		$this->assertInstanceOf(IntColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` INT NOT NULL DEFAULT 5', $column->getQuerySnippet());

		$column = new IntColumn('test', false, false, false, '12');
		$this->assertInstanceOf(IntColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` INT NOT NULL DEFAULT 12', $column->getQuerySnippet());

		$column = new IntColumn('test', false, true, false, null);
		$this->assertInstanceOf(IntColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` INT DEFAULT NULL', $column->getQuerySnippet());

		$this->expectException(\InvalidArgumentException::class);
		new IntColumn('test', false, false, false, 'test');
	}
}
