<?php
	class Quote{
		private $conn;
		private $table = 'quote';

		public $id;
		public $quote;
		public $author;
		public $category;
		public $author_id;
		public $category_id;

		public function __construct($db) {
			$this->conn = $db;
		}

    
		public function create() {
			$query = 'INSERT INTO ' .
				$this->table . '(quote, author_id, category_id)
			VALUES(
				 :quote, :author_id, :category_id)';

			$stmt = $this->conn->prepare($query);
			$this->quote = htmlspecialchars(strip_tags($this->quote));
			$this->author_id = htmlspecialchars(strip_tags($this->author_id));
			$this->category_id = htmlspecialchars(strip_tags($this->category_id));
			$stmt->bindParam(':quote', $this->quote);
			$stmt->bindParam(':author_id', $this->author_id);
			$stmt->bindParam(':category_id', $this->category_id);

			if ($stmt->execute()) {
				return true;
			}

			printf("Error: %s.\n", $stmt->error);
			return false;

			if ($categories->category != null) {
				$category_arr = array(
					'id' => $categories->id,
					'category' => $categories->category
				);

				echo json_encode($category_arr);
			} else {
				echo json_encode(
					array('message' => 'category_id Not Found')
				);
			}
		}


		public function update() {
			$query = 'UPDATE ' .
				$this->table . '
			SET
				quote = :quote,
				author_id = :author_id,
				category_id = :category_id
			WHERE
				id = :id';

			$stmt = $this->conn->prepare($query);
			$this->quote = htmlspecialchars(strip_tags($this->quote));
			$this->author_id = htmlspecialchars(strip_tags($this->author_id));
			$this->category_id = htmlspecialchars(strip_tags($this->category_id));
			$this->id = htmlspecialchars(strip_tags($this->id));
			$stmt->bindParam(':quote', $this->quote);
			$stmt->bindParam(':author_id', $this->author_id);
			$stmt->bindParam(':category_id', $this->category_id);
			$stmt->bindParam(':id', $this->id);

			if ($stmt->execute()) {
				return true;
			}

			printf("Error: %s.\n", $stmt->error);
			return false;

			echo $query;
		}
    
		public function all_quotes() {
			$query = 'SELECT
				quote.id,
				quote.quote,
				author.author,
				category.category
			FROM
				' . $this->table . '
			INNER JOIN
				author
			ON
				quote.author_id = author.id
			INNER JOIN
				category
			ON
				quote.category_id = category.id
			ORDER BY
				id';

			$stmt = $this->conn->prepare($query);
			$stmt->execute();
			return $stmt;
		}

		public function get_one() {
			if (isset($_GET['id'])) {
				$query = 'SELECT
					quote.id,
					quote.quote,
					author.author,
					category.category
				FROM
					' . $this->table . '
				INNER JOIN
					author
				ON
					quote.author_id = author.id
				INNER JOIN
					category
				ON
					quote.category_id = category.id
				WHERE
					quote.id = :id
				LIMIT 1';

				$stmt = $this->conn->prepare($query);

				$stmt->bindParam(':id', $this->id);
				$stmt->execute();

				$row = $stmt->fetch(PDO::FETCH_ASSOC);

				if (is_array($row)) {
					$this->quote = $row['quote'];
					$this->author = $row['author'];
					$this->category = $row['category'];
				}
			}

			if (isset($_GET['author_id']) && isset($_GET['category_id'])) {
				$query = 'SELECT
					quote.id,
					quote.quote,
					author.author,
					category.category
				FROM
					' . $this->table . '
				INNER JOIN
					author
				ON
					quote.author_id = author.id
				INNER JOIN
					category
				ON
					quote.category_id = category.id
				WHERE
					quote.author_id = :author_id
				AND
					quote.category_id = :category_id
				ORDER BY quote.id';

				$this->author_id = $_GET['author_id'];
				$this->category_id = $_GET['category_id'];
				$stmt = $this->conn->prepare($query);
				$stmt->bindParam(':author_id', $this->author_id);
				$stmt->bindParam(':category_id', $this->category_id);
				$stmt->execute();

				$quotes = [];

				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					extract($row);

					$quotes[] = [
						'id' => $id,
						'quote' => $quote,
						'author' => $author,
						'category' => $category
					];
				}

				return $quotes;
			}

			if (isset($_GET['author_id'])) {
				$query = 'SELECT
					quote.id,
					quote.quote,
					author.author,
					category.category
				FROM
					' . $this->table . '
				INNER JOIN
					author
				ON
					quote.author_id = author.id
				INNER JOIN
					category
				ON
					quote.category_id = category.id
				WHERE
					quote.author_id = :id
				ORDER BY quote.id';

				$stmt = $this->conn->prepare($query);
				$stmt->bindParam(':id', $this->id);
				$stmt->execute();

				$quotes = [];

				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					extract($row);

					$quotes[] = [
						'id' => $id,
						'quote' => $quote,
						'author' => $author,
						'category' => $category
					];
				}

				return $quotes;
			}

			if (isset($_GET['category_id'])) {
				$query = 'SELECT
					quote.id,
					quote.quote,
					author.author,
					category.category
				FROM
					' . $this->table . '
				INNER JOIN
					author
				ON
					quote.author_id = author.id
				INNER JOIN
					category
				ON
					quote.category_id = category.id
				WHERE
					quote.category_id = :id
				ORDER BY quote.id';

				$stmt = $this->conn->prepare($query);
				$stmt->bindParam(':id', $this->id);
				$stmt->execute();

				$quotes = [];

				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					extract($row);

					$quotes[] = [
						'id' => $id,
						'quote' => $quote,
						'author' => $author,
						'category' => $category
					];
				}

				return $quotes;
			}
		}




		public function delete() {
			$query = 'DELETE FROM ' .
				$this->table .
			' WHERE id = :id';

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
