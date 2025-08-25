<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use unrealization\TableColumns\DecimalColumn;

class DecimalColumnTest extends TestCase
{
	/**
	 * @covers unrealization\TableColumns\DecimalColumn
	 * @covers unrealization\TableColumns\GenericColumn
	 */
	public function testDecimalColumn()
	{
		$column = new DecimalColumn('test');
		$this->assertInstanceOf(DecimalColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` DECIMAL NOT NULL', $column->getQuerySnippet());

		$column = new DecimalColumn('test', null, null, false, false, -INF);
		$this->assertInstanceOf(DecimalColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` DECIMAL NOT NULL', $column->getQuerySnippet());

		$column = new DecimalColumn('test', 10, null, false, false, -INF);
		$this->assertInstanceOf(DecimalColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` DECIMAL(10) NOT NULL', $column->getQuerySnippet());

		$column = new DecimalColumn('test', 12, 4, false, false, -INF);
		$this->assertInstanceOf(DecimalColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` DECIMAL(12,4) NOT NULL', $column->getQuerySnippet());

		$column = new DecimalColumn('test', null, null, true, false, -INF);
		$this->assertInstanceOf(DecimalColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` DECIMAL UNSIGNED NOT NULL', $column->getQuerySnippet());

		$column = new DecimalColumn('test', null, null, false, true, -INF);
		$this->assertInstanceOf(DecimalColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` DECIMAL', $column->getQuerySnippet());

		$column = new DecimalColumn('test', null, null, false, true, null);
		$this->assertInstanceOf(DecimalColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` DECIMAL DEFAULT NULL', $column->getQuerySnippet());

		$column = new DecimalColumn('test', null, null, false, false, -7);
		$this->assertInstanceOf(DecimalColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` DECIMAL NOT NULL DEFAULT -7', $column->getQuerySnippet());

		$column = new DecimalColumn('test', null, null, false, false, '17.4');
		$this->assertInstanceOf(DecimalColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` DECIMAL NOT NULL DEFAULT 17.4', $column->getQuerySnippet());

		$this->expectException(\InvalidArgumentException::class);
		new DecimalColumn('test', null, null, false, false, 'test');
	}
}
