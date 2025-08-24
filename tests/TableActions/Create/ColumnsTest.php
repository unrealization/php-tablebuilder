<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use unrealization\TableBuilder;
use unrealization\TableActions\CreateTable;

class CreateColumnsTest extends TestCase
{
	/**
	 * @covers unrealization\TableActions\Create\Columns
	 * @uses unrealization\TableActions\TableAction
	 * @uses unrealization\ComponentActions\ColumnAction
	 * @uses unrealization\TableBuilder
	 * @uses unrealization\TableColumns\GenericColumn
	 * @uses unrealization\TableActions\CreateTable
	 * @uses unrealization\TableColumns\BigIntColumn
	 */
	public function testBigint()
	{
		$table = TableBuilder::create('test')->bigint('test', false, false, false, -INF);
		$this->assertInstanceOf(CreateTable::class, $table);
		$this->assertSame('CREATE TABLE `test` (`test` BIGINT NOT NULL);', $table->getQuery());
	}

	/**
	 * @covers unrealization\TableActions\Create\Columns
	 * @uses unrealization\TableActions\TableAction
	 * @uses unrealization\ComponentActions\ColumnAction
	 * @uses unrealization\TableBuilder
	 * @uses unrealization\TableColumns\GenericColumn
	 * @uses unrealization\TableActions\CreateTable
	 * @uses unrealization\TableColumns\DateColumn
	 */
	public function testDate()
	{
		$table = TableBuilder::create('test')->date('test', false, -INF);
		$this->assertInstanceOf(CreateTable::class, $table);
		$this->assertSame('CREATE TABLE `test` (`test` DATE NOT NULL);', $table->getQuery());
	}

	/**
	 * @covers unrealization\TableActions\Create\Columns
	 * @uses unrealization\TableActions\TableAction
	 * @uses unrealization\ComponentActions\ColumnAction
	 * @uses unrealization\TableBuilder
	 * @uses unrealization\TableColumns\GenericColumn
	 * @uses unrealization\TableActions\CreateTable
	 * @uses unrealization\TableColumns\DateTimeColumn
	 */
	public function testDatetime()
	{
		$table = TableBuilder::create('test')->datetime('test', false, -INF);
		$this->assertInstanceOf(CreateTable::class, $table);
		$this->assertSame('CREATE TABLE `test` (`test` DATETIME NOT NULL);', $table->getQuery());
	}

	/**
	 * @covers unrealization\TableActions\Create\Columns
	 * @uses unrealization\TableActions\TableAction
	 * @uses unrealization\ComponentActions\ColumnAction
	 * @uses unrealization\TableBuilder
	 * @uses unrealization\TableColumns\GenericColumn
	 * @uses unrealization\TableActions\CreateTable
	 * @uses unrealization\TableColumns\DecimalColumn
	 */
	public function testDecimal()
	{
		$table = TableBuilder::create('test')->decimal('test', null, null, false, false, -INF);
		$this->assertInstanceOf(CreateTable::class, $table);
		$this->assertSame('CREATE TABLE `test` (`test` DECIMAL NOT NULL);', $table->getQuery());
	}

	/**
	 * @covers unrealization\TableActions\Create\Columns
	 * @uses unrealization\TableActions\TableAction
	 * @uses unrealization\ComponentActions\ColumnAction
	 * @uses unrealization\TableBuilder
	 * @uses unrealization\TableColumns\GenericColumn
	 * @uses unrealization\TableActions\CreateTable
	 * @uses unrealization\TableColumns\DoubleColumn
	 */
	public function testDouble()
	{
		$table = TableBuilder::create('test')->double('test', false, false, -INF);
		$this->assertInstanceOf(CreateTable::class, $table);
		$this->assertSame('CREATE TABLE `test` (`test` DOUBLE NOT NULL);', $table->getQuery());
	}

	/**
	 * @covers unrealization\TableActions\Create\Columns
	 * @uses unrealization\TableActions\TableAction
	 * @uses unrealization\ComponentActions\ColumnAction
	 * @uses unrealization\TableBuilder
	 * @uses unrealization\TableColumns\GenericColumn
	 * @uses unrealization\TableActions\CreateTable
	 * @uses unrealization\TableColumns\FloatColumn
	 */
	public function testFloat()
	{
		$table = TableBuilder::create('test')->float('test', false, false, -INF);
		$this->assertInstanceOf(CreateTable::class, $table);
		$this->assertSame('CREATE TABLE `test` (`test` FLOAT NOT NULL);', $table->getQuery());
	}

	/**
	 * @covers unrealization\TableActions\Create\Columns
	 * @uses unrealization\TableActions\TableAction
	 * @uses unrealization\ComponentActions\ColumnAction
	 * @uses unrealization\TableBuilder
	 * @uses unrealization\TableColumns\GenericColumn
	 * @uses unrealization\TableActions\CreateTable
	 * @uses unrealization\TableColumns\IntColumn
	 */
	public function testInt()
	{
		$table = TableBuilder::create('test')->int('test', false, false, false, -INF);
		$this->assertInstanceOf(CreateTable::class, $table);
		$this->assertSame('CREATE TABLE `test` (`test` INT NOT NULL);', $table->getQuery());
	}

