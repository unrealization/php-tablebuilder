<?php
declare(strict_types=1);

namespace unrealization\TableActions;

class DropTable extends TableAction
{
	/**
	 * 
	 * {@inheritDoc}
	 * @see \unrealization\TableActions\TableAction::getQuery()
	 */
	public function getQuery(): string
	{
		return 'DROP TABLE `'.$this->name.'`;';
	}
}
