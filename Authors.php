<?php	
	
	class Author{
		private $author_name;

		public function __construct($author_name){
			$this->author_name = $author_name;
		}

		public function getAuthor_name(){
			return $this->author_name;
		}

		public function setAuthor_name($author_name){
			$this->author_name = $author_name;
		}

		public function ispis(){
			echo "$this->author_name<br/>";
		}

		static function SelectAuthor($con){
			$sql = "SELECT * FROM authors";
			$result = mysqli_query($con, $sql);

			if(!$result){
				die("Query failed ".mysqli_error($con));
			}

			while($row = mysqli_fetch_row($result)){
				//var_dump($row);
				echo "$row[0]. $row[1]";
				echo "<br/>";
			}

			mysqli_free_result($result);
		}

		public function InsertAuthor($con){
			$sql = "INSERT INTO `authors`(`author_name`) VALUES (?)";
			$stmt = $con->prepare($sql);
			$stmt->bind_param("s", $this->getAuthor_name());

			if($stmt->execute()){
				echo "New record has id: " . mysqli_insert_id($con);
				echo "<br/>";
			}else{
				echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
				echo "<br/>";
			}
			$stmt->close();
		}

		public function UpdateAuthor($con, $id){
			$sql = "UPDATE `authors` SET `author_name`=? WHERE author_id=?";
			$stmt = $con->prepare($sql);
			$stmt->bind_param("si", $this->getAuthor_name(), $id);

			if($stmt->execute()){
				echo "Succesfuly updated author with id: $id";
				echo "<br/>";
			}else{
				echo "Update failed: (" . $stmt->errno . ") " . $stmt->error;
				echo "<br/>";
			}

			$stmt->close();
		}
		static function DeleteAuthor($con, $id){
			
			$sql = "DELETE FROM `authors` WHERE author_id=?";
			$stmt = $con->prepare($sql);
			$stmt->bind_param("i", $id);

			if($stmt->execute()){
				echo "Succesfuly deleted author with id: $id";
				echo "<br/>";
			}else{
				echo "Delete failed: (" . $stmt->errno . ") " . $stmt->error;
				echo "<br/>";
			}

			$stmt->close();
		}
	}

	
?>