	/**
	 * @covers unrealization\TableActions\Create\Columns
	 * @uses unrealization\TableActions\TableAction
	 * @uses unrealization\ComponentActions\ColumnAction
	 * @uses unrealization\TableBuilder
	 * @uses unrealization\TableColumns\GenericColumn
	 * @uses unrealization\TableActions\CreateTable
	 * @uses unrealization\TableColumns\MediumIntColumn
	 */
	public function testMediumint()
	{
		$table = TableBuilder::create('test')->mediumint('test', false, false, false, -INF);
		$this->assertInstanceOf(CreateTable::class, $table);
		$this->assertSame('CREATE TABLE `test` (`test` MEDIUMINT NOT NULL);', $table->getQuery());
	}

	/**
	 * @covers unrealization\TableActions\Create\Columns
	 * @uses unrealization\TableActions\TableAction
	 * @uses unrealization\ComponentActions\ColumnAction
	 * @uses unrealization\TableBuilder
	 * @uses unrealization\TableColumns\GenericColumn
	 * @uses unrealization\TableActions\CreateTable
	 * @uses unrealization\TableColumns\SmallIntColumn
	 */
	public function testSmallint()
	{
		$table = TableBuilder::create('test')->smallint('test', false, false, false, -INF);
		$this->assertInstanceOf(CreateTable::class, $table);
		$this->assertSame('CREATE TABLE `test` (`test` SMALLINT NOT NULL);', $table->getQuery());
	}

	/**
	 * @covers unrealization\TableActions\Create\Columns
	 * @uses unrealization\TableActions\TableAction
	 * @uses unrealization\ComponentActions\ColumnAction
	 * @uses unrealization\TableBuilder
	 * @uses unrealization\TableColumns\GenericColumn
	 * @uses unrealization\TableActions\CreateTable
	 * @uses unrealization\TableColumns\TextColumn
	 */
	public function testText()
	{
		$table = TableBuilder::create('test')->text('test', false, null, null, -INF);
		$this->assertInstanceOf(CreateTable::class, $table);
		$this->assertSame('CREATE TABLE `test` (`test` TEXT NOT NULL);', $table->getQuery());
	}

	/**
	 * @covers unrealization\TableActions\Create\Columns
	 * @uses unrealization\TableActions\TableAction
	 * @uses unrealization\ComponentActions\ColumnAction
	 * @uses unrealization\TableBuilder
	 * @uses unrealization\TableColumns\GenericColumn
	 * @uses unrealization\TableActions\CreateTable
	 * @uses unrealization\TableColumns\TimeColumn
	 */
	public function testTime()
	{
		$table = TableBuilder::create('test')->time('test', false, -INF);
		$this->assertInstanceOf(CreateTable::class, $table);
		$this->assertSame('CREATE TABLE `test` (`test` TIME NOT NULL);', $table->getQuery());
	}

	/**
	 * @covers unrealization\TableActions\Create\Columns
	 * @uses unrealization\TableActions\TableAction
	 * @uses unrealization\ComponentActions\ColumnAction
	 * @uses unrealization\TableBuilder
	 * @uses unrealization\TableColumns\GenericColumn
	 * @uses unrealization\TableActions\CreateTable
	 * @uses unrealization\TableColumns\TimeStampColumn
	 */
	public function testTimestamp()
	{
		$table = TableBuilder::create('test')->timestamp('test', false, -INF);
		$this->assertInstanceOf(CreateTable::class, $table);
		$this->assertSame('CREATE TABLE `test` (`test` TIMESTAMP NOT NULL);', $table->getQuery());
	}

	/**
	 * @covers unrealization\TableActions\Create\Columns
	 * @uses unrealization\TableActions\TableAction
	 * @uses unrealization\ComponentActions\ColumnAction
	 * @uses unrealization\TableBuilder
	 * @uses unrealization\TableColumns\GenericColumn
	 * @uses unrealization\TableActions\CreateTable
	 * @uses unrealization\TableColumns\TinyIntColumn
	 */
	public function testTinyint()
	{
		$table = TableBuilder::create('test')->tinyint('test', false, false, false, -INF);
		$this->assertInstanceOf(CreateTable::class, $table);
		$this->assertSame('CREATE TABLE `test` (`test` TINYINT NOT NULL);', $table->getQuery());
	}

	/**
	 * @covers unrealization\TableActions\Create\Columns
	 * @uses unrealization\TableActions\TableAction
	 * @uses unrealization\ComponentActions\ColumnAction
	 * @uses unrealization\TableBuilder
	 * @uses unrealization\TableColumns\GenericColumn
	 * @uses unrealization\TableActions\CreateTable
	 * @uses unrealization\TableColumns\VarCharColumn
	 */
	public function testVarchar()
	{
		$table = TableBuilder::create('test')->varchar('test', 32, false, null, null, -INF);
		$this->assertInstanceOf(CreateTable::class, $table);
		$this->assertSame('CREATE TABLE `test` (`test` VARCHAR(32) NOT NULL);', $table->getQuery());
	}
}
