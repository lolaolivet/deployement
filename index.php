<?php 
session_start();

require 'src/classes/App.php';
$config = include("src/config/config.php");   
try{
	$app = App::init($config);
}
catch(Exception $e){
	die('Error: '.$e->getMessage());
}
?>