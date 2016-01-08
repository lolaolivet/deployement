<?php
namespace Controllers;

use \Core\Framework\Controller;
use \Models\Categories;

class Articles extends Controller
{
	public static function getModel(){ return 'Articles'; }
	
	public function view($id)
	{
		$this->render('Articles/view', array('model'=>$this->loadModel($id)));
	}
	
	public function index($id='')
	{
		$categories_all = Categories::find();
		if($id)
			$categories = array(Categories::findByPk($id));
		else
			$categories = Categories::find();
		
		$this->render('Articles/list', array('categories_all'=>$categories_all, 'categories'=>$categories));
	}
}
?>