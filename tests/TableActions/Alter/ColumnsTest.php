<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use unrealization\TableBuilder;
use unrealization\TableActions\AlterTable;
use unrealization\ComponentActions\ColumnAction;
use unrealization\TableColumns\GenericColumn;
use unrealization\TableColumns\IntColumn;

class AlterColumnsTest extends TestCase
{
	/**
	 * @covers unrealization\TableActions\Alter\Columns
	 * @uses unrealization\TableActions\TableAction
	 * @uses unrealization\ComponentActions\ColumnAction
	 * @uses unrealization\TableBuilder
	 * @uses unrealization\TableColumns\IntColumn
	 * @uses unrealization\TableColumns\GenericColumn
	 * @uses unrealization\TableActions\AlterTable
	 */
	public function testDropColumn()
	{
		$table = TableBuilder::alter('test')->dropColumn('test');
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` DROP COLUMN `test`;', $table->getQuery());

		$table = TableBuilder::alter('test')->dropColumn(new IntColumn('test'));
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` DROP COLUMN `test`;', $table->getQuery());
	}

	/**
	 * @covers unrealization\TableActions\Alter\Columns
	 * @uses unrealization\TableActions\TableAction
	 * @uses unrealization\ComponentActions\ColumnAction
	 * @uses unrealization\TableBuilder
	 * @uses unrealization\TableColumns\IntColumn
	 * @uses unrealization\TableColumns\GenericColumn
	 * @uses unrealization\TableActions\AlterTable
	 * @uses unrealization\TableColumns\BigIntColumn
	 */
	public function testBigint()
	{
		$table = TableBuilder::alter('test')->bigint('test', false, false, false, -INF, null, null, null);
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` ADD COLUMN `test` BIGINT NOT NULL;', $table->getQuery());

		$table = TableBuilder::alter('test')->bigint('test', false, false, false, -INF, ColumnAction::POSITION_FIRST, null, null);
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` ADD COLUMN `test` BIGINT NOT NULL FIRST;', $table->getQuery());

		$table = TableBuilder::alter('test')->bigint('test', false, false, false, -INF, ColumnAction::POSITION_AFTER, 'id', null);
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` ADD COLUMN `test` BIGINT NOT NULL AFTER `id`;', $table->getQuery());

		$table = TableBuilder::alter('test')->bigint('test', false, false, false, -INF, ColumnAction::POSITION_AFTER, new IntColumn('id'), null);
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` ADD COLUMN `test` BIGINT NOT NULL AFTER `id`;', $table->getQuery());
		
		$table = TableBuilder::alter('test')->bigint('test', false, false, false, -INF, null, null, 'test');
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` CHANGE COLUMN `test` `test` BIGINT NOT NULL;', $table->getQuery());

		$table = TableBuilder::alter('test')->bigint('test', false, false, false, -INF, null, null, new IntColumn('test'));
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` CHANGE COLUMN `test` `test` BIGINT NOT NULL;', $table->getQuery());
	}

	/**
	 * @covers unrealization\TableActions\Alter\Columns
	 * @uses unrealization\TableActions\TableAction
	 * @uses unrealization\ComponentActions\ColumnAction
	 * @uses unrealization\TableBuilder
	 * @uses unrealization\TableColumns\IntColumn
	 * @uses unrealization\TableColumns\GenericColumn
	 * @uses unrealization\TableActions\AlterTable
	 * @uses unrealization\TableColumns\DateColumn
	 */
	public function testDate()
	{
		$table = TableBuilder::alter('test')->date('test', false, -INF, null, null, null);
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` ADD COLUMN `test` DATE NOT NULL;', $table->getQuery());

		$table = TableBuilder::alter('test')->date('test', false, -INF, ColumnAction::POSITION_FIRST, null, null);
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` ADD COLUMN `test` DATE NOT NULL FIRST;', $table->getQuery());

		$table = TableBuilder::alter('test')->date('test', false, -INF, ColumnAction::POSITION_AFTER, 'id', null);
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` ADD COLUMN `test` DATE NOT NULL AFTER `id`;', $table->getQuery());

		$table = TableBuilder::alter('test')->date('test', false, -INF, ColumnAction::POSITION_AFTER, new IntColumn('id'), null);
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` ADD COLUMN `test` DATE NOT NULL AFTER `id`;', $table->getQuery());

		$table = TableBuilder::alter('test')->date('test', false, -INF, null, null, 'test');
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` CHANGE COLUMN `test` `test` DATE NOT NULL;', $table->getQuery());

		$table = TableBuilder::alter('test')->date('test', false, -INF, null, null, new IntColumn('test'));
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` CHANGE COLUMN `test` `test` DATE NOT NULL;', $table->getQuery());
	}

