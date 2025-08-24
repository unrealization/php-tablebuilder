<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use unrealization\TableColumns\MediumIntColumn;

class MediumIntColumnTest extends TestCase
{
	/**
	 * @covers unrealization\TableColumns\MediumIntColumn
	 * @covers unrealization\TableColumns\GenericColumn
	 */
	public function testMediumIntColumn()
	{
		$column = new MediumIntColumn('test');
		$this->assertInstanceOf(MediumIntColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` MEDIUMINT NOT NULL', $column->getQuerySnippet());

		$column = new MediumIntColumn('test', false, false, false, -INF);
		$this->assertInstanceOf(MediumIntColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` MEDIUMINT NOT NULL', $column->getQuerySnippet());

		$column = new MediumIntColumn('test', true, false, false, -INF);
		$this->assertInstanceOf(MediumIntColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` MEDIUMINT UNSIGNED NOT NULL', $column->getQuerySnippet());

		$column = new MediumIntColumn('test', false, true, false, -INF);
		$this->assertInstanceOf(MediumIntColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` MEDIUMINT', $column->getQuerySnippet());

		$column = new MediumIntColumn('test', false, false, false, 5);
		$this->assertInstanceOf(MediumIntColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` MEDIUMINT NOT NULL DEFAULT 5', $column->getQuerySnippet());

		$column = new MediumIntColumn('test', false, false, false, '12');
		$this->assertInstanceOf(MediumIntColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` MEDIUMINT NOT NULL DEFAULT 12', $column->getQuerySnippet());

		$this->expectException(\InvalidArgumentException::class);
		new MediumIntColumn('test', false, false, false, 'test');
	}
}
