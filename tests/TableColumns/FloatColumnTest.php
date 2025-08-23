<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use unrealization\TableColumns\FloatColumn;

class FloatColumnTest extends TestCase
{
	/**
	 * @covers unrealization\TableColumns\FloatColumn
	 * @covers unrealization\TableColumns\GenericColumn
	 */
	public function testFloatColumn()
	{
		$column = new FloatColumn('test');
		$this->assertInstanceOf(FloatColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` FLOAT NOT NULL', $column->getQuerySnippet());

		$column = new FloatColumn('test', null, false, false, -INF);
		$this->assertInstanceOf(FloatColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` FLOAT NOT NULL', $column->getQuerySnippet());

		$column = new FloatColumn('test', 10, false, false, -INF);
		$this->assertInstanceOf(FloatColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` FLOAT(10) NOT NULL', $column->getQuerySnippet());

		$column = new FloatColumn('test', null, true, false, -INF);
		$this->assertInstanceOf(FloatColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` FLOAT UNSIGNED NOT NULL', $column->getQuerySnippet());

		$column = new FloatColumn('test', null, false, true, -INF);
		$this->assertInstanceOf(FloatColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` FLOAT', $column->getQuerySnippet());

		$column = new FloatColumn('test', null, false, false, -7);
		$this->assertInstanceOf(FloatColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` FLOAT NOT NULL DEFAULT -7', $column->getQuerySnippet());

		$column = new FloatColumn('test', null, false, false, '17.4');
		$this->assertInstanceOf(FloatColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` FLOAT NOT NULL DEFAULT 17.4', $column->getQuerySnippet());

		$this->expectException(\InvalidArgumentException::class);
		new FloatColumn('test', null, false, false, 'test');
	}
}
