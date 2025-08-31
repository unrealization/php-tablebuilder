<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use unrealization\Migration;
use unrealization\MigrationInterface;
use unrealization\TableActions\TableAction;
use unrealization\TableBuilder;

class MigrationTest extends TestCase
{
	/**
	 * @covers unrealization\Migration
	 */
	public function testStatus()
	{
		$fakeStatement = $this->createMock(\PDOStatement::class);
		$fakeStatement->method('bindValue');
		$fakeStatement->method('execute');
		$fakeStatement->method('rowCount')->willReturn(1);
		$fakeStatement->method('fetch')->willReturn(array('completed' => '2025-08-30 14:10:00'));

		$fakeDb = $this->createMock(\PDO::class);
		$fakeDb->method('prepare')->willReturn($fakeStatement);

		$result = Migration::status('migration-test', $fakeDb);
		$this->assertInstanceOf(\DateTime::class, $result);
		$this->assertSame('2025-08-30 14:10:00', $result->format('Y-m-d H:i:s'));

		$fakeStatement = $this->createMock(\PDOStatement::class);
		$fakeStatement->method('bindValue');
		$fakeStatement->method('execute');
		$fakeStatement->method('rowCount')->willReturn(0);

		$fakeDb = $this->createMock(\PDO::class);
		$fakeDb->method('prepare')->willReturn($fakeStatement);

		$result = Migration::status('migration-test', $fakeDb);
		$this->assertNull($result);

		$fakeStatement = $this->createMock(\PDOStatement::class);
		$fakeStatement->method('bindValue');
		$fakeStatement->method('execute')->willThrowException(new \PDOException('Fake database error.'));

		$fakeDb = $this->createMock(\PDO::class);
		$fakeDb->method('prepare')->willReturn($fakeStatement);

		$result = Migration::status('migration-test', $fakeDb, allowFailure: true);
		$this->assertNull($result);

		$this->expectException(\Exception::class);
		Migration::status('migration-test', $fakeDb);
	}

	/**
	 * @covers unrealization\Migration
	 * @uses unrealization\TableBuilder
	 * @uses unrealization\TableActions\TableAction
	 * @uses unrealization\TableActions\DropTable
	 */
	public function testMigrate()
	{
		$migration = new class implements MigrationInterface
		{
			public static function migrate(): TableAction
			{
				return TableBuilder::drop('test');
			}
		};

		$fakeStatusStatement = $this->createMock(\PDOStatement::class);
		$fakeStatusStatement->method('bindValue');
		$fakeStatusStatement->method('execute');
		$fakeStatusStatement->method('rowCount')->willReturn(0);

		$fakeMigrationStatement = $this->createMock(\PDOStatement::class);
		$fakeMigrationStatement->method('bindValue');
		$fakeMigrationStatement->method('execute')->willReturn(true);

		$fakeLogStatement = $this->createMock(\PDOStatement::class);
		$fakeLogStatement->method('bindValue');
		$fakeLogStatement->method('execute')->willReturn(true);

		$fakeDb = $this->createMock(\PDO::class);
		$fakeDb->method('prepare')->willReturnOnConsecutiveCalls($fakeStatusStatement, $fakeMigrationStatement, $fakeLogStatement);

		$result = Migration::migrate('migration-test', $fakeDb, $migration::migrate());
		$this->assertTrue($result);

		$fakeStatusStatement = $this->createMock(\PDOStatement::class);
		$fakeStatusStatement->method('bindValue');
		$fakeStatusStatement->method('execute');
		$fakeStatusStatement->method('rowCount')->willReturn(1);
		$fakeStatusStatement->method('fetch')->willReturn(array('completed' => '2025-08-30 14:10:00'));

		$fakeDb = $this->createMock(\PDO::class);
		$fakeDb->method('prepare')->willReturn($fakeStatusStatement);

		$result = Migration::migrate('migration-test', $fakeDb, $migration::migrate());
		$this->assertFalse($result);

		$fakeStatusStatement = $this->createMock(\PDOStatement::class);
		$fakeStatusStatement->method('bindValue');
		$fakeStatusStatement->method('execute');
		$fakeStatusStatement->method('rowCount')->willReturn(0);

		$fakeMigrationStatement = $this->createMock(\PDOStatement::class);
		$fakeMigrationStatement->method('bindValue');
		$fakeMigrationStatement->method('execute')->willReturn(true);

		$fakeLogStatement = $this->createMock(\PDOStatement::class);
		$fakeLogStatement->method('bindValue');
		$fakeLogStatement->method('execute')->willThrowException(new \PDOException('Fake database error.'));

		$fakeDb = $this->createMock(\PDO::class);
		$fakeDb->method('prepare')->willReturnOnConsecutiveCalls($fakeStatusStatement, $fakeMigrationStatement, $fakeLogStatement);

		$result = Migration::migrate('migration-test', $fakeDb, $migration::migrate());
		$this->assertTrue($result);

		$fakeStatusStatement = $this->createMock(\PDOStatement::class);
		$fakeStatusStatement->method('bindValue');
		$fakeStatusStatement->method('execute');
		$fakeStatusStatement->method('rowCount')->willReturn(0);

		$fakeMigrationStatement = $this->createMock(\PDOStatement::class);
		$fakeMigrationStatement->method('bindValue');
		$fakeMigrationStatement->method('execute')->willReturn(false);

		$fakeDb = $this->createMock(\PDO::class);
		$fakeDb->method('prepare')->willReturnOnConsecutiveCalls($fakeStatusStatement, $fakeMigrationStatement);

		$this->expectException(\Exception::class);
		Migration::migrate('migration-test', $fakeDb, $migration::migrate());
	}

