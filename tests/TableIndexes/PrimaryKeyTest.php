<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use unrealization\TableIndexes\PrimaryKey;
use unrealization\TableColumns\GenericColumn;
use unrealization\TableColumns\IntegerColumn;

class PrimaryKeyTest extends TestCase
{
	/**
	 * @covers unrealization\TableIndexes\PrimaryKey
	 * @covers unrealization\TableIndexes\GenericIndex
	 * @uses unrealization\TableColumns\IntegerColumn
	 * @uses unrealization\TableColumns\GenericColumn
	 */
	public function testPrimaryKey()
	{
		$index = new PrimaryKey('test');
		$this->assertInstanceOf(PrimaryKey::class, $index);
		$this->assertSame('PRIMARY', $index->getName());
		$this->assertSame('PRIMARY KEY (`test`)', $index->getQuerySnippet());

		$index = new PrimaryKey(new IntegerColumn('test'));
		$this->assertInstanceOf(PrimaryKey::class, $index);
		$this->assertSame('PRIMARY', $index->getName());
		$this->assertSame('PRIMARY KEY (`test`)', $index->getQuerySnippet());

		$index = new PrimaryKey(array('test1', new IntegerColumn('test2')));
		$this->assertInstanceOf(PrimaryKey::class, $index);
		$this->assertSame('PRIMARY', $index->getName());
		$this->assertSame('PRIMARY KEY (`test1`,`test2`)', $index->getQuerySnippet());
	}
}
