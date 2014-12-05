<?php
class Shape
{

	private $id = '0';
	private $points = array();
	private $contract_date = "";
	private $ratified_date = "";
	private $baseprice = 0; //Baseprice from database
	private $address = ""; //Hosue address
	private $remarks = ""; //comments from database
	
	function __construct($id){
	$this->id = $id;
	}
	
	public function __set($property, $value) {
	if (property_exists($this, $property))
	{
	$this->$property = $value;
	}
	}
	
	public function __get($property) {
    if (property_exists($this, $property)) {
      return $this->$property;
    }
  }
  
  public function getStatus()
  {
	if ( (!(empty($this->ratified_date))) && (!(empty($this->contract_date))) )
		{return "Sold"; }
	else if (!(empty($this->ratified_date)))
		{return "Hold"; }
	else
		{return "Available"; }
  }
  
  public function addPoint($point)
  {
	array_push($this->points,$point);
  }
  
  public function pointsToString()
  {
  $firstTime = true;
  $str = "";
  foreach($this->points as $thisPoint)
	{
	if (!($firstTime))
		{
		$str .= ",";
		}
	$str .= $thisPoint->__get(x) . "," . $thisPoint->__get(y);
	$firstTime = false;
	}
  return rtrim($str, ",");
  }
  
  public function to_json() {
	$string = "{\"id\":\"";
	$string .= $this->id;
	$string .= "\",\"points\":[";
	
		$firstTime = true;
		foreach($this->points as $thisPoint)
		{
		if ($firstTime == false)
			{$string .= ",";}
		$string .= "{\"x\":".$thisPoint->__get(x).",\"y\":".$thisPoint->__get(y)."}";
		$firstTime = false;
		}
	
	$string .= "]}";
	
	return $string;
	
  }
}


class Point
{

	private $x = '0';
	private $y = '0';
	
	function __construct($x, $y){
	$this->x = $x;
	$this->y = $y;
	}
	
	public function __get($property) {
    if (property_exists($this, $property)) {
      return $this->$property;
    }
  }
}
?>