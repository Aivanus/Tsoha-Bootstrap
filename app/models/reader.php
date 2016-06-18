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

		if(!$this->validate_name_is_unique()){
			return false;
		}

		$query = DB::connection()->prepare('
			INSERT INTO Reader (username, password) 
				VALUES (:username, :password) 
				RETURNING id
		');
		$query->execute(array('username' => $this->username, 'password' => $this->password));
		$row = $query->fetch();
		$this->id = $row['id'];

		return true;
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

	public function validate_name_is_unique(){
		$query = DB::connection()->prepare('SELECT * FROM Reader WHERE username = :username LIMIT 1');
		$query->execute(array('username' => $this->username));
		$row = $query->fetch();

		if($row){
			return false;
		}
		
		return true;
		
	}
}