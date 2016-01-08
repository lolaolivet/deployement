<?php
namespace Core\Framework;

use \App;
use \Core\Db\QueryBuilder;

abstract class Model extends Related implements iModel
{
	private $_className;
	private $_tableName;
	private $_primaryKey;
	private $_attributes = array();
			
	public function __construct()
	{
		$this->_className = get_called_class();
		$this->_tableName = call_user_func(array($this->_className, 'getTable'));
		$this->_primaryKey = App::db()->getPK($this->_tableName);
		$this->_attributes = array_fill_keys(App::db()->getFieldsNames($this->_tableName), '');
		
		parent::__construct();
	}
	
	public function save()
	{
		$db = App::db();
		$query = new QueryBuilder($db);
		if($this->primaryKey)
			$query->update($this->_tableName, $this->primaryKey, $this->_attributes);
		else
			$query->insert($this->_tableName, $this->_attributes);
	}
	
	public function delete()
	{
		$db = App::db();
		$query = new QueryBuilder($db);
		$query->delete($this->_tableName, $this->primaryKey);
	}
	
	public static function find($attributes=array())
	{
		$className = get_called_class();
		$tableName = call_user_func(array($className, 'getTable'));
		$models = array();
		$query = new QueryBuilder();
		$request = $query
			->select()
			->from($tableName);
		foreach($attributes as $key=>$value){
			$request = $request->where($key.'='.$value);
		}
		$result = App::db()->fetch($request->getSql());
		foreach($result as $line){
			$model = new $className;
			foreach($line as $key=>$value){
				$model->$key = $value;
			}
			$models[] = $model;
		}
		return $models;
	}
	
	public static function findByPk($id)
	{
		$className = get_called_class();
		$tableName = call_user_func(array($className, 'getTable'));
		$pk = App::db()->getPK($tableName);
		$models = self::find(array($pk=>$id));
		return $models[0];
	}
	
	public function __get($name)
	{
		if($name == 'primaryKey')
			return $this->{$this->_primaryKey};
		elseif(isset($this->_attributes[$name]))
			return $this->_attributes[$name];
		elseif(false !== parent::__get($name))
			return parent::__get($name);
		else
			throw new \Exception("La table ".$this->_tableName." n'a pas de champ ".$name."!");
	}
	
	public function __set($name,$value)
	{
		if(in_array($name, array_keys($this->_attributes))){
			$this->_attributes[$name] = $value;
		}
		else
			throw new \Exception("La table ".$this->_tableName." n'a pas de champ ".$name."!");
	}
}
?>