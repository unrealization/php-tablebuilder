<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use unrealization\TableColumns\GenericColumn;
use unrealization\TableBuilder;
use unrealization\TableIndexes\GenericIndex;
use unrealization\ComponentActions\ColumnAction;
use unrealization\ComponentActions\IndexAction;
use unrealization\TableActions\CreateTable;
use unrealization\TableColumns\IntegerColumn;
use unrealization\TableIndexes\Index;

class TableActionTest extends TestCase
{
	/**
	 * @covers unrealization\TableActions\TableAction
	 * @uses unrealization\TableBuilder
	 */
	public function testInvalidTableName()
	{
		$this->expectException(\InvalidArgumentException::class);
		$table = TableBuilder::create('test?');
	}

	/**
	 * @covers unrealization\TableActions\TableAction
	 * @uses unrealization\ComponentActions\ColumnAction
	 * @uses unrealization\TableBuilder
	 * @uses unrealization\TableColumns\IntegerColumn
	 * @uses unrealization\TableColumns\GenericColumn
	 */
	public function testDuplicateColumnName()
	{
		$column = new IntegerColumn('test');
		$this->expectException(\Exception::class);
		$table = TableBuilder::create('test')->addColumn($column)->addColumn($column);
	}

	/**
	 * @covers unrealization\TableActions\TableAction
	 * @uses unrealization\ComponentActions\IndexAction
	 * @uses unrealization\TableBuilder
	 * @uses unrealization\TableIndexes\Index
	 * @uses unrealization\TableIndexes\GenericIndex
	 */
	public function testDuplicateIndexName()
	{
		$index = new Index(array(), 'test');
		$this->expectException(\Exception::class);
		$table = TableBuilder::create('test')->addIndex($index)->addIndex($index);
	}

	/**
	 * @covers unrealization\TableActions\TableAction
	 * @uses unrealization\TableColumns\IntegerColumn
	 * @uses unrealization\TableColumns\GenericColumn
	 * @uses unrealization\ComponentActions\ColumnAction
	 * @uses unrealization\TableBuilder
	 */
	public function testAddColumn()
	{
		$column = new IntegerColumn('test1');
		$columnAction = new ColumnAction(new IntegerColumn('test2'));
		$table = TableBuilder::create('test')->addColumn($column)->addColumn($columnAction);
		$this->assertInstanceOf(CreateTable::class, $table);
	}

	/**
	 * @covers unrealization\TableActions\TableAction
	 * @uses unrealization\TableIndexes\Index
	 * @uses unrealization\TableIndexes\GenericIndex
	 * @uses unrealization\ComponentActions\IndexAction
	 * @uses unrealization\TableBuilder
	 */
	public function testAddIndex()
	{
		$index = new Index(array(), 'test1');
		$indexAction = new IndexAction(new Index(array(), 'test2'));
		$table = TableBuilder::create('test')->addIndex($index)->addIndex($indexAction);
		$this->assertInstanceOf(CreateTable::class, $table);
	}
}
