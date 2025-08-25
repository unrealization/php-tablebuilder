<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use unrealization\TableColumns\TextColumn;

class TextColumnTest extends TestCase
{
	/**
	 * @covers unrealization\TableColumns\TextColumn
	 * @covers unrealization\TableColumns\GenericColumn
	 */
	public function testTextColumn()
	{
		$column = new TextColumn('test');
		$this->assertInstanceOf(TextColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` TEXT NOT NULL', $column->getQuerySnippet());

		$column = new TextColumn('test', false, null, null, -INF);
		$this->assertInstanceOf(TextColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` TEXT NOT NULL', $column->getQuerySnippet());

		$column = new TextColumn('test', true, null, null, -INF);
		$this->assertInstanceOf(TextColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` TEXT', $column->getQuerySnippet());

		$column = new TextColumn('test', false, 'utf8mb4', null, -INF);
		$this->assertInstanceOf(TextColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` TEXT NOT NULL CHARACTER SET utf8mb4', $column->getQuerySnippet());

		$column = new TextColumn('test', false, null, 'utf8mb4_0900_ai_ci', -INF);
		$this->assertInstanceOf(TextColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` TEXT NOT NULL COLLATE utf8mb4_0900_ai_ci', $column->getQuerySnippet());

		$column = new TextColumn('test', false, 'utf8mb4', 'utf8mb4_0900_ai_ci', -INF);
		$this->assertInstanceOf(TextColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` TEXT NOT NULL CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci', $column->getQuerySnippet());

		$column = new TextColumn('test', true, null, null, null);
		$this->assertInstanceOf(TextColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` TEXT DEFAULT NULL', $column->getQuerySnippet());

		$column = new TextColumn('test', false, null, null, 'test');
		$this->assertInstanceOf(TextColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` TEXT NOT NULL DEFAULT \'test\'', $column->getQuerySnippet());

		$column = new TextColumn('test', false, null, null, 19);
		$this->assertInstanceOf(TextColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` TEXT NOT NULL DEFAULT \'19\'', $column->getQuerySnippet());
	}
}
