<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use unrealization\TableColumns\TinyTextColumn;

class TinyTextColumnTest extends TestCase
{
	/**
	 * @covers unrealization\TableColumns\TinyTextColumn
	 * @covers unrealization\TableColumns\GenericColumn
	 */
	public function testTinyTextColumn()
	{
		$column = new TinyTextColumn('test');
		$this->assertInstanceOf(TinyTextColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` TINYTEXT NOT NULL', $column->getQuerySnippet());

		$column = new TinyTextColumn('test', false, null, null, -INF);
		$this->assertInstanceOf(TinyTextColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` TINYTEXT NOT NULL', $column->getQuerySnippet());

		$column = new TinyTextColumn('test', true, null, null, -INF);
		$this->assertInstanceOf(TinyTextColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` TINYTEXT', $column->getQuerySnippet());

		$column = new TinyTextColumn('test', false, 'utf8mb4', null, -INF);
		$this->assertInstanceOf(TinyTextColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` TINYTEXT NOT NULL CHARACTER SET utf8mb4', $column->getQuerySnippet());

		$column = new TinyTextColumn('test', false, null, 'utf8mb4_0900_ai_ci', -INF);
		$this->assertInstanceOf(TinyTextColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` TINYTEXT NOT NULL COLLATE utf8mb4_0900_ai_ci', $column->getQuerySnippet());

		$column = new TinyTextColumn('test', false, 'utf8mb4', 'utf8mb4_0900_ai_ci', -INF);
		$this->assertInstanceOf(TinyTextColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` TINYTEXT NOT NULL CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci', $column->getQuerySnippet());

		$column = new TinyTextColumn('test', true, null, null, null);
		$this->assertInstanceOf(TinyTextColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` TINYTEXT DEFAULT NULL', $column->getQuerySnippet());

		$column = new TinyTextColumn('test', false, null, null, 'test');
		$this->assertInstanceOf(TinyTextColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` TINYTEXT NOT NULL DEFAULT \'test\'', $column->getQuerySnippet());

		$column = new TinyTextColumn('test', false, null, null, 19);
		$this->assertInstanceOf(TinyTextColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` TINYTEXT NOT NULL DEFAULT \'19\'', $column->getQuerySnippet());
	}
}
