<?php
namespace Controllers;

use \Core\Framework\Controller;

class Site extends Controller
{
	public static function getModel(){ return ''; }
	
	public function index()
	{
		$this->render('Site/home');
	}
	
	public function error($code='', $message='')
	{
		$this->flashMessage = $message;
		$this->render('Site/error', array('code'=>$code, 'message'=>$message));
	}
}
?>