<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use unrealization\TableBuilder;

class AlterTableTest extends TestCase
{
	/**
	 * @covers unrealization\TableActions\AlterTable
	 * @uses unrealization\TableBuilder
	 * @uses unrealization\TableActions\TableAction
	 */
	public function testGetQueryInvalid()
	{
		$this->expectException(\Exception::class);
		TableBuilder::alter('test')->getQuery();
	}

	/**
	 * @covers unrealization\TableActions\AlterTable
	 * @uses unrealization\TableBuilder
	 * @uses unrealization\ComponentActions\ColumnAction
	 * @uses unrealization\ComponentActions\IndexAction
	 * @uses unrealization\TableActions\TableAction
	 * @uses unrealization\TableColumns\IntColumn
	 * @uses unrealization\TableColumns\GenericColumn
	 * @uses unrealization\TableColumns\TextColumn
	 * @uses unrealization\TableIndexes\FullTextIndex
	 * @uses unrealization\TableIndexes\GenericIndex
	 */
	public function testGetQuery()
	{
		$query = TableBuilder::alter('test', 'utf8mb4', 'utf8mb4_0900_ai_ci')
			->text('content')
			->fullTextIndex('content')
			->getQuery();
		$this->assertSame('ALTER TABLE `test` DEFAULT CHARACTER SET utf8mb4 COLLATE=utf8mb4_0900_ai_ci, ADD COLUMN `content` TEXT NOT NULL, ADD FULLTEXT `FULLTEXT_content` (`content`);', $query);
	}

	/**
	 * @covers unrealization\TableActions\AlterTable
	 * @uses unrealization\TableBuilder
	 * @uses unrealization\ComponentActions\ColumnAction
	 * @uses unrealization\ComponentActions\IndexAction
	 * @uses unrealization\TableActions\TableAction
	 * @uses unrealization\TableColumns\IntColumn
	 * @uses unrealization\TableColumns\GenericColumn
	 * @uses unrealization\TableColumns\TextColumn
	 * @uses unrealization\TableIndexes\FullTextIndex
	 * @uses unrealization\TableIndexes\GenericIndex
	 */
	public function testRename()
	{
		$query = TableBuilder::alter('test', 'utf8mb4', 'utf8mb4_0900_ai_ci')
			->text('content')
			->fullTextIndex('content')
			->rename('test2')
			->getQuery();
		$this->assertSame('ALTER TABLE `test` DEFAULT CHARACTER SET utf8mb4 COLLATE=utf8mb4_0900_ai_ci, ADD COLUMN `content` TEXT NOT NULL, ADD FULLTEXT `FULLTEXT_content` (`content`), RENAME TO `test2`;', $query);
	}
}
