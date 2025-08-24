<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use unrealization\TableColumns\TinyIntColumn;

class TinyIntColumnTest extends TestCase
{
	/**
	 * @covers unrealization\TableColumns\TinyIntColumn
	 * @covers unrealization\TableColumns\GenericColumn
	 */
	public function testTinyIntColumn()
	{
		$column = new TinyIntColumn('test');
		$this->assertInstanceOf(TinyIntColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` TINYINT NOT NULL', $column->getQuerySnippet());

		$column = new TinyIntColumn('test', false, false, false, -INF);
		$this->assertInstanceOf(TinyIntColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` TINYINT NOT NULL', $column->getQuerySnippet());

		$column = new TinyIntColumn('test', true, false, false, -INF);
		$this->assertInstanceOf(TinyIntColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` TINYINT UNSIGNED NOT NULL', $column->getQuerySnippet());

		$column = new TinyIntColumn('test', false, true, false, -INF);
		$this->assertInstanceOf(TinyIntColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` TINYINT', $column->getQuerySnippet());

		$column = new TinyIntColumn('test', false, false, false, 5);
		$this->assertInstanceOf(TinyIntColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` TINYINT NOT NULL DEFAULT 5', $column->getQuerySnippet());

		$column = new TinyIntColumn('test', false, false, false, '12');
		$this->assertInstanceOf(TinyIntColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` TINYINT NOT NULL DEFAULT 12', $column->getQuerySnippet());

		$this->expectException(\InvalidArgumentException::class);
		new TinyIntColumn('test', false, false, false, 'test');
	}
}
