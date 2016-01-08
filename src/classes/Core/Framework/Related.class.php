<?php
namespace Core\Framework;

abstract class Related implements iRelated
{
	const BELONGS_TO = 'BELONGS_TO';
	const HAS_MANY = 'HAS_MANY';
	
	protected $_related = array();
		
	public function __construct()
	{		
		$this->_related = call_user_func(array(get_called_class(), 'relations'));
	}
	
	public function __get($name)
	{			
		if(isset($this->_related[$name])){
			if($this->_related[$name][0] == self::BELONGS_TO){
				$model = '\\Models\\'.$this->_related[$name][1];
				$attribute = $this->_related[$name][2]; 
				$key = key($attribute);
				return $model::findByPk($this->$key);
			}
			elseif($this->_related[$name][0] == self::HAS_MANY){
				$model = '\\Models\\'.$this->_related[$name][1];
				$attribute = $this->_related[$name][2];
				$key = key($attribute);
				return $model::find(array($attribute[$key]=>$this->$key));
			}
		}
		else
			return false;
	}
}
?>