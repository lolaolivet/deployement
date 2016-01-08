<?php
namespace Core\Db;

final class ConnectMySQL extends ConnectDB
{
	private $_link = null; 
	private $_success; 
	
	public function __construct($args)
	{
		parent::__construct($args);
	}
	
	protected function connect()
	{
		$this->_link = @mysql_connect($this->host,$this->user,$this->password);
		if (!$this->_link)
			throw new \Exception("Connection refusée au serveur de base de données! (".mysql_error().")");
		else{
			$this->_success = @mysql_select_db($this->dbname,$this->_link); 
			if (!$this->_success)
				throw new \Exception("Connection refusée à la base de données! (".mysql_error().")");
		}
	}
	
	protected function disconnect() 
	{
		if($this->_link){
			mysql_close($this->_link);
			$this->_link = null;
		}
	}
	
	public function query($sql)
	{
		if(is_string($sql)){
			if($result = mysql_query($sql,$this->_link))
				return $result;
			else{
				throw new \Exception("Requête impossible!");
				return false; 
			}
		}
		else{
			throw new \Exception("La requête n'est pas valide!");
			return false; 
		}
	}
	
	public function fetch($sql)
	{
		$return = array();
		if($result = $this->query($sql))
		{
			while($val=mysql_fetch_array($result))
			{
				$return[] = $val;
			}
			return $return;
		}
		else{
			throw new \Exception("La requête n'est pas valide!");
			return false; 
		}
	}
	
	public function listTables(){
		$tableNames = array();
		if($this->_link){
			$result = mysql_query('SHOW TABLES');
			for($i = 0; $i < mysql_num_rows($result); $i++){
				$tableNames[$i] = mysql_tablename($result, $i);
			}
		}
		return $tableNames;
	}

	
	/* Fonctions supplémenatires liées à une table */
	
	public function nbFields($tableName)
	{
		$sql = "SELECT * FROM ".$tableName;
		if($result = $this->query($sql))
			if($nb = mysql_num_fields($result))
				return $nb;
			else{
				throw new Exception("Aucun champ trouvé!");
				return false; 
			}
		else{
			return false; 	
		}
	}
	
	public function getPK($tableName)
	{
		$primaryKey = false;
		$sql = "SELECT * FROM ".$tableName;
		if($result = $this->query($sql)){
			if($fieldsNumber = $this->nbFields($tableName)){
				for ($v=0; $v < $fieldsNumber; $v++){
					$fieldsName[$v] = mysql_field_name($result, $v);
					$fieldsFlag[$v] = mysql_field_flags($result, $v);
					$flags_tab = explode(' ',$fieldsFlag[$v]);
					foreach($flags_tab as $Flag){
						if($Flag == 'primary_key'){
							$primaryKey = $fieldsName[$v];
						}
					}
				}
			}
		}
		return $primaryKey;
	}
	
	public function getFieldsNames($tableName)
	{
		$fieldsNames = array();
		$sql = "SELECT * FROM ".$tableName;
		if($result = $this->query($sql)){
			if($fieldsNumber = $this->nbFields($tableName)){
				for ($v=0; $v < $fieldsNumber; $v++){
					$fieldsNames[] = mysql_field_name($result, $v);
				}
			}
		}
		return $fieldsNames;
	}
	
	public function getNotNullFields($tableName)
	{
		$notNullFields = array();
		$sql = "SELECT * FROM ".$tableName;
		if($result = $this->query($sql)){
			if($fieldsNumber = $this->nbFields($tableName)){
				for ($v=0; $v < $fieldsNumber; $v++){
					$fieldsName[$v] = mysql_field_name($result, $v);
					$fieldsFlag[$v] = mysql_field_flags($result, $v);
					$flags_tab = explode(' ',$fieldsFlag[$v]);
					foreach($flags_tab as $Flag){
						if($Flag == 'not_null' && $fieldsName[$v] != $this->getPK($tableName)){
							$notNullFields[] = $fieldsName[$v];
						}
					}
				}
			}
		}
		return $notNullFields;
	}
}
?>