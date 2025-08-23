<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use unrealization\TableBuilder;
use unrealization\TableActions\CreateTable;
use unrealization\TableActions\AlterTable;
use unrealization\TableActions\DropTable;

class TableBuilderTest extends TestCase
{
	/**
	 * @covers unrealization\TableBuilder
	 * @uses unrealization\TableActions\TableAction
	 */
	public function testCreate()
	{
		$table = TableBuilder::create('test');
		$this->assertInstanceOf(CreateTable::class, $table);
	}

	/**
	 * @covers unrealization\TableBuilder
	 * @uses unrealization\TableActions\TableAction
	 */
	public function testAlter()
	{
		$table = TableBuilder::alter('test');
		$this->assertInstanceOf(AlterTable::class, $table);
	}

	/**
	 * @covers unrealization\TableBuilder
	 * @uses unrealization\TableActions\TableAction
	 */
	public function testDrop()
	{
		$table = TableBuilder::drop('test');
		$this->assertInstanceOf(DropTable::class, $table);
	}
}
