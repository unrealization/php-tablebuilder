<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use unrealization\TableIndexes\Index;
use unrealization\TableColumns\GenericColumn;
use unrealization\TableColumns\IntColumn;

class IndexTest extends TestCase
{
	/**
	 * @covers unrealization\TableIndexes\Index
	 * @covers unrealization\TableIndexes\GenericIndex
	 * @uses unrealization\TableColumns\IntColumn
	 * @uses unrealization\TableColumns\GenericColumn
	 */
	public function testIndex()
	{
		$index = new Index('test');
		$this->assertInstanceOf(Index::class, $index);
		$this->assertSame('INDEX_test', $index->getName());
		$this->assertSame('INDEX `INDEX_test` (`test`)', $index->getQuerySnippet());

		$index = new Index(new IntColumn('test'));
		$this->assertInstanceOf(Index::class, $index);
		$this->assertSame('INDEX_test', $index->getName());
		$this->assertSame('INDEX `INDEX_test` (`test`)', $index->getQuerySnippet());

		$index = new Index(array('test1', new IntColumn('test2')));
		$this->assertInstanceOf(Index::class, $index);
		$this->assertSame('INDEX_test1_test2', $index->getName());
		$this->assertSame('INDEX `INDEX_test1_test2` (`test1`,`test2`)', $index->getQuerySnippet());

		$index = new Index('test', 'test_index');
		$this->assertInstanceOf(Index::class, $index);
		$this->assertSame('test_index', $index->getName());
		$this->assertSame('INDEX `test_index` (`test`)', $index->getQuerySnippet());
	}
}
