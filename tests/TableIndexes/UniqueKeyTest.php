<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use unrealization\TableIndexes\UniqueKey;
use unrealization\TableColumns\GenericColumn;
use unrealization\TableColumns\IntColumn;

class UniqueKeyTest extends TestCase
{
	/**
	 * @covers unrealization\TableIndexes\UniqueKey
	 * @covers unrealization\TableIndexes\GenericIndex
	 * @uses unrealization\TableColumns\IntColumn
	 * @uses unrealization\TableColumns\GenericColumn
	 */
	public function testUniqueKey()
	{
		$index = new UniqueKey('test');
		$this->assertInstanceOf(UniqueKey::class, $index);
		$this->assertSame('UNIQUE_KEY_test', $index->getName());
		$this->assertSame('UNIQUE KEY `UNIQUE_KEY_test` (`test`)', $index->getQuerySnippet());

		$index = new UniqueKey(new IntColumn('test'));
		$this->assertInstanceOf(UniqueKey::class, $index);
		$this->assertSame('UNIQUE_KEY_test', $index->getName());
		$this->assertSame('UNIQUE KEY `UNIQUE_KEY_test` (`test`)', $index->getQuerySnippet());

		$index = new UniqueKey(array('test1', new IntColumn('test2')));
		$this->assertInstanceOf(UniqueKey::class, $index);
		$this->assertSame('UNIQUE_KEY_test1_test2', $index->getName());
		$this->assertSame('UNIQUE KEY `UNIQUE_KEY_test1_test2` (`test1`,`test2`)', $index->getQuerySnippet());

		$index = new UniqueKey('test', 'test_index');
		$this->assertInstanceOf(UniqueKey::class, $index);
		$this->assertSame('test_index', $index->getName());
		$this->assertSame('UNIQUE KEY `test_index` (`test`)', $index->getQuerySnippet());

		$this->expectException(\InvalidArgumentException::class);
		new UniqueKey(array(new \DateTime()));
	}
}
