<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use unrealization\TableColumns\BigIntColumn;

class BigIntColumnTest extends TestCase
{
	/**
	 * @covers unrealization\TableColumns\BigIntColumn
	 * @covers unrealization\TableColumns\GenericColumn
	 */
	public function testBigIntColumn()
	{
		$column = new BigIntColumn('test');
		$this->assertInstanceOf(BigIntColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` BIGINT NOT NULL', $column->getQuerySnippet());

		$column = new BigIntColumn('test', false, false, false, -INF);
		$this->assertInstanceOf(BigIntColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` BIGINT NOT NULL', $column->getQuerySnippet());

		$column = new BigIntColumn('test', true, false, false, -INF);
		$this->assertInstanceOf(BigIntColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` BIGINT UNSIGNED NOT NULL', $column->getQuerySnippet());

		$column = new BigIntColumn('test', false, true, false, -INF);
		$this->assertInstanceOf(BigIntColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` BIGINT', $column->getQuerySnippet());

		$column = new BigIntColumn('test', false, false, false, 5);
		$this->assertInstanceOf(BigIntColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` BIGINT NOT NULL DEFAULT 5', $column->getQuerySnippet());

		$column = new BigIntColumn('test', false, false, false, '12');
		$this->assertInstanceOf(BigIntColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` BIGINT NOT NULL DEFAULT 12', $column->getQuerySnippet());

		$this->expectException(\InvalidArgumentException::class);
		new BigIntColumn('test', false, false, false, 'test');
	}
}
