<?php
class Reader extends BaseModel{

	public $id, $username, $password;

	public function __construct($attributes){
		parent::__construct($attributes);
	}

	public static function find($id){
		$query = DB::connection()->prepare(
			'SELECT * FROM Reader WHERE id = :id LIMIT 1'
			);
		$query->execute(array('id' => $id));
		$row = $query->fetch();

		if($row){
			$user = new User(array(
				'id' => $row['id'],
				'username' => $row['username'],
				'password' => $row['password']
				));

			return $user;
		}

		return null;
	}

	public function save(){
		$query = DB::connection()->prepare('
			INSERT INTO Reader (username, password) 
				VALUES (:username, :password) 
				RETURNING id
		');
		$query->execute(array('username' => $this->username, 'password' => $this->password));
		$row = $query->fetch();
		$this->id = $row['id'];
	}

	public static function authenticate($username, $password){
		$query = DB::connection()->prepare('SELECT * FROM Reader WHERE username = :username AND password = :password LIMIT 1');
		$query->execute(array('username' => $username, 'password' => $password));
		$row = $query->fetch();
		if($row){
	 		return new User(array(
				'id' => $row['id'],
				'username' => $row['username'],
				'password' => $row['password']
				));
		}else{
	  		return null;
		}
	}
}