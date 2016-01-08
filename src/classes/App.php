<?php
class App
{
	private static $config = array();
	private static $database;
	private static $baseUrl;
	
	// Singleton
	private static $_instance = null;
	public static function init($config) {
		if(is_null(self::$_instance)){
			$c = __CLASS__;
			//$c = get_called_class(); 
			self::$_instance = new $c($config);
		}
		return self::$_instance;
	}
	
	protected function __construct($config)
	{
		if(count($config["db"]) != 4){
			throw new \Exception("Le nombre d'arguments n'est pas valable!");
		}
		spl_autoload_register(array(__CLASS__, 'autoload'));
		self::$config = $config;
		self::$database = new Core\Db\ConnectPDO(self::$config["db"]); 
		self::$baseUrl = rtrim(dirname($_SERVER['PHP_SELF']), '/.\\');
		
		$route = isset($_GET["r"]) ? $_GET["r"] : $_SERVER["REQUEST_URI"];
		$url = parse_url($route);
		$path = preg_replace('/^'.preg_quote(self::$baseUrl, '/').'\//', "", $url["path"]); 
		$query = @$url["query"]; 
		$method = $_SERVER['REQUEST_METHOD'];
		$request = new Core\Http\Request($method, $path, $query); 
		$dispatcher = new Core\Http\Dispatcher();
		try{ 
			$dispatcher->handle($request); 
		}
		catch(Exception $e){ 
			$code = '404';
			header($_SERVER["SERVER_PROTOCOL"]." ".$code); 
			$request = new Core\Http\Request('GET', 'Site/error', 'code='.$code.'&message='.$e->getMessage());
			$dispatcher->handle($request); 
		}
	}
	
	static function autoload($className){
		$file = 'src/classes/'.str_replace('\\', '/', $className).'.class.php';
		if(file_exists($file))
			require_once $file; 
		else
			throw new \Exception("Fichier ".$file." introuvable");
    }
	
	public static function db()
	{
		if(empty(self::$config)){
			throw new \Exception("Veuillez exécuter App::init() auparavant!");
		}
		return self::$database;
	}
	
	public static function getBaseUrl($absolute=false)
	{
		$hostInfo = 'http://'.$_SERVER['HTTP_HOST'];
		
		return $absolute ? $hostInfo.self::$baseUrl : self::$baseUrl;
	}
}
?>