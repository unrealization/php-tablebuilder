<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use unrealization\TableColumns\MediumTextColumn;

class MediumTextColumnTest extends TestCase
{
	/**
	 * @covers unrealization\TableColumns\MediumTextColumn
	 * @covers unrealization\TableColumns\GenericColumn
	 */
	public function testMediumTextColumn()
	{
		$column = new MediumTextColumn('test');
		$this->assertInstanceOf(MediumTextColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` MEDIUMTEXT NOT NULL', $column->getQuerySnippet());

		$column = new MediumTextColumn('test', false, null, null, -INF);
		$this->assertInstanceOf(MediumTextColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` MEDIUMTEXT NOT NULL', $column->getQuerySnippet());

		$column = new MediumTextColumn('test', true, null, null, -INF);
		$this->assertInstanceOf(MediumTextColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` MEDIUMTEXT', $column->getQuerySnippet());

		$column = new MediumTextColumn('test', false, 'utf8mb4', null, -INF);
		$this->assertInstanceOf(MediumTextColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` MEDIUMTEXT NOT NULL CHARACTER SET utf8mb4', $column->getQuerySnippet());

		$column = new MediumTextColumn('test', false, null, 'utf8mb4_0900_ai_ci', -INF);
		$this->assertInstanceOf(MediumTextColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` MEDIUMTEXT NOT NULL COLLATE utf8mb4_0900_ai_ci', $column->getQuerySnippet());

		$column = new MediumTextColumn('test', false, 'utf8mb4', 'utf8mb4_0900_ai_ci', -INF);
		$this->assertInstanceOf(MediumTextColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` MEDIUMTEXT NOT NULL CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci', $column->getQuerySnippet());

		$column = new MediumTextColumn('test', true, null, null, null);
		$this->assertInstanceOf(MediumTextColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` MEDIUMTEXT DEFAULT NULL', $column->getQuerySnippet());

		$column = new MediumTextColumn('test', false, null, null, 'test');
		$this->assertInstanceOf(MediumTextColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` MEDIUMTEXT NOT NULL DEFAULT \'test\'', $column->getQuerySnippet());

		$column = new MediumTextColumn('test', false, null, null, 19);
		$this->assertInstanceOf(MediumTextColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` MEDIUMTEXT NOT NULL DEFAULT \'19\'', $column->getQuerySnippet());
	}
}
