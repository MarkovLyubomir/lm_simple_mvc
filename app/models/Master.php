<?php 

namespace Models;

class Master
{
	protected $table;
	protected $database;

	function __construct( $arguments = [])
	{
		if (!isset($arguments['table'])) {
			var_dump('Table not defined.');
			die();
		}

		$this->table = $arguments['table'];

		$dbObject = \Lib\Database::getInstance();

		$this->database = $dbObject->getDB();
	}

	public function get($args = [])
	{
		$defaults = [
			'table' => $this->table,
			'where' => '',
			'columns' => '*',
		];

		$args = array_merge( $defaults, $args );

		$query = 'SELECT ' . $args['columns'] . 'FROM ' . $args['table'];

		if ($args['where'] != '') {
			$query .= ' WHERE ' . $args['where'];
		}

		$result = $this->database->query($query);

		return $this->parseResult($result);
	}
	
	public function save($args = [])
	{
		$defaults = [
			'table' => $this->table,
			'columns' => '',
			'values' => []
		];

		$args = array_merge( $defaults, $args );


		$query = 'INSERT INTO ' 
					. $args['table'] . ' 
						('. $args['columns'] . ')  
					VALUES 
						("'. $this->database->real_escape_string($args['values']) .'")';

		return $this->database->query($query);
	}

	public function update($args = [])
	{
		$defaults = [
			'id' => 0,
			'table' => $this->table,
			'columns' => '',
			'values' => ''
		];

		$args = array_merge( $defaults, $args );
		$colValPairs = '';

		for ($i = 0; $i < count($args['columns']); $i++) { 
			$colValPairs .= '`' 
						. $args['columns'][$i] 
						. '` = ' 
						. $this->database->real_escape_string($args['values'][$i]);
		}

		$colValPairs = rtrim( $colValPairs, "," );

		$query =   'UPDATE 
						' . $args['table'] . '
					SET 
						' . $colValPairs . '
					WHERE 
						`id` = ' . $args['id'];

		return $this->database->query($query);
	}

	public function delete($args = [])
	{
		$query = 'DELETE FROM ' . $this->table . ' WHERE `id` = ' . $args['id'];
		return $this->database->query($query);
	}

	protected function parseResult($result)
	{
		$json = [];

		if (!empty($result) && $result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				array_push($json, $row);
			}
		}

		$jsonstring = json_encode($json);
		return $jsonstring;
	}
}