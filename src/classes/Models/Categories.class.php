<?php
namespace Models;

use \Core\Framework\Model;

class Categories extends Model
{
	public static function getTable(){ return 'articlescategories'; }
	
	public static function relations()
	{
		return array(
			'articles' => array(self::HAS_MANY, 'Articles', array('id'=>'category_id')),
		);
	}
}
?>