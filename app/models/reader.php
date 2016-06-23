<?php
class Reader extends BaseModel{

	public $id, $username, $password;

	public function __construct($attributes){
		parent::__construct($attributes);
		$this->validators = array('validate_username_is_unique', 'validate_username_not_empty', 'validate_password_not_empty', 'validate_username_length', 
			'validate_password_length');
	}

	// Funktio hakee tietokannasta kaikki käyttäjät ja järjestää ne
	// kirjoitettujen arvostelujen määrän mukaan 
	public static function all(){
		$query = DB::connection()->prepare(
			'SELECT r.* FROM Reader r 
				LEFT JOIN Review rev ON r.id = rev.reader_id 
				GROUP BY r.id, username, password 
				ORDER BY COUNT(rev.reader_id) DESC'
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

	// Funktio hakee tietyn käyttäjän id:n perusteella
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

	// Funktio hakee käyttäjän kirjoittamien arvostelujen määrän
	public function getReviewCount(){
		$query = DB::connection()->prepare(
			'SELECT COUNT(*) FROM Review WHERE Review.reader_id = :id;'
			);
		$query->execute(array('id' => $this->id));
		$row = $query->fetch();
		return $row[0];
	}

	// Funktio hakee käyttäjän luekemien kirjojen määrän
	public function getBooksReadCount(){
		$query = DB::connection()->prepare(
			'SELECT COUNT(*) FROM MyBook WHERE reader_id = :id AND status = 1;'
			);
		$query->execute(array('id' => $this->id));
		$row = $query->fetch();
		return $row[0];
	}

	// Funktio tallentaa uuden käyttäjän 
	public function save(){
		$query = DB::connection()->prepare('
			INSERT INTO Reader (username, password) 
				VALUES (:username, :password) 
				RETURNING id
		');
		$query->execute(array('username' => trim($this->username), 'password' => trim($this->password)));
		$row = $query->fetch();
		$this->id = $row['id'];
	}

	// Funktio vaihtaa käyttäjän salasanan
	public function updatePassword($password){
		$query = DB::connection()->prepare('
			UPDATE Reader SET
				password = :password
				WHERE id = :id
		');
		$query->execute(array('id' => $this->id, 'password' => $password));
	}

	// Funktio poistaa käyttäjän. Kun käyttäjä poistetaan, poistuvat myös hänen
	// kirjoittamat arvostelut ja lukulistan sisältö
	public function destroy(){
		$query = DB::connection()->prepare(
			'DELETE FROM Reader WHERE id = :id'
			);
		$query->execute(array('id' => $this->id));
	}

	// Funktio, joka tarkistaa onko halutulla tunnuksella ja salasanalla varustettua käyttäjää olemassa 
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

	// Validaattorit
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

	public function validate_username_length(){
		return parent::validate_string_not_too_long($this->username, 50, 'Username cannot be this long!');
	}

	public function validate_password_not_empty(){
		return self::validate_field_not_null($this->password, 'Password cannot be empty!'); 
	}

	public function validate_password_length(){
		return parent::validate_string_not_too_long($this->password, 50, 'Password cannot be this long!');
	}
}