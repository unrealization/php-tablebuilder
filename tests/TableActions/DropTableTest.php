<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use unrealization\TableBuilder;

class DropTableTest extends TestCase
{
	/**
	 * @covers unrealization\TableActions\DropTable
	 * @uses unrealization\TableBuilder
	 * @uses unrealization\TableActions\TableAction
	 */
	public function testGetQuery()
	{
		$query = TableBuilder::drop('test')->getQuery();
		$this->assertSame('DROP TABLE `test`;', $query);
	}
}
