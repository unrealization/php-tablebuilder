<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use unrealization\TableIndexes\FullTextIndex;
use unrealization\TableColumns\GenericColumn;
use unrealization\TableColumns\IntColumn;

class FullTextIndexTest extends TestCase
{
	/**
	 * @covers unrealization\TableIndexes\FullTextIndex
	 * @covers unrealization\TableIndexes\GenericIndex
	 * @uses unrealization\TableColumns\IntColumn
	 * @uses unrealization\TableColumns\GenericColumn
	 */
	public function testFullTextIndex()
	{
		$index = new FullTextIndex('test');
		$this->assertInstanceOf(FullTextIndex::class, $index);
		$this->assertSame('FULLTEXT_test', $index->getName());
		$this->assertSame('FULLTEXT `FULLTEXT_test` (`test`)', $index->getQuerySnippet());

		$index = new FullTextIndex(new IntColumn('test'));
		$this->assertInstanceOf(FullTextIndex::class, $index);
		$this->assertSame('FULLTEXT_test', $index->getName());
		$this->assertSame('FULLTEXT `FULLTEXT_test` (`test`)', $index->getQuerySnippet());

		$index = new FullTextIndex(array('test1', new IntColumn('test2')));
		$this->assertInstanceOf(FullTextIndex::class, $index);
		$this->assertSame('FULLTEXT_test1_test2', $index->getName());
		$this->assertSame('FULLTEXT `FULLTEXT_test1_test2` (`test1`,`test2`)', $index->getQuerySnippet());

		$index = new FullTextIndex('test', 'test_index');
		$this->assertInstanceOf(FullTextIndex::class, $index);
		$this->assertSame('test_index', $index->getName());
		$this->assertSame('FULLTEXT `test_index` (`test`)', $index->getQuerySnippet());
	}
}
