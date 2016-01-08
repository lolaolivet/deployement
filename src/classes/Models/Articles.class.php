<?php
namespace Models;

use \Core\Framework\Model;

class Articles extends Model
{
	public static function getTable(){ return 'articles'; }
	
	public static function relations()
	{
		return array(
			'category' => array(self::BELONGS_TO, 'Categories', array('category_id'=>'id')),
		);
	}
}
?>