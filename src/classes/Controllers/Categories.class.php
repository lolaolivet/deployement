<?php
namespace Controllers;

use \Core\Framework\Controller;

class Categories extends Controller
{
	public static function getModel(){ return 'Categories'; }
	
	public function view($id)
	{ 
		$this->render('Categories/view', array('model'=>$this->loadModel($id)));
	}
}
?>