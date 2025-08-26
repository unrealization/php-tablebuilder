<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use unrealization\TableColumns\LongTextColumn;

class LongTextColumnTest extends TestCase
{
	/**
	 * @covers unrealization\TableColumns\LongTextColumn
	 * @covers unrealization\TableColumns\GenericColumn
	 */
	public function testLongTextColumn()
	{
		$column = new LongTextColumn('test');
		$this->assertInstanceOf(LongTextColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` LONGTEXT NOT NULL', $column->getQuerySnippet());

		$column = new LongTextColumn('test', false, null, null, -INF);
		$this->assertInstanceOf(LongTextColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` LONGTEXT NOT NULL', $column->getQuerySnippet());

		$column = new LongTextColumn('test', true, null, null, -INF);
		$this->assertInstanceOf(LongTextColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` LONGTEXT', $column->getQuerySnippet());

		$column = new LongTextColumn('test', false, 'utf8mb4', null, -INF);
		$this->assertInstanceOf(LongTextColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` LONGTEXT NOT NULL CHARACTER SET utf8mb4', $column->getQuerySnippet());

		$column = new LongTextColumn('test', false, null, 'utf8mb4_0900_ai_ci', -INF);
		$this->assertInstanceOf(LongTextColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` LONGTEXT NOT NULL COLLATE utf8mb4_0900_ai_ci', $column->getQuerySnippet());

		$column = new LongTextColumn('test', false, 'utf8mb4', 'utf8mb4_0900_ai_ci', -INF);
		$this->assertInstanceOf(LongTextColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` LONGTEXT NOT NULL CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci', $column->getQuerySnippet());

		$column = new LongTextColumn('test', true, null, null, null);
		$this->assertInstanceOf(LongTextColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` LONGTEXT DEFAULT NULL', $column->getQuerySnippet());

		$column = new LongTextColumn('test', false, null, null, 'test');
		$this->assertInstanceOf(LongTextColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` LONGTEXT NOT NULL DEFAULT \'test\'', $column->getQuerySnippet());

		$column = new LongTextColumn('test', false, null, null, 19);
		$this->assertInstanceOf(LongTextColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` LONGTEXT NOT NULL DEFAULT \'19\'', $column->getQuerySnippet());
	}
}
