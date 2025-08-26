<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use unrealization\TableColumns\DateTimeColumn;

class DateTimeColumnTest extends TestCase
{
	/**
	 * @covers unrealization\TableColumns\DateTimeColumn
	 * @covers unrealization\TableColumns\GenericColumn
	 */
	public function testDateTimeColumn()
	{
		$column = new DateTimeColumn('test');
		$this->assertInstanceOf(DateTimeColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` DATETIME NOT NULL', $column->getQuerySnippet());

		$column = new DateTimeColumn('test', false, false, -INF);
		$this->assertInstanceOf(DateTimeColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` DATETIME NOT NULL', $column->getQuerySnippet());

		$column = new DateTimeColumn('test', true, false, -INF);
		$this->assertInstanceOf(DateTimeColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` DATETIME', $column->getQuerySnippet());

		$column = new DateTimeColumn('test', false, true, -INF);
		$this->assertInstanceOf(DateTimeColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` DATETIME NOT NULL ON UPDATE CURRENT_TIMESTAMP', $column->getQuerySnippet());

		$column = new DateTimeColumn('test', true, false, null);
		$this->assertInstanceOf(DateTimeColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` DATETIME DEFAULT NULL', $column->getQuerySnippet());

		$column = new DateTimeColumn('test', false, false, 'CURRENT_TIMESTAMP');
		$this->assertInstanceOf(DateTimeColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP', $column->getQuerySnippet());

		$date = new \DateTime('1996-04-30 18:00:00Z');

		$column = new DateTimeColumn('test', false, false, $date);
		$this->assertInstanceOf(DateTimeColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` DATETIME NOT NULL DEFAULT \'1996-04-30 18:00:00\'', $column->getQuerySnippet());

		$column = new DateTimeColumn('test', false, false, $date->format('Y-m-d H:i:s'));
		$this->assertInstanceOf(DateTimeColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` DATETIME NOT NULL DEFAULT \'1996-04-30 18:00:00\'', $column->getQuerySnippet());

		$column = new DateTimeColumn('test', false, false, (int)$date->format('U'));
		$this->assertInstanceOf(DateTimeColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` DATETIME NOT NULL DEFAULT \'1996-04-30 18:00:00\'', $column->getQuerySnippet());

		$column = new DateTimeColumn('test', false, false, $date->format('U'));
		$this->assertInstanceOf(DateTimeColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` DATETIME NOT NULL DEFAULT \'1996-04-30 18:00:00\'', $column->getQuerySnippet());

		$this->expectException(\Exception::class);
		new DateTimeColumn('test', false, false, 'test');
	}
}
