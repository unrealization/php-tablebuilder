<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use unrealization\TableColumns\EnumColumn;

class EnumColumnTest extends TestCase
{
	/**
	 * @covers unrealization\TableColumns\EnumColumn
	 * @covers unrealization\TableColumns\GenericColumn
	 */
	public function testEnumColumn()
	{
		$column = new EnumColumn('test', array('value1', 'value2'));
		$this->assertInstanceOf(EnumColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` ENUM(\'value1\',\'value2\') NOT NULL', $column->getQuerySnippet());

		$column = new EnumColumn('test', array('value1', 'value2'), false, null, null, -INF);
		$this->assertInstanceOf(EnumColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` ENUM(\'value1\',\'value2\') NOT NULL', $column->getQuerySnippet());

		$column = new EnumColumn('test', array('value1', 'value2'), true, null, null, -INF);
		$this->assertInstanceOf(EnumColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` ENUM(\'value1\',\'value2\')', $column->getQuerySnippet());

		$column = new EnumColumn('test', array('value1', 'value2'), false, 'utf8mb4', null, -INF);
		$this->assertInstanceOf(EnumColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` ENUM(\'value1\',\'value2\') NOT NULL CHARACTER SET utf8mb4', $column->getQuerySnippet());

		$column = new EnumColumn('test', array('value1', 'value2'), false, null, 'utf8mb4_0900_ai_ci', -INF);
		$this->assertInstanceOf(EnumColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` ENUM(\'value1\',\'value2\') NOT NULL COLLATE utf8mb4_0900_ai_ci', $column->getQuerySnippet());

		$column = new EnumColumn('test', array('value1', 'value2'), false, 'utf8mb4', 'utf8mb4_0900_ai_ci', -INF);
		$this->assertInstanceOf(EnumColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` ENUM(\'value1\',\'value2\') NOT NULL CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci', $column->getQuerySnippet());

		$column = new EnumColumn('test', array('value1', 'value2'), true, null, null, null);
		$this->assertInstanceOf(EnumColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` ENUM(\'value1\',\'value2\') DEFAULT NULL', $column->getQuerySnippet());

		$column = new EnumColumn('test', array('value1', 'value2'), false, null, null, 'test');
		$this->assertInstanceOf(EnumColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` ENUM(\'value1\',\'value2\') NOT NULL DEFAULT \'test\'', $column->getQuerySnippet());

		$column = new EnumColumn('test', array('value1', 'value2'), false, null, null, 19);
		$this->assertInstanceOf(EnumColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` ENUM(\'value1\',\'value2\') NOT NULL DEFAULT \'19\'', $column->getQuerySnippet());
	}
}
