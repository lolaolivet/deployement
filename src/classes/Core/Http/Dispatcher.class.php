<?php
namespace Core\Http;

class Dispatcher {

    private $router;

    function __construct() {
        $this->router = new Router();
    }
	
	function loadController($controller){
		$c = '\\Controllers\\'.ucfirst($controller); 
		return new $c();
    }

    function handle($request) {
		/*$handler = $this->router->match($request);
		if (!$handler) {
			throw new \Exception("Could not find your resource!");
		}
		$handler();*/
		
		extract($this->router->parse($request));
		$theController = $this->loadController($controller);
		if(!in_array($action, get_class_methods($theController))){
			throw new \Exception("Le Controller ".$controller." n'a pas de méthode ".$action);
		}
		call_user_func_array(array($theController, $action), $params);
	}
	
}
?>