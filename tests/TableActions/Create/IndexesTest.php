<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use unrealization\TableBuilder;
use unrealization\TableActions\CreateTable;
use unrealization\TableColumns\GenericColumn;
use unrealization\TableColumns\IntColumn;
use unrealization\TableColumns\VarCharColumn;

class CreateIndexesTest extends TestCase
{
	/**
	 * @covers unrealization\TableActions\Create\Indexes
	 * @uses unrealization\TableActions\TableAction
	 * @uses unrealization\ComponentActions\IndexAction
	 * @uses unrealization\TableBuilder
	 * @uses unrealization\TableIndexes\GenericIndex
	 * @uses unrealization\TableColumns\IntColumn
	 * @uses unrealization\TableColumns\GenericColumn
	 * @uses unrealization\ComponentActions\ColumnAction
	 * @uses unrealization\TableActions\CreateTable
	 * @uses unrealization\TableActions\Create\Columns
	 * @uses unrealization\TableColumns\VarCharColumn
	 * @uses unrealization\TableIndexes\FullTextIndex
	 */
	public function testFullTextIndex()
	{
		$table = TableBuilder::create('test')->varchar('test', 32)->fullTextIndex('test');
		$this->assertInstanceOf(CreateTable::class, $table);
		$this->assertSame('CREATE TABLE `test` (`test` VARCHAR(32) NOT NULL,FULLTEXT `FULLTEXT_test` (`test`));', $table->getQuery());

		$table = TableBuilder::create('test')->varchar('test', 32)->fullTextIndex('test', null);
		$this->assertInstanceOf(CreateTable::class, $table);
		$this->assertSame('CREATE TABLE `test` (`test` VARCHAR(32) NOT NULL,FULLTEXT `FULLTEXT_test` (`test`));', $table->getQuery());

		$table = TableBuilder::create('test')->varchar('test', 32)->fullTextIndex(new IntColumn('test'), null);
		$this->assertInstanceOf(CreateTable::class, $table);
		$this->assertSame('CREATE TABLE `test` (`test` VARCHAR(32) NOT NULL,FULLTEXT `FULLTEXT_test` (`test`));', $table->getQuery());

		$table = TableBuilder::create('test')->varchar('test', 32)->fullTextIndex(array('test1', new IntColumn('test2')), null);
		$this->assertInstanceOf(CreateTable::class, $table);
		$this->assertSame('CREATE TABLE `test` (`test` VARCHAR(32) NOT NULL,FULLTEXT `FULLTEXT_test1_test2` (`test1`,`test2`));', $table->getQuery());

		$table = TableBuilder::create('test')->varchar('test', 32)->fullTextIndex('test', 'test_index');
		$this->assertInstanceOf(CreateTable::class, $table);
		$this->assertSame('CREATE TABLE `test` (`test` VARCHAR(32) NOT NULL,FULLTEXT `test_index` (`test`));', $table->getQuery());
	}

	/**
	 * @covers unrealization\TableActions\Create\Indexes
	 * @uses unrealization\TableActions\TableAction
	 * @uses unrealization\ComponentActions\IndexAction
	 * @uses unrealization\TableBuilder
	 * @uses unrealization\TableIndexes\GenericIndex
	 * @uses unrealization\TableColumns\IntColumn
	 * @uses unrealization\TableColumns\GenericColumn
	 * @uses unrealization\ComponentActions\ColumnAction
	 * @uses unrealization\TableActions\CreateTable
	 * @uses unrealization\TableActions\Create\Columns
	 * @uses unrealization\TableColumns\VarCharColumn
	 * @uses unrealization\TableIndexes\Index
	 */
	public function testIndex()
	{
		$table = TableBuilder::create('test')->varchar('test', 32)->index('test');
		$this->assertInstanceOf(CreateTable::class, $table);
		$this->assertSame('CREATE TABLE `test` (`test` VARCHAR(32) NOT NULL,INDEX `INDEX_test` (`test`));', $table->getQuery());

		$table = TableBuilder::create('test')->varchar('test', 32)->index('test', null);
		$this->assertInstanceOf(CreateTable::class, $table);
		$this->assertSame('CREATE TABLE `test` (`test` VARCHAR(32) NOT NULL,INDEX `INDEX_test` (`test`));', $table->getQuery());

		$table = TableBuilder::create('test')->varchar('test', 32)->index(new IntColumn('test'), null);
		$this->assertInstanceOf(CreateTable::class, $table);
		$this->assertSame('CREATE TABLE `test` (`test` VARCHAR(32) NOT NULL,INDEX `INDEX_test` (`test`));', $table->getQuery());

		$table = TableBuilder::create('test')->varchar('test', 32)->index(array('test1', new IntColumn('test2')), null);
		$this->assertInstanceOf(CreateTable::class, $table);
		$this->assertSame('CREATE TABLE `test` (`test` VARCHAR(32) NOT NULL,INDEX `INDEX_test1_test2` (`test1`,`test2`));', $table->getQuery());

		$table = TableBuilder::create('test')->varchar('test', 32)->index('test', 'test_index');
		$this->assertInstanceOf(CreateTable::class, $table);
		$this->assertSame('CREATE TABLE `test` (`test` VARCHAR(32) NOT NULL,INDEX `test_index` (`test`));', $table->getQuery());
	}

