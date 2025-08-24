<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use unrealization\TableIndexes\Index;
use unrealization\ComponentActions\IndexAction;
use unrealization\TableIndexes\PrimaryKey;

class IndexActionTest extends TestCase
{
	/**
	 * @covers unrealization\ComponentActions\IndexAction
	 * @uses unrealization\TableIndexes\Index
	 * @uses unrealization\TableIndexes\GenericIndex
	 * @uses unrealization\TableColumns\IntColumn
	 * @uses unrealization\TableColumns\GenericColumn
	 * @uses unrealization\TableIndexes\PrimaryKey
	 */
	public function testIndexAction()
	{
		$index = new Index('test');

		$indexAction = new IndexAction($index, IndexAction::MODE_ALTER);
		$this->assertInstanceOf(IndexAction::class, $indexAction);
		$this->assertSame('INDEX_test', $indexAction->getName());
		$this->assertSame('ADD INDEX `INDEX_test` (`test`)', $indexAction->getQuerySnippet());

		$indexAction = new IndexAction($index, IndexAction::MODE_CREATE);
		$this->assertInstanceOf(IndexAction::class, $indexAction);
		$this->assertSame('INDEX_test', $indexAction->getName());
		$this->assertSame('INDEX `INDEX_test` (`test`)', $indexAction->getQuerySnippet());

		$indexAction = new IndexAction($index, IndexAction::MODE_DROP);
		$this->assertInstanceOf(IndexAction::class, $indexAction);
		$this->assertSame('INDEX_test', $indexAction->getName());
		$this->assertSame('DROP INDEX `INDEX_test`', $indexAction->getQuerySnippet());

		$primaryKey = new PrimaryKey('test');
		$indexAction = new IndexAction($primaryKey, IndexAction::MODE_DROP);
		$this->assertInstanceOf(IndexAction::class, $indexAction);
		$this->assertSame('PRIMARY', $indexAction->getName());
		$this->assertSame('DROP PRIMARY KEY', $indexAction->getQuerySnippet());
	}

	/**
	 * @covers unrealization\ComponentActions\IndexAction
	 * @uses unrealization\TableColumns\IntColumn
	 * @uses unrealization\TableColumns\GenericColumn
	 * @uses unrealization\TableIndexes\GenericIndex
	 * @uses unrealization\TableIndexes\Index
	 */
	public function testCreate()
	{
		$indexAction = IndexAction::create(Index::class, IndexAction::MODE_CREATE, array('test1', 'test2'), 'test_index');
		$this->assertInstanceOf(IndexAction::class, $indexAction);
		$this->assertSame('test_index', $indexAction->getName());
		$this->assertSame('INDEX `test_index` (`test1`,`test2`)', $indexAction->getQuerySnippet());
	}

	/**
	 * @covers unrealization\ComponentActions\IndexAction
	 */
	public function testCreateInvalidClass()
	{
		$this->expectException(\InvalidArgumentException::class);
		IndexAction::create(\DateTime::class, IndexAction::MODE_CREATE, 'test');
	}
}
