<?php
class Reader extends BaseModel{

	public $id, $username, $password;

	public function __construct($attributes){
		parent::__construct($attributes);
	}

	public static function all(){
		$query = DB::connection()->prepare('SELECT * FROM Reader');
		$query->execute();
		$rows = $query->fetchAll();
		$readers = array();

		foreach ($rows as $row) {
			$readers[] = new Reader(array(
				'id' => $row['id'],
				'username' => $row['username'],
				'password' => $row['password']
			));		
		}

		return $readers;
	}

	public static function find($id){
		$query = DB::connection()->prepare(
			'SELECT * FROM Reader WHERE id = :id LIMIT 1'
			);
		$query->execute(array('id' => $id));
		$row = $query->fetch();

		if($row){
			$reader = new Reader(array(
				'id' => $row['id'],
				'username' => $row['username'],
				'password' => $row['password']
				));

			return $reader;
		}

		return null;
	}
}