	/**
	 * @covers unrealization\TableActions\Alter\Columns
	 * @uses unrealization\TableActions\TableAction
	 * @uses unrealization\ComponentActions\ColumnAction
	 * @uses unrealization\TableBuilder
	 * @uses unrealization\TableColumns\IntColumn
	 * @uses unrealization\TableColumns\GenericColumn
	 * @uses unrealization\TableActions\AlterTable
	 * @uses unrealization\TableColumns\DateTimeColumn
	 */
	public function testDatetime()
	{
		$table = TableBuilder::alter('test')->datetime('test', false, -INF, null, null, null);
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` ADD COLUMN `test` DATETIME NOT NULL;', $table->getQuery());

		$table = TableBuilder::alter('test')->datetime('test', false, -INF, ColumnAction::POSITION_FIRST, null, null);
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` ADD COLUMN `test` DATETIME NOT NULL FIRST;', $table->getQuery());

		$table = TableBuilder::alter('test')->datetime('test', false, -INF, ColumnAction::POSITION_AFTER, 'id', null);
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` ADD COLUMN `test` DATETIME NOT NULL AFTER `id`;', $table->getQuery());

		$table = TableBuilder::alter('test')->datetime('test', false, -INF, ColumnAction::POSITION_AFTER, new IntColumn('id'), null);
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` ADD COLUMN `test` DATETIME NOT NULL AFTER `id`;', $table->getQuery());

		$table = TableBuilder::alter('test')->datetime('test', false, -INF, null, null, 'test');
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` CHANGE COLUMN `test` `test` DATETIME NOT NULL;', $table->getQuery());

		$table = TableBuilder::alter('test')->datetime('test', false, -INF, null, null, new IntColumn('test'));
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` CHANGE COLUMN `test` `test` DATETIME NOT NULL;', $table->getQuery());
	}

	/**
	 * @covers unrealization\TableActions\Alter\Columns
	 * @uses unrealization\TableActions\TableAction
	 * @uses unrealization\ComponentActions\ColumnAction
	 * @uses unrealization\TableBuilder
	 * @uses unrealization\TableColumns\IntColumn
	 * @uses unrealization\TableColumns\GenericColumn
	 * @uses unrealization\TableActions\AlterTable
	 * @uses unrealization\TableColumns\DecimalColumn
	 */
	public function testDecimal()
	{
		$table = TableBuilder::alter('test')->decimal('test', null, null, false, false, -INF, null, null, null);
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` ADD COLUMN `test` DECIMAL NOT NULL;', $table->getQuery());

		$table = TableBuilder::alter('test')->decimal('test', null, null, false, false, -INF, ColumnAction::POSITION_FIRST, null, null);
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` ADD COLUMN `test` DECIMAL NOT NULL FIRST;', $table->getQuery());

		$table = TableBuilder::alter('test')->decimal('test', null, null, false, false, -INF, ColumnAction::POSITION_AFTER, 'id', null);
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` ADD COLUMN `test` DECIMAL NOT NULL AFTER `id`;', $table->getQuery());

		$table = TableBuilder::alter('test')->decimal('test', null, null, false, false, -INF, ColumnAction::POSITION_AFTER, new IntColumn('id'), null);
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` ADD COLUMN `test` DECIMAL NOT NULL AFTER `id`;', $table->getQuery());

		$table = TableBuilder::alter('test')->decimal('test', null, null, false, false, -INF, null, null, 'test');
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` CHANGE COLUMN `test` `test` DECIMAL NOT NULL;', $table->getQuery());

		$table = TableBuilder::alter('test')->decimal('test', null, null, false, false, -INF, null, null, new IntColumn('test'));
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` CHANGE COLUMN `test` `test` DECIMAL NOT NULL;', $table->getQuery());
	}

