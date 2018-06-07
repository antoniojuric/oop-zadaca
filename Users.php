<?php	
	
	class User{
		private $name;
		private $surname;
		public static $isLoged = false;

		public function __construct($name, $surname){
			$this->name = $name;
			$this->surname = $surname;
		}

		public function getName(){
			return $this->name;
		}
		public function getSurname(){
			return $this->surname;
		}

		public function setName($name){
			$this->name = $name;
		}
		public function setSurname($surname){
			$this->surname = $surname;
		}


		static function SelectUsers($con){
			$sql = "SELECT * FROM users";
			$result = mysqli_query($con, $sql);

			if(!$result){
				die("Query failed ".mysqli_error($con));
			}
			
			while($row = mysqli_fetch_row($result)){
				
				echo "$row[0]. $row[1] $row[2]";
				echo "<br/>";
			}

			mysqli_free_result($result);
		}

		public function InsertUser($con){
			$sql = "INSERT INTO users (name, surname) VALUES (?, ?)";
			$stmt = $con->prepare($sql);
			$stmt->bind_param("ss", $this->getName(), $this->getSurname());

			if($stmt->execute()){
				echo "New record has id: " . mysqli_insert_id($con);
				echo "<br/>";
			}else{
				echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
				echo "<br/>";
			}
			$stmt->close();
		}

		public function UpdateUser($con, $id){
			$sql = "UPDATE `users` SET `name`=?,`surname`=? WHERE user_id=?";
			$stmt = $con->prepare($sql);
			$stmt->bind_param("ssi", $this->getName(), $this->getSurname(), $id);

			if($stmt->execute()){
				echo "Succesfuly updated user with id: $id<br/>";
			}else{
				echo "Update failed: (" . $stmt->errno . ") " . $stmt->error;
				echo "<br/>";
			}

			$stmt->close();
		}
		static function DeleteUser($con, $id){
			$sql = "DELETE FROM `users` WHERE user_id=?";
			$stmt = $con->prepare($sql);
			$stmt->bind_param("i", $id);

			if($stmt->execute()){
				echo "Succesfuly deleted user with id: $id<br/>";
			}else{
				echo "Delete failed: (" . $stmt->errno . ") " . $stmt->error;
				echo "<br/>";
			}

			$stmt->close();
		}

		public function login($con){
			$sql = "SELECT * FROM users WHERE name = '$this->name' AND surname = '$this->surname'";
			$result = mysqli_query($con, $sql);

			if(!$result){
				die("Query failed ".mysqli_error($con));
			}
			$countPerson = 0;
			while($row = mysqli_fetch_row($result)){
				$countPerson++;
			}
			if($countPerson > 0){
				self::$isLoged = true;
				echo "Login successful. Loged as $this->name $this->surname.<br/>";
			}else{
				echo "Login failed. incorrect name or username.<br/>";
			}

			mysqli_free_result($result);
		}

		public static function logout(){
			self::$isLoged = false;
			echo "Logout successful<br/>";
		}
	}
?>