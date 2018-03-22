<?php
class Manager{
	protected function dbConnect(){
		$db = new PDO('mysql:host=localhost;dbname=projet;charset=utf8', 'root', '');
		return $db;
	}
}