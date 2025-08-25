<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use unrealization\TableColumns\VarCharColumn;

class VarCharColumnTest extends TestCase
{
	/**
	 * @covers unrealization\TableColumns\VarCharColumn
	 * @covers unrealization\TableColumns\GenericColumn
	 */
	public function testVarCharColumn()
	{
		$column = new VarCharColumn('test', 64);
		$this->assertInstanceOf(VarCharColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` VARCHAR(64) NOT NULL', $column->getQuerySnippet());

		$column = new VarCharColumn('test', 64, false, null, null, -INF);
		$this->assertInstanceOf(VarCharColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` VARCHAR(64) NOT NULL', $column->getQuerySnippet());

		$column = new VarCharColumn('test', 64, true, null, null, -INF);
		$this->assertInstanceOf(VarCharColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` VARCHAR(64)', $column->getQuerySnippet());

		$column = new VarCharColumn('test', 64, false, 'utf8mb4', null, -INF);
		$this->assertInstanceOf(VarCharColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` VARCHAR(64) NOT NULL CHARACTER SET utf8mb4', $column->getQuerySnippet());

		$column = new VarCharColumn('test', 64, false, null, 'utf8mb4_0900_ai_ci', -INF);
		$this->assertInstanceOf(VarCharColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` VARCHAR(64) NOT NULL COLLATE utf8mb4_0900_ai_ci', $column->getQuerySnippet());

		$column = new VarCharColumn('test', 64, false, 'utf8mb4', 'utf8mb4_0900_ai_ci', -INF);
		$this->assertInstanceOf(VarCharColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` VARCHAR(64) NOT NULL CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci', $column->getQuerySnippet());

		$column = new VarCharColumn('test', 64, true, null, null, null);
		$this->assertInstanceOf(VarCharColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` VARCHAR(64) DEFAULT NULL', $column->getQuerySnippet());

		$column = new VarCharColumn('test', 64, false, null, null, 'test');
		$this->assertInstanceOf(VarCharColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` VARCHAR(64) NOT NULL DEFAULT \'test\'', $column->getQuerySnippet());

		$column = new VarCharColumn('test', 64, false, null, null, 19);
		$this->assertInstanceOf(VarCharColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` VARCHAR(64) NOT NULL DEFAULT \'19\'', $column->getQuerySnippet());
	}
}