	/**
	 * @covers unrealization\TableActions\Alter\Columns
	 * @uses unrealization\TableActions\TableAction
	 * @uses unrealization\ComponentActions\ColumnAction
	 * @uses unrealization\TableBuilder
	 * @uses unrealization\TableColumns\IntColumn
	 * @uses unrealization\TableColumns\GenericColumn
	 * @uses unrealization\TableActions\AlterTable
	 * @uses unrealization\TableColumns\FloatColumn
	 */
	public function testFloat()
	{
		$table = TableBuilder::alter('test')->float('test', null, false, false, -INF, null, null, null);
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` ADD COLUMN `test` FLOAT NOT NULL;', $table->getQuery());

		$table = TableBuilder::alter('test')->float('test', null, false, false, -INF, ColumnAction::POSITION_FIRST, null, null);
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` ADD COLUMN `test` FLOAT NOT NULL FIRST;', $table->getQuery());

		$table = TableBuilder::alter('test')->float('test', null, false, false, -INF, ColumnAction::POSITION_AFTER, 'id', null);
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` ADD COLUMN `test` FLOAT NOT NULL AFTER `id`;', $table->getQuery());

		$table = TableBuilder::alter('test')->float('test', null, false, false, -INF, ColumnAction::POSITION_AFTER, new IntColumn('id'), null);
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` ADD COLUMN `test` FLOAT NOT NULL AFTER `id`;', $table->getQuery());

		$table = TableBuilder::alter('test')->float('test', null, false, false, -INF, null, null, 'test');
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` CHANGE COLUMN `test` `test` FLOAT NOT NULL;', $table->getQuery());

		$table = TableBuilder::alter('test')->float('test', null, false, false, -INF, null, null, new IntColumn('test'));
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` CHANGE COLUMN `test` `test` FLOAT NOT NULL;', $table->getQuery());
	}

	/**
	 * @covers unrealization\TableActions\Alter\Columns
	 * @uses unrealization\TableActions\TableAction
	 * @uses unrealization\ComponentActions\ColumnAction
	 * @uses unrealization\TableBuilder
	 * @uses unrealization\TableColumns\GenericColumn
	 * @uses unrealization\TableActions\AlterTable
	 * @uses unrealization\TableColumns\IntColumn
	 */
	public function testInt()
	{
		$table = TableBuilder::alter('test')->int('test', false, false, false, -INF, null, null, null);
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` ADD COLUMN `test` INT NOT NULL;', $table->getQuery());

		$table = TableBuilder::alter('test')->int('test', false, false, false, -INF, ColumnAction::POSITION_FIRST, null, null);
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` ADD COLUMN `test` INT NOT NULL FIRST;', $table->getQuery());

		$table = TableBuilder::alter('test')->int('test', false, false, false, -INF, ColumnAction::POSITION_AFTER, 'id', null);
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` ADD COLUMN `test` INT NOT NULL AFTER `id`;', $table->getQuery());

		$table = TableBuilder::alter('test')->int('test', false, false, false, -INF, ColumnAction::POSITION_AFTER, new IntColumn('id'), null);
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` ADD COLUMN `test` INT NOT NULL AFTER `id`;', $table->getQuery());

		$table = TableBuilder::alter('test')->int('test', false, false, false, -INF, null, null, 'test');
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` CHANGE COLUMN `test` `test` INT NOT NULL;', $table->getQuery());

		$table = TableBuilder::alter('test')->int('test', false, false, false, -INF, null, null, new IntColumn('test'));
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` CHANGE COLUMN `test` `test` INT NOT NULL;', $table->getQuery());
	}

