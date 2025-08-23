<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use unrealization\TableColumns\BigIntegerColumn;

class BigIntegerColumnTest extends TestCase
{
	/**
	 * @covers unrealization\TableColumns\BigIntegerColumn
	 * @covers unrealization\TableColumns\GenericColumn
	 */
	public function testBigIntegerColumn()
	{
		$column = new BigIntegerColumn('test');
		$this->assertInstanceOf(BigIntegerColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` BIGINT NOT NULL', $column->getQuerySnippet());

		$column = new BigIntegerColumn('test', false, false, false, -INF);
		$this->assertInstanceOf(BigIntegerColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` BIGINT NOT NULL', $column->getQuerySnippet());

		$column = new BigIntegerColumn('test', true, false, false, -INF);
		$this->assertInstanceOf(BigIntegerColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` BIGINT UNSIGNED NOT NULL', $column->getQuerySnippet());

		$column = new BigIntegerColumn('test', false, true, false, -INF);
		$this->assertInstanceOf(BigIntegerColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` BIGINT', $column->getQuerySnippet());

		$column = new BigIntegerColumn('test', false, false, false, 5);
		$this->assertInstanceOf(BigIntegerColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` BIGINT NOT NULL DEFAULT 5', $column->getQuerySnippet());

		$column = new BigIntegerColumn('test', false, false, false, '12');
		$this->assertInstanceOf(BigIntegerColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` BIGINT NOT NULL DEFAULT 12', $column->getQuerySnippet());

		$this->expectException(\InvalidArgumentException::class);
		new BigIntegerColumn('test', false, false, false, 'test');
	}
}
