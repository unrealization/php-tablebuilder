<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use unrealization\TableBuilder;
use unrealization\TableActions\AlterTable;
use unrealization\TableColumns\IntColumn;
use unrealization\TableColumns\VarCharColumn;

class AlterIndexesTest extends TestCase
{
	/**
	 * @covers unrealization\TableActions\Alter\Indexes
	 * @uses unrealization\TableActions\TableAction
	 * @uses unrealization\ComponentActions\IndexAction
	 * @uses unrealization\TableBuilder
	 * @uses unrealization\TableIndexes\Index
	 * @uses unrealization\TableIndexes\GenericIndex
	 * @uses unrealization\TableActions\AlterTable
	 */
	public function testDropIndex()
	{
		$table = TableBuilder::alter('test')->dropIndex('test');
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` DROP INDEX `test`;', $table->getQuery());
	}

	/**
	 * @covers unrealization\TableActions\Alter\Indexes
	 * @uses unrealization\TableActions\TableAction
	 * @uses unrealization\ComponentActions\IndexAction
	 * @uses unrealization\TableBuilder
	 * @uses unrealization\TableIndexes\GenericIndex
	 * @uses unrealization\TableActions\AlterTable
	 * @uses unrealization\TableIndexes\PrimaryKey
	 */
	public function testDropPrimaryKey()
	{
		$table = TableBuilder::alter('test')->dropPrimaryKey();
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` DROP PRIMARY KEY;', $table->getQuery());
	}

	/**
	 * @covers unrealization\TableActions\Alter\Indexes
	 * @uses unrealization\TableActions\TableAction
	 * @uses unrealization\ComponentActions\IndexAction
	 * @uses unrealization\TableBuilder
	 * @uses unrealization\TableColumns\VarCharColumn
	 * @uses unrealization\TableColumns\IntColumn
	 * @uses unrealization\TableColumns\GenericColumn
	 * @uses unrealization\TableIndexes\GenericIndex
	 * @uses unrealization\TableActions\AlterTable
	 * @uses unrealization\TableIndexes\FullTextIndex
	 */
	public function testFullTextIndex()
	{
		$table = TableBuilder::alter('test')->fullTextIndex('test');
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` ADD FULLTEXT `FULLTEXT_test` (`test`);', $table->getQuery());

		$table = TableBuilder::alter('test')->fullTextIndex('test', null);
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` ADD FULLTEXT `FULLTEXT_test` (`test`);', $table->getQuery());

		$table = TableBuilder::alter('test')->fullTextIndex(new VarCharColumn('test', 32), null);
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` ADD FULLTEXT `FULLTEXT_test` (`test`);', $table->getQuery());

		$table = TableBuilder::alter('test')->fullTextIndex(array('test1', new VarCharColumn('test2', 32)), null);
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` ADD FULLTEXT `FULLTEXT_test1_test2` (`test1`,`test2`);', $table->getQuery());

		$table = TableBuilder::alter('test')->fullTextIndex('test', 'test_index');
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` ADD FULLTEXT `test_index` (`test`);', $table->getQuery());
	}

	/**
	 * @covers unrealization\TableActions\Alter\Indexes
	 * @uses unrealization\TableActions\TableAction
	 * @uses unrealization\ComponentActions\IndexAction
	 * @uses unrealization\TableBuilder
	 * @uses unrealization\TableColumns\IntColumn
	 * @uses unrealization\TableColumns\GenericColumn
	 * @uses unrealization\TableIndexes\GenericIndex
	 * @uses unrealization\TableActions\AlterTable
	 * @uses unrealization\TableIndexes\Index
	 */
	public function testIndex()
	{
		$table = TableBuilder::alter('test')->index('test');
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` ADD INDEX `INDEX_test` (`test`);', $table->getQuery());;

		$table = TableBuilder::alter('test')->index('test', null);
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` ADD INDEX `INDEX_test` (`test`);', $table->getQuery());;

		$table = TableBuilder::alter('test')->index(new IntColumn('test'), null);
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` ADD INDEX `INDEX_test` (`test`);', $table->getQuery());;

		$table = TableBuilder::alter('test')->index(array('test1', new IntColumn('test2')), null);
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` ADD INDEX `INDEX_test1_test2` (`test1`,`test2`);', $table->getQuery());;

		$table = TableBuilder::alter('test')->index('test', 'test_index');
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` ADD INDEX `test_index` (`test`);', $table->getQuery());;
	}


	/**
	 * @covers unrealization\TableActions\Alter\Indexes
	 * @uses unrealization\TableActions\TableAction
	 * @uses unrealization\ComponentActions\IndexAction
	 * @uses unrealization\TableBuilder
	 * @uses unrealization\TableColumns\IntColumn
	 * @uses unrealization\TableColumns\GenericColumn
	 * @uses unrealization\TableIndexes\GenericIndex
	 * @uses unrealization\TableActions\AlterTable
	 * @uses unrealization\TableIndexes\PrimaryKey
	 */
	public function testPrimaryKey()
	{
		$table = TableBuilder::alter('test')->primaryKey('test');
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` ADD PRIMARY KEY (`test`);', $table->getQuery());

		$table = TableBuilder::alter('test')->primaryKey(new IntColumn('test'));
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` ADD PRIMARY KEY (`test`);', $table->getQuery());

		$table = TableBuilder::alter('test')->primaryKey(array('test1', new IntColumn('test2')));
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` ADD PRIMARY KEY (`test1`,`test2`);', $table->getQuery());
	}

	/**
	 * @covers unrealization\TableActions\Alter\Indexes
	 * @uses unrealization\TableActions\TableAction
	 * @uses unrealization\ComponentActions\IndexAction
	 * @uses unrealization\TableBuilder
	 * @uses unrealization\TableColumns\IntColumn
	 * @uses unrealization\TableColumns\GenericColumn
	 * @uses unrealization\TableIndexes\GenericIndex
	 * @uses unrealization\TableActions\AlterTable
	 * @uses unrealization\TableIndexes\UniqueKey
	 */
	public function testUniqueKey()
	{
		$table = TableBuilder::alter('test')->uniqueKey('test', null);
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` ADD UNIQUE KEY `UNIQUE_KEY_test` (`test`);', $table->getQuery());
	}
}
