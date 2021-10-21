<?php
class Database {

	private $database;

	function __construct() {
		$this->database = $this->connect();
	}
	function exec($query) {
		$this->database->exec($query);
	}

	function query($query) {
		$result = $this->database->query($query);
		return $result;
	}

	function querySingle($query) {
		$result = $this->database->querySingle($query,true);
		return $result;
	}

  function __destruct() {
		$this->database->close();
	}

	function prepare($query) {
		return $this->database->prepare($query);
	}

	function html($string) {
		return $this->database->html($string);
	}

	function lastRowId() {
		return $this->database->lastInsertRowId();
	}

	private function connect() {
		$conn = new SQLite3('./database/database.db');
		return $conn;
	}
}
  function html($str){
    return htmlspecialchars($str, ENT_QUOTES, 'utf-8');
  }
?>
