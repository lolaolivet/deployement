<?php
namespace Core\Framework;

use \App;

abstract class Controller implements iController
{
	private $_model;
	
	public $layout = '../templates/default';
	public $title;
	public $keywords;
	public $description;
	public $flashMessage;
	
	public function __construct()
	{
		$this->_model = '\\Models\\'.call_user_func(array(get_called_class(), 'getModel'));
	}
	
	protected function loadModel($id)
	{
		$model = $this->_model;
		return $model::findByPk($id);
	}
	
	public function render($view, $data=null, $layout=true, $return=false)
	{
		$viewFile = 'src/views/'.$view.'.php';
		
		if(is_array($data))
			extract($data);
		
		ob_start();
		require_once $viewFile;
		$content = ob_get_clean();
		
		if($layout && $this->layout)
			$content = $this->render($this->layout,array(
				'content'=>$content, 
				'title'=>$this->title, 
				'keywords'=>$this->keywords, 
				'description'=>$this->description, 
				'flashMessage'=>$this->flashMessage,
			), false, true);
		
		if($return)
			return $content;
		else
			echo $content;
	}
}
?>