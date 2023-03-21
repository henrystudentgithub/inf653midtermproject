<?php
	class Database {
		private $port;
		private $host;
		private $database_name;
		private $username;
		private $password;
		private $connection;

		public function __construct() {
			// construct database information for db string
			$this->username = getenv('USERNAME');
			$this->password = getenv('PASSWORD');
			$this->host = getenv('HOST');
			$this->port = getenv('PORT');
			$this->database_name = getenv('DATABASE_NAME');
		}

		public function connect() {
			if ($this->connection) {
				return $this->connection;
			} else {
				$dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->database_name};";

				try {
					$this->connection = new PDO($dsn, $this->username, $this->password);
					$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					return $this->connection;
				} catch(PDOException $e) {
					echo 'Connection Error: ' . $e->getMessage();
				}
			}
		}
	}
?>
