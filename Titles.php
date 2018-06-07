<?php	
	
	class Title{
		private $title;
		private $author;
		private $genre;
		private $release_year;

		public function __construct($title, $author, $release_year, $genre){
			$this->title = $title;
			$this->author = $author;
			$this->genre = $genre;
			$this->release_year = $release_year;
		}

		public function getTitle(){
			return $this->title;
		}
		public function getAuthor(){
			return $this->author;
		}
		public function getGenre(){
			return $this->genre;
		}
		public function getRelease_year(){
			return $this->release_year;
		}

		public function setTitle($title){
			$this->title = $title;
		}
		public function setAuthor($author){
			$this->author = $author;
		}
		public function setGenre($genre){
			$this->genre = $genre;
		}
		public function setRelease_year($release_year){
			$this->release_year = $release_year;
		}

		

		static function SelectTitle($con){
			$sql = "SELECT * FROM titles";
			$result = mysqli_query($con, $sql);

			if(!$result){
				die("Query failed ".mysqli_error($con));
			}

			while($row = mysqli_fetch_row($result)){
				//var_dump($row);
				echo "$row[0]. $row[1] $row[2] $row[3] $row[4]";
				echo "<br/>";
			}

			mysqli_free_result($result);
		}

		public function InsertTitle($con){
			$sql = "INSERT INTO titles (`title`, `author`, `release_year`, `genre`) VALUES (?, ?, ?, ?)";
			$stmt = $con->prepare($sql);
			$stmt->bind_param("ssss", $this->getTitle(), $this->getAuthor(), $this->getRelease_year(), $this->getGenre());

			if($stmt->execute()){
				echo "New record has id: " . mysqli_insert_id($con);
				echo "<br/>";
			}else{
				echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
				echo "<br/>";
			}
			$stmt->close();
		}

		public function UpdateTitle($con, $id){
			$sql = "UPDATE `titles` SET `title`=?, `author`=?, `release_year`=?, `genre`=? WHERE title_id=?";
			$stmt = $con->prepare($sql);
			$stmt->bind_param("ssssi", $this->getTitle(), $this->getAuthor(), $this->getRelease_year(), $this->getGenre(), $id);

			if($stmt->execute()){
				echo "Succesfuly updated title with id: $id";
				echo "<br/>";
			}else{
				echo "Update failed: (" . $stmt->errno . ") " . $stmt->error;
				echo "<br/>";
			}

			$stmt->close();
		}
		static function DeleteTitle($con, $id){
			$sql = "DELETE FROM `titles` WHERE title_id=?";
			$stmt = $con->prepare($sql);
			$stmt->bind_param("i", $id);

			if($stmt->execute()){
				echo "Succesfuly deleted title with id: $id";
				echo "<br/>";
			}else{
				echo "Delete failed: (" . $stmt->errno . ") " . $stmt->error;
				echo "<br/>";
			}

			$stmt->close();
		}
	}

	
?>