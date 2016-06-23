<?php
class Reader extends BaseModel{

	public $id, $username, $password, $reviewCount;

	public function __construct($attributes){
		parent::__construct($attributes);
		$this->validators = array('validate_username_is_unique', 'validate_username_not_empty', 'validate_password_not_empty');
	}

	public static function all(){
		$query = DB::connection()->prepare(
			'SELECT r.*, COUNT(rev.reader_id) AS reviews FROM Reader r 
				LEFT JOIN Review rev ON r.id = rev.reader_id 
				GROUP BY r.id, username, password 
				ORDER BY reviews DESC'
		);
		$query->execute();
		$rows = $query->fetchAll();
		$users = array();

		foreach ($rows as $row) {
			$users[] = new Reader(array(
				'id' => $row['id'],
				'username' => $row['username'],
				'password' => $row['password']
			));		
		}

		return $users;
	}

	public static function find($id){
		$query = DB::connection()->prepare(
			'SELECT * FROM Reader WHERE id = :id LIMIT 1'
			);
		$query->execute(array('id' => $id));
		$row = $query->fetch();

		if($row){
			$user = new Reader(array(
				'id' => $row['id'],
				'username' => $row['username'],
				'password' => $row['password']
				));

			return $user;
		}

		return null;
	}

	// public static function getLeaderboard(){
	// 	$query = DB::connection()->prepare('SELECT * FROM Reader ORDER BY Reader.username');
	// 	$query->execute();
	// 	$rows = $query->fetchAll();
	// 	$users = array();

	// 	foreach ($rows as $row) {
	// 		$users[] = new Reader(array(
	// 			'id' => $row['id'],
	// 			'username' => $row['username'],
	// 			'password' => $row['password']
	// 		));		
	// 	}

	// 	return $users;
	// }

	public function getReviewCount(){
		$query = DB::connection()->prepare(
			'SELECT COUNT(*) FROM Review WHERE Review.reader_id = :id;'
			);
		$query->execute(array('id' => $this->id));
		$row = $query->fetch();
		return $row[0];
	}

	public function getBooksReadCount(){
		$query = DB::connection()->prepare(
			'SELECT COUNT(*) FROM MyBook WHERE reader_id = :id AND status = 1;'
			);
		$query->execute(array('id' => $this->id));
		$row = $query->fetch();
		return $row[0];
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

	public static function updatePassword($password, $id){
		$query = DB::connection()->prepare('
			UPDATE Reader SET
				password = :password
				WHERE id = :id
		');
		$query->execute(array('id' => $id, 'password' => $password));
	}

	public function destroy(){
		$query = DB::connection()->prepare(
			'DELETE FROM Reader WHERE id = :id'
			);
		$query->execute(array('id' => $this->id));
	}

	public static function authenticate($username, $password){
		$query = DB::connection()->prepare('SELECT * FROM Reader WHERE username = :username AND password = :password LIMIT 1');
		$query->execute(array('username' => $username, 'password' => $password));
		$row = $query->fetch();
		if($row){
	 		return new Reader(array(
				'id' => $row['id'],
				'username' => $row['username'],
				'password' => $row['password']
				));
		}else{
	  		return null;
		}
	}

	public function validate_username_is_unique(){
		$query = DB::connection()->prepare('SELECT * FROM Reader WHERE username = :username LIMIT 1');
		$query->execute(array('username' => $this->username));
		$row = $query->fetch();

		if($row){
			return 'Choose another username!';
		}
	}

	public function validate_username_not_empty(){
		return self::validate_field_not_null($this->username, 'Username cannot be empty!'); 
	}

	public function validate_password_not_empty(){
		return self::validate_field_not_null($this->password, 'Password cannot be empty!'); 
	}
}