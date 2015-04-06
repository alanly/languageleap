<?php

use LangLeap\TestCase;
use LangLeap\Core\PublishedTrait;

/**
 * @author Michael Lavoie <lavoie6453@gmail.com>
 */
class PublishedModelDummy {

	use PublishedTrait;

	public function getTable()
	{
		return 'table_name';
	}

}

class PublishedTraitTest extends TestCase {
	
	public function testGetQualifiedPublishedColumn()
	{
		$dummy = new PublishedModelDummy;

		$this->assertSame($dummy->getQualifiedPublishedColumn(), 'table_name.is_published');
	}

}
