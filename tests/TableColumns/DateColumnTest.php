<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use unrealization\TableColumns\DateColumn;

class DateColumnTest extends TestCase
{
	/**
	 * @covers unrealization\TableColumns\DateColumn
	 * @covers unrealization\TableColumns\GenericColumn
	 */
	public function testDateColumn()
	{
		$column = new DateColumn('test');
		$this->assertInstanceOf(DateColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` DATE NOT NULL', $column->getQuerySnippet());

		$column = new DateColumn('test', false, -INF);
		$this->assertInstanceOf(DateColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` DATE NOT NULL', $column->getQuerySnippet());

		$column = new DateColumn('test', true, -INF);
		$this->assertInstanceOf(DateColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` DATE', $column->getQuerySnippet());

		$date = new \DateTime('1996-04-30 18:00:00Z');

		$column = new DateColumn('test', false, $date);
		$this->assertInstanceOf(DateColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` DATE NOT NULL DEFAULT \'1996-04-30\'', $column->getQuerySnippet());

		$column = new DateColumn('test', false, $date->format('Y-m-d'));
		$this->assertInstanceOf(DateColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` DATE NOT NULL DEFAULT \'1996-04-30\'', $column->getQuerySnippet());

		$column = new DateColumn('test', false, (int)$date->format('U'));
		$this->assertInstanceOf(DateColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` DATE NOT NULL DEFAULT \'1996-04-30\'', $column->getQuerySnippet());

		$column = new DateColumn('test', false, $date->format('U'));
		$this->assertInstanceOf(DateColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` DATE NOT NULL DEFAULT \'1996-04-30\'', $column->getQuerySnippet());

		$this->expectException(\Exception::class);
		new DateColumn('test', false, 'test');
	}
}