	/**
	 * @covers unrealization\TableActions\Alter\Columns
	 * @uses unrealization\TableActions\TableAction
	 * @uses unrealization\ComponentActions\ColumnAction
	 * @uses unrealization\TableBuilder
	 * @uses unrealization\TableColumns\IntColumn
	 * @uses unrealization\TableColumns\GenericColumn
	 * @uses unrealization\TableActions\AlterTable
	 * @uses unrealization\TableColumns\TextColumn
	 */
	public function testText()
	{
		$table = TableBuilder::alter('test')->text('test', false, null, null, -INF, null, null, null);
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` ADD COLUMN `test` TEXT NOT NULL;', $table->getQuery());

		$table = TableBuilder::alter('test')->text('test', false, null, null, -INF, ColumnAction::POSITION_FIRST, null, null);
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` ADD COLUMN `test` TEXT NOT NULL FIRST;', $table->getQuery());

		$table = TableBuilder::alter('test')->text('test', false, null, null, -INF, ColumnAction::POSITION_AFTER, 'id', null);
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` ADD COLUMN `test` TEXT NOT NULL AFTER `id`;', $table->getQuery());

		$table = TableBuilder::alter('test')->text('test', false, null, null, -INF, ColumnAction::POSITION_AFTER, new IntColumn('id'), null);
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` ADD COLUMN `test` TEXT NOT NULL AFTER `id`;', $table->getQuery());

		$table = TableBuilder::alter('test')->text('test', false, null, null, -INF, null, null, 'test');
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` CHANGE COLUMN `test` `test` TEXT NOT NULL;', $table->getQuery());

		$table = TableBuilder::alter('test')->text('test', false, null, null, -INF, null, null, new IntColumn('test'));
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` CHANGE COLUMN `test` `test` TEXT NOT NULL;', $table->getQuery());
	}

	/**
	 * @covers unrealization\TableActions\Alter\Columns
	 * @uses unrealization\TableActions\TableAction
	 * @uses unrealization\ComponentActions\ColumnAction
	 * @uses unrealization\TableBuilder
	 * @uses unrealization\TableColumns\IntColumn
	 * @uses unrealization\TableColumns\GenericColumn
	 * @uses unrealization\TableActions\AlterTable
	 * @uses unrealization\TableColumns\TimeColumn
	 */
	public function testTime()
	{
		$table = TableBuilder::alter('test')->time('test', false, -INF, null, null, null);
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` ADD COLUMN `test` TIME NOT NULL;', $table->getQuery());

		$table = TableBuilder::alter('test')->time('test', false, -INF, ColumnAction::POSITION_FIRST, null, null);
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` ADD COLUMN `test` TIME NOT NULL FIRST;', $table->getQuery());

		$table = TableBuilder::alter('test')->time('test', false, -INF, ColumnAction::POSITION_AFTER, 'id', null);
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` ADD COLUMN `test` TIME NOT NULL AFTER `id`;', $table->getQuery());

		$table = TableBuilder::alter('test')->time('test', false, -INF, ColumnAction::POSITION_AFTER, new IntColumn('id'), null);
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` ADD COLUMN `test` TIME NOT NULL AFTER `id`;', $table->getQuery());

		$table = TableBuilder::alter('test')->time('test', false, -INF, null, null, 'test');
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` CHANGE COLUMN `test` `test` TIME NOT NULL;', $table->getQuery());

		$table = TableBuilder::alter('test')->time('test', false, -INF, null, null, new IntColumn('test'));
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` CHANGE COLUMN `test` `test` TIME NOT NULL;', $table->getQuery());
	}

