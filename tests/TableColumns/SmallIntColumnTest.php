<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use unrealization\TableColumns\SmallIntColumn;

class SmallIntColumnTest extends TestCase
{
	/**
	 * @covers unrealization\TableColumns\SmallIntColumn
	 * @covers unrealization\TableColumns\GenericColumn
	 */
	public function testSmallIntColumn()
	{
		$column = new SmallIntColumn('test');
		$this->assertInstanceOf(SmallIntColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` SMALLINT NOT NULL', $column->getQuerySnippet());

		$column = new SmallIntColumn('test', false, false, false, -INF);
		$this->assertInstanceOf(SmallIntColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` SMALLINT NOT NULL', $column->getQuerySnippet());

		$column = new SmallIntColumn('test', true, false, false, -INF);
		$this->assertInstanceOf(SmallIntColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` SMALLINT UNSIGNED NOT NULL', $column->getQuerySnippet());

		$column = new SmallIntColumn('test', false, true, false, -INF);
		$this->assertInstanceOf(SmallIntColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` SMALLINT', $column->getQuerySnippet());

		$column = new SmallIntColumn('test', false, false, false, 5);
		$this->assertInstanceOf(SmallIntColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` SMALLINT NOT NULL DEFAULT 5', $column->getQuerySnippet());

		$column = new SmallIntColumn('test', false, false, false, '12');
		$this->assertInstanceOf(SmallIntColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` SMALLINT NOT NULL DEFAULT 12', $column->getQuerySnippet());

		$this->expectException(\InvalidArgumentException::class);
		new SmallIntColumn('test', false, false, false, 'test');
	}
}
