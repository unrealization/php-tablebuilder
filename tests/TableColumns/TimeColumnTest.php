<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use unrealization\TableColumns\TimeColumn;

class TimeColumnTest extends TestCase
{
	/**
	 * @covers unrealization\TableColumns\TimeColumn
	 * @covers unrealization\TableColumns\GenericColumn
	 */
	public function testTimeColumn()
	{
		$column = new TimeColumn('test');
		$this->assertInstanceOf(TimeColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` TIME NOT NULL', $column->getQuerySnippet());

		$column = new TimeColumn('test', false, -INF);
		$this->assertInstanceOf(TimeColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` TIME NOT NULL', $column->getQuerySnippet());

		$column = new TimeColumn('test', true, -INF);
		$this->assertInstanceOf(TimeColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` TIME', $column->getQuerySnippet());

		$column = new TimeColumn('test', true, null);
		$this->assertInstanceOf(TimeColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` TIME DEFAULT NULL', $column->getQuerySnippet());

		$date = new \DateTime('1996-04-30 18:00:00Z');

		$column = new TimeColumn('test', false, $date);
		$this->assertInstanceOf(TimeColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` TIME NOT NULL DEFAULT \'18:00:00\'', $column->getQuerySnippet());

		$column = new TimeColumn('test', false, $date->format('Y-m-d H:i:s'));
		$this->assertInstanceOf(TimeColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` TIME NOT NULL DEFAULT \'18:00:00\'', $column->getQuerySnippet());

		$column = new TimeColumn('test', false, (int)$date->format('U'));
		$this->assertInstanceOf(TimeColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` TIME NOT NULL DEFAULT \'18:00:00\'', $column->getQuerySnippet());

		$column = new TimeColumn('test', false, $date->format('U'));
		$this->assertInstanceOf(TimeColumn::class, $column);
		$this->assertSame('test', $column->getName());
		$this->assertSame('`test` TIME NOT NULL DEFAULT \'18:00:00\'', $column->getQuerySnippet());

		$this->expectException(\Exception::class);
		new TimeColumn('test', false, 'test');
	}
}