	/**
	 * @covers unrealization\Migration
	 * @uses unrealization\TableBuilder
	 * @uses unrealization\TableActions\TableAction
	 * @uses unrealization\TableActions\DropTable
	 */
	public function testMigrate_databaseError()
	{
		$migration = new class implements MigrationInterface
		{
			public static function migrate(): TableAction
			{
				return TableBuilder::drop('test');
			}
		};

		$fakeStatusStatement = $this->createMock(\PDOStatement::class);
		$fakeStatusStatement->method('bindValue');
		$fakeStatusStatement->method('execute');
		$fakeStatusStatement->method('rowCount')->willReturn(0);

		$fakeMigrationStatement = $this->createMock(\PDOStatement::class);
		$fakeMigrationStatement->method('bindValue');
		$fakeMigrationStatement->method('execute')->willThrowException(new \PDOException('Fake database error.'));

		$fakeDb = $this->createMock(\PDO::class);
		$fakeDb->method('prepare')->willReturnOnConsecutiveCalls($fakeStatusStatement, $fakeMigrationStatement);

		$this->expectException(\PDOException::class);
		Migration::migrate('migration-test', $fakeDb, $migration::migrate());
	}

	/**
	 * @covers unrealization\Migration
	 */
	public function testLog()
	{
		$fakeStatement = $this->createMock(\PDOStatement::class);
		$fakeStatement->method('bindValue');
		$fakeStatement->method('execute')->willReturn(true);

		$fakeDb = $this->createMock(\PDO::class);
		$fakeDb->method('prepare')->willReturn($fakeStatement);

		$this->assertTrue(Migration::log('migration-test', $fakeDb));

		$fakeStatement = $this->createMock(\PDOStatement::class);
		$fakeStatement->method('bindValue');
		$fakeStatement->method('execute')->willReturn(false);

		$fakeDb = $this->createMock(\PDO::class);
		$fakeDb->method('prepare')->willReturn($fakeStatement);

		$this->assertFalse(Migration::log('migration-test', $fakeDb));

		$fakeStatement = $this->createMock(\PDOStatement::class);
		$fakeStatement->method('bindValue');
		$fakeStatement->method('execute')->willThrowException(new \PDOException('Fake database error.'));

		$fakeDb = $this->createMock(\PDO::class);
		$fakeDb->method('prepare')->willReturn($fakeStatement);

		$this->assertFalse(Migration::log('migration-test', $fakeDb));
	}
}
