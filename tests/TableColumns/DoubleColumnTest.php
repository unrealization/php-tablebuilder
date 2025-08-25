<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use unrealization\TableColumns\DoubleColumn;

class DoubleColumnTest extends TestCase
{
	/**
	 * @covers unrealization\TableColumns\DoubleColumn
	 * @covers unrealization\TableColumns\GenericColumn
	 */
	public function testDoubleColumn()
	{
		$column = new DoubleColumn('test');
		$this->assertInstanceOf(DoubleColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` DOUBLE NOT NULL', $column->getQuerySnippet());

		$column = new DoubleColumn('test', false, false, -INF);
		$this->assertInstanceOf(DoubleColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` DOUBLE NOT NULL', $column->getQuerySnippet());

		$column = new DoubleColumn('test', true, false, -INF);
		$this->assertInstanceOf(DoubleColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` DOUBLE UNSIGNED NOT NULL', $column->getQuerySnippet());

		$column = new DoubleColumn('test', false, true, -INF);
		$this->assertInstanceOf(DoubleColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` DOUBLE', $column->getQuerySnippet());

		$column = new DoubleColumn('test', false, true, null);
		$this->assertInstanceOf(DoubleColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` DOUBLE DEFAULT NULL', $column->getQuerySnippet());

		$column = new DoubleColumn('test', false, false, -7);
		$this->assertInstanceOf(DoubleColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` DOUBLE NOT NULL DEFAULT -7', $column->getQuerySnippet());

		$column = new DoubleColumn('test', false, false, '17.4');
		$this->assertInstanceOf(DoubleColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` DOUBLE NOT NULL DEFAULT 17.4', $column->getQuerySnippet());

		$this->expectException(\InvalidArgumentException::class);
		new DoubleColumn('test', false, false, 'test');
	}
}
