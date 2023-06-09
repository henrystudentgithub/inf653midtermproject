<?php
	class Category{
		private $conn;
		private $table = 'category';

		public $id;
		public $category;

		public function __construct($db) {
			$this->conn = $db;
		}

		public function all_categories() {
			$query = 'SELECT id,category FROM' . $this->table . '	ORDER BY id';

			$stmt = $this->conn->prepare($query);
			$stmt->execute();
			return $stmt;
		}

		public function get_one() {
			$query = 'SELECT id, category FROM ' . $this->table . ' WHERE id = :id LIMIT 1';

			$stmt = $this->conn->prepare($query);
			$stmt->bindParam(':id', $this->id);
			$stmt->execute();

			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			if (is_array($row)) {
				$this->id = $row['id'];
				$this->category = $row['category'];
			}
		}


		public function create() {
			$query = 'INSERT INTO ' . $this->table . '(category) VALUES (:category)';

			$stmt = $this->conn->prepare($query);
			$this->category = htmlspecialchars(strip_tags($this->category));
			$stmt->bindParam(':category', $this->category);

			if ($stmt->execute()) {
				return true;
			}

			printf("Error: %s.\n", $stmt->error);
			return false;
		}


		public function update() {
			$query = 'UPDATE ' . $this->table . ' SET category = :category WHERE id = :id';

			$stmt = $this->conn->prepare($query);
			$this->category = htmlspecialchars(strip_tags($this->category));
			$this->id = htmlspecialchars(strip_tags($this->id));
			$stmt->bindParam(':category', $this->category);
			$stmt->bindParam(':id', $this->id);

			if ($stmt->execute()) {
				return true;
			}

			printf("Error: %s.\n", $stmt->error);
			return false;

			echo $query;
		}


		public function delete() {
			$query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

			$stmt = $this->conn->prepare($query);

			$this->id = htmlspecialchars(strip_tags($this->id));

			$stmt->bindParam(':id', $this->id);

			if ($stmt->execute()) {
				return true;
			}

			printf("Error: %s.\n", $stmt->error);
			return false;
		}
	}
?>
