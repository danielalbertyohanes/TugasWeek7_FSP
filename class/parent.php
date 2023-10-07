<?php
require_once("data.php");

class Parentclass
{
	protected $mysqli;
	public function __construct()
	{
		$this->mysqli = new mysqli(SERVER, USERID, PASSWORD, DATABASE);
	}
	function __destruct()
	{
		$this->mysqli->close();
	}
}
