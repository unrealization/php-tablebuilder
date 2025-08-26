<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use unrealization\TableColumns\TimeStampColumn;

class TimeStampColumnTest extends TestCase
{
	/**
	 * @covers unrealization\TableColumns\TimeStampColumn
	 * @covers unrealization\TableColumns\GenericColumn
	 */
	public function testTimeStampColumn()
	{
		$column = new TimeStampColumn('test');
		$this->assertInstanceOf(TimeStampColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` TIMESTAMP NOT NULL', $column->getQuerySnippet());

		$column = new TimeStampColumn('test', false, false, -INF);
		$this->assertInstanceOf(TimeStampColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` TIMESTAMP NOT NULL', $column->getQuerySnippet());

		$column = new TimeStampColumn('test', true, false, -INF);
		$this->assertInstanceOf(TimeStampColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` TIMESTAMP', $column->getQuerySnippet());

		$column = new TimeStampColumn('test', false, true, -INF);
		$this->assertInstanceOf(TimeStampColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` TIMESTAMP NOT NULL ON UPDATE CURRENT_TIMESTAMP', $column->getQuerySnippet());

		$column = new TimeStampColumn('test', true, false, null);
		$this->assertInstanceOf(TimeStampColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` TIMESTAMP DEFAULT NULL', $column->getQuerySnippet());

		$column = new TimeStampColumn('test', false, false, 'CURRENT_TIMESTAMP');
		$this->assertInstanceOf(TimeStampColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP', $column->getQuerySnippet());

		$date = new \DateTime('1996-04-30 18:00:00Z');

		$column = new TimeStampColumn('test', false, false, $date);
		$this->assertInstanceOf(TimeStampColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` TIMESTAMP NOT NULL DEFAULT \'1996-04-30 18:00:00\'', $column->getQuerySnippet());

		$column = new TimeStampColumn('test', false, false, $date->format('Y-m-d H:i:s'));
		$this->assertInstanceOf(TimeStampColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` TIMESTAMP NOT NULL DEFAULT \'1996-04-30 18:00:00\'', $column->getQuerySnippet());

		$column = new TimeStampColumn('test', false, false, (int)$date->format('U'));
		$this->assertInstanceOf(TimeStampColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` TIMESTAMP NOT NULL DEFAULT \'1996-04-30 18:00:00\'', $column->getQuerySnippet());

		$column = new TimeStampColumn('test', false, false, $date->format('U'));
		$this->assertInstanceOf(TimeStampColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` TIMESTAMP NOT NULL DEFAULT \'1996-04-30 18:00:00\'', $column->getQuerySnippet());

		$this->expectException(\Exception::class);
		new TimeStampColumn('test', false, false, 'test');
	}
}
