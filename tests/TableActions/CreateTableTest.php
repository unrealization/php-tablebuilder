<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use unrealization\TableBuilder;

class CreateTableTest extends TestCase
{
	/**
	 * @covers unrealization\TableActions\CreateTable
	 * @uses unrealization\TableBuilder
	 * @uses unrealization\TableActions\TableAction
	 */
	public function testGetQueryInvalid()
	{
		$this->expectException(\Exception::class);
		TableBuilder::create('test')->getQuery();
	}

	/**
	 * @covers unrealization\TableActions\CreateTable
	 * @uses unrealization\TableBuilder
	 * @uses unrealization\ComponentActions\ColumnAction
	 * @uses unrealization\ComponentActions\IndexAction
	 * @uses unrealization\TableActions\TableAction
	 * @uses unrealization\TableColumns\GenericColumn
	 * @uses unrealization\TableColumns\IntegerColumn
	 * @uses unrealization\TableIndexes\GenericIndex
	 * @uses unrealization\TableIndexes\PrimaryKey
	 */
	public function testGetQuery()
	{
		$query = TableBuilder::create('test', 'utf8mb4', 'utf8mb4_0900_ai_ci')
			->int('id', true, autoIncrement: true)
			->primaryKey('id')
			->getQuery();
		$this->assertSame('CREATE TABLE `test` (`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,PRIMARY KEY (`id`)) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;', $query);
	}
}