	/**
	 * @covers unrealization\TableActions\Alter\Columns
	 * @uses unrealization\TableActions\TableAction
	 * @uses unrealization\ComponentActions\ColumnAction
	 * @uses unrealization\TableBuilder
	 * @uses unrealization\TableColumns\IntColumn
	 * @uses unrealization\TableColumns\GenericColumn
	 * @uses unrealization\TableActions\AlterTable
	 * @uses unrealization\TableColumns\TimeStampColumn
	 */
	public function testTimestamp()
	{
		$table = TableBuilder::alter('test')->timestamp('test', false, -INF, null, null, null);
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` ADD COLUMN `test` TIMESTAMP NOT NULL;', $table->getQuery());

		$table = TableBuilder::alter('test')->timestamp('test', false, -INF, ColumnAction::POSITION_FIRST, null, null);
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` ADD COLUMN `test` TIMESTAMP NOT NULL FIRST;', $table->getQuery());

		$table = TableBuilder::alter('test')->timestamp('test', false, -INF, ColumnAction::POSITION_AFTER, 'id', null);
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` ADD COLUMN `test` TIMESTAMP NOT NULL AFTER `id`;', $table->getQuery());

		$table = TableBuilder::alter('test')->timestamp('test', false, -INF, ColumnAction::POSITION_AFTER, new IntColumn('id'), null);
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` ADD COLUMN `test` TIMESTAMP NOT NULL AFTER `id`;', $table->getQuery());

		$table = TableBuilder::alter('test')->timestamp('test', false, -INF, null, null, 'test');
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` CHANGE COLUMN `test` `test` TIMESTAMP NOT NULL;', $table->getQuery());

		$table = TableBuilder::alter('test')->timestamp('test', false, -INF, null, null, new IntColumn('test'));
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` CHANGE COLUMN `test` `test` TIMESTAMP NOT NULL;', $table->getQuery());
	}

	/**
	 * @covers unrealization\TableActions\Alter\Columns
	 * @uses unrealization\TableActions\TableAction
	 * @uses unrealization\ComponentActions\ColumnAction
	 * @uses unrealization\TableBuilder
	 * @uses unrealization\TableColumns\IntColumn
	 * @uses unrealization\TableColumns\GenericColumn
	 * @uses unrealization\TableActions\AlterTable
	 * @uses unrealization\TableColumns\VarCharColumn
	 */
	public function testVarchar()
	{
		$table = TableBuilder::alter('test')->varchar('test', 32, false, null, null, -INF, null, null, null);
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` ADD COLUMN `test` VARCHAR(32) NOT NULL;', $table->getQuery());

		$table = TableBuilder::alter('test')->varchar('test', 32, false, null, null, -INF, ColumnAction::POSITION_FIRST, null, null);
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` ADD COLUMN `test` VARCHAR(32) NOT NULL FIRST;', $table->getQuery());

		$table = TableBuilder::alter('test')->varchar('test', 32, false, null, null, -INF, ColumnAction::POSITION_AFTER, 'id', null);
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` ADD COLUMN `test` VARCHAR(32) NOT NULL AFTER `id`;', $table->getQuery());

		$table = TableBuilder::alter('test')->varchar('test', 32, false, null, null, -INF, ColumnAction::POSITION_AFTER, new IntColumn('id'), null);
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` ADD COLUMN `test` VARCHAR(32) NOT NULL AFTER `id`;', $table->getQuery());

		$table = TableBuilder::alter('test')->varchar('test', 32, false, null, null, -INF, null, null, 'test');
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` CHANGE COLUMN `test` `test` VARCHAR(32) NOT NULL;', $table->getQuery());

		$table = TableBuilder::alter('test')->varchar('test', 32, false, null, null, -INF, null, null, new IntColumn('test'));
		$this->assertInstanceOf(AlterTable::class, $table);
		$this->assertSame('ALTER TABLE `test` CHANGE COLUMN `test` `test` VARCHAR(32) NOT NULL;', $table->getQuery());
	}
}
