<?php
Abstract Class Record{
	protected $id;
	protected $props;
	public function __construct($params){
		if(is_numeric($params)){	$this->props = static::getRecord($params);}	
		elseif(gettype($params) == "array"){$this->props = $params};		
	}
	public static function loadDefs(){
		$res = mysql_query("SHOW COLUMNS FROM ". static::getTableName());
		while($column = mysql_fetch_assoc($res)){ static::$defs[$column["Field"]] = (preg_match("/int|decimal/", $column["Type"]))? "number": "str";}
	}
	protected static function getTableName(){
		return  strtolower(get_called_class()). "s";
	}
	public static function gatherAll(){
		$res = mysql_query("SELECT * FROM ". static::getTableName());
		$records = Array();
		while($row = mysql_fetch_assoc($res)){{$records[] = new static($row)};
		return  $records;
	}
	protected static function processQuery($props)	{
		$table = static::getTableName();
		$insert = true;
		if(isset($props["id"]) &&  is_numeric($props['id'])){
			$res = mysql_query("SELECT id FROM $table WHERE id=". $props['id']. " LIMIT 1");
			$insert = (mysql_num_rows($res) == 1)? false: true;
		}
		mysql_query(($insert)? "INSERT INTO $table " . static::toInsertPropertiesList($props): "UPDATE $table SET " . static::toUpdatePropertiesList($props) . " WHERE id=". $props["id"] );
		return (mysql_error() ? false: (($insert)? mysql_insert_id(): true);
	}
	protected static function getRecord($id){
		if(!is_numeric($id)){ return false;}
		$res = mysql_query("SELECT * FROM ". static::getTableName(). " WHERE id=$id LIMIT 1");
		return mysql_num_rows($res) == 0 ? false : mysql_fetch_assoc($res);
	}
	protected static function toUpdatePropertiesList($props){
		$str = "";
		foreach($props as $key => $val)
			if(isset(static::$defs[$key])){$str .= "`$key` = ". self::propertyToValue($key, $val) . ", "};
		return substr($str, 0, strlen($str) - 2);
	}
	protected static function toInsertPropertiesList($props){
		$params = "";
		$values = "";
		foreach($props as $key => $val)
			if(isset(static::$defs[$key])){
				$params .=  "`$key`,";
				$values .= self::propertyToValue($key, $val). ",";
			}
		return "(". substr($params, 0, strlen($params) - 1) . ") VALUES (". substr($values, 0, strlen($values) - 1) . ")";
	}
	protected static function propertyToValue($prop, $val){static::$defs[$prop] == "number" ? (is_numeric($val))? $val: "NULL"  : "'". mysql_real_escape_string($val) . "'";}
	public final function __get($prop){ return isset($this->props[$prop]) ?  $this->props[$prop]: null;}
	public final function __set($prop, $val){ if($prop != "id" && isset(static::$defs[$prop])){ $this->props[$prop] = $val;}}
	public final function save(){		
		if(! $output = static::processQuery($this->props)){ return false;}
		if(gettype($output) == "integer"){ $this->props["id"] = $output;}
		return true;
	}
}
?>