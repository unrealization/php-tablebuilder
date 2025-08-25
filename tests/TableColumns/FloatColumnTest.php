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

		$column = new FloatColumn('test', false, false, -INF);
		$this->assertInstanceOf(FloatColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` FLOAT NOT NULL', $column->getQuerySnippet());

		$column = new FloatColumn('test', true, false, -INF);
		$this->assertInstanceOf(FloatColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` FLOAT UNSIGNED NOT NULL', $column->getQuerySnippet());

		$column = new FloatColumn('test', false, true, -INF);
		$this->assertInstanceOf(FloatColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` FLOAT', $column->getQuerySnippet());

		$column = new FloatColumn('test', false, true, null);
		$this->assertInstanceOf(FloatColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` FLOAT DEFAULT NULL', $column->getQuerySnippet());

		$column = new FloatColumn('test', false, false, -7);
		$this->assertInstanceOf(FloatColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` FLOAT NOT NULL DEFAULT -7', $column->getQuerySnippet());

		$column = new FloatColumn('test', false, false, '17.4');
		$this->assertInstanceOf(FloatColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` FLOAT NOT NULL DEFAULT 17.4', $column->getQuerySnippet());

		$this->expectException(\InvalidArgumentException::class);
		new FloatColumn('test', false, false, 'test');
	}
}