	/**
	 * @covers unrealization\TableActions\Create\Indexes
	 * @uses unrealization\TableActions\TableAction
	 * @uses unrealization\ComponentActions\IndexAction
	 * @uses unrealization\TableBuilder
	 * @uses unrealization\TableIndexes\GenericIndex
	 * @uses unrealization\TableColumns\GenericColumn
	 * @uses unrealization\ComponentActions\ColumnAction
	 * @uses unrealization\TableActions\CreateTable
	 * @uses unrealization\TableActions\Create\Columns
	 * @uses unrealization\TableColumns\IntColumn
	 * @uses unrealization\TableColumns\VarCharColumn
	 * @uses unrealization\TableIndexes\PrimaryKey
	 */
	public function testPrimaryKey()
	{
		$table = TableBuilder::create('test')->varchar('test', 32)->primaryKey('test');
		$this->assertInstanceOf(CreateTable::class, $table);
		$this->assertSame('CREATE TABLE `test` (`test` VARCHAR(32) NOT NULL,PRIMARY KEY (`test`));', $table->getQuery());

		$table = TableBuilder::create('test')->varchar('test', 32)->primaryKey(new VarCharColumn('test', 32));
		$this->assertInstanceOf(CreateTable::class, $table);
		$this->assertSame('CREATE TABLE `test` (`test` VARCHAR(32) NOT NULL,PRIMARY KEY (`test`));', $table->getQuery());

		$table = TableBuilder::create('test')->varchar('test', 32)->primaryKey(array('test1', new VarCharColumn('test2', 32)));
		$this->assertInstanceOf(CreateTable::class, $table);
		$this->assertSame('CREATE TABLE `test` (`test` VARCHAR(32) NOT NULL,PRIMARY KEY (`test1`,`test2`));', $table->getQuery());
	}

	/**
	 * @covers unrealization\TableActions\Create\Indexes
	 * @uses unrealization\TableActions\TableAction
	 * @uses unrealization\ComponentActions\IndexAction
	 * @uses unrealization\TableBuilder
	 * @uses unrealization\TableIndexes\GenericIndex
	 * @uses unrealization\TableColumns\IntColumn
	 * @uses unrealization\TableColumns\GenericColumn
	 * @uses unrealization\ComponentActions\ColumnAction
	 * @uses unrealization\TableActions\CreateTable
	 * @uses unrealization\TableActions\Create\Columns
	 * @uses unrealization\TableColumns\VarCharColumn
	 * @uses unrealization\TableIndexes\UniqueKey
	 */
	public function testUniqueKey()
	{
		$table = TableBuilder::create('test')->varchar('test', 32)->uniqueKey('test');
		$this->assertInstanceOf(CreateTable::class, $table);
		$this->assertSame('CREATE TABLE `test` (`test` VARCHAR(32) NOT NULL,UNIQUE KEY `UNIQUE_KEY_test` (`test`));', $table->getQuery());

		$table = TableBuilder::create('test')->varchar('test', 32)->uniqueKey('test', null);
		$this->assertInstanceOf(CreateTable::class, $table);
		$this->assertSame('CREATE TABLE `test` (`test` VARCHAR(32) NOT NULL,UNIQUE KEY `UNIQUE_KEY_test` (`test`));', $table->getQuery());

		$table = TableBuilder::create('test')->varchar('test', 32)->uniqueKey(new IntColumn('test'), null);
		$this->assertInstanceOf(CreateTable::class, $table);
		$this->assertSame('CREATE TABLE `test` (`test` VARCHAR(32) NOT NULL,UNIQUE KEY `UNIQUE_KEY_test` (`test`));', $table->getQuery());

		$table = TableBuilder::create('test')->varchar('test', 32)->uniqueKey(array('test1', new IntColumn('test2')), null);
		$this->assertInstanceOf(CreateTable::class, $table);
		$this->assertSame('CREATE TABLE `test` (`test` VARCHAR(32) NOT NULL,UNIQUE KEY `UNIQUE_KEY_test1_test2` (`test1`,`test2`));', $table->getQuery());

		$table = TableBuilder::create('test')->varchar('test', 32)->uniqueKey('test', 'test_index');
		$this->assertInstanceOf(CreateTable::class, $table);
		$this->assertSame('CREATE TABLE `test` (`test` VARCHAR(32) NOT NULL,UNIQUE KEY `test_index` (`test`));', $table->getQuery());
	}
}
