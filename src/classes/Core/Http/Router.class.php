<?php
namespace Core\Http;

class Router 
{
	public function __construct(){
		
	}
	
    private $routes = array(
        'get' => array(),
        'post' => array(),
    );

    public function get($pattern, $callable) {
        $this->routes['get'][$pattern] = $callable;
        return $this;
    }

    public function post($pattern, $callable) {
        $this->routes['post'][$pattern] = $callable;
        return $this;
    }

    public function match($request) {
        $method = strtolower($request->getMethod());
        if (!isset($this->routes[$method])) {
            throw new \Exception('REQUEST_METHOD does not exist');
        }

        $path = $request->getPath();
        foreach ($this->routes[$method] as $pattern => $callable) {
            if ($pattern === $path) {
                return $callable;
            }
        }

        return false;
    }
	
	public function parse($request){
		$method = strtolower($request->getMethod());
		$params = explode('/', $request->getPath()); 
		$controller = @$params[0] ? $params[0] : 'Site';
		$action = @$params[1] ? $params[1] : 'index';
		if($request->getQuery()) 
			parse_str($request->getQuery(), $params);
		else
			$params = array_slice($params, 2); 
				
		return array(
			'controller'=>$controller,
			'action'=>$action,
			'params'=>$params,
		);
	}
	
}
?>