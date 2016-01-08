<?php
namespace Core\Http;

class Request {

	private $method;
	private $path;
	private $query;

	public function __construct($method, $path, $query) {
		$this->method = $method;
		$this->path = $path;
		$this->query = $query;
	}

	public function getMethod() {
		return $this->method;
	}

	public function getPath() {
		return $this->path;
	}
	
	public function getQuery() {
		return $this->query;
	}
	
}
?>