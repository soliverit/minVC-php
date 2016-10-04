<?php
Class MainController{
	public static function edit($params, $class){
		$object = new $class($params['id']);
		if(isset($params['form'])){
			foreach($params['form'] as $key => $val){ $object->$key = $val;}
			$object->save();}
		return Array("object" => $object);
	}
	public static function index($params, $class){return Array("collection" => $class::gatherAll());}
	public static function create($params, $class){ return Array(); }
	public static function show($params, $class){return Array("object" => new $class($params['id']));}}
}
?>