<?php
	class Collection {
		
		private $pdo;
		private $errors = [];
		
		public function __construct($pdo, $id, $tableName) {
			$this->values = [];
			$this->get($pdo, $id, $tableName);
		}
		
		protected function addValue($value) {
			array_push($this->values, $value);
		}
		
		protected function addValueIndex($index, $value) {
			$this->items[$index] = $value;
		}
		
		public function errors() {
			return $this->errors;
		}
		
		public function update() {
			//$statement = $pdo->prepare("UPDATE bag SET )
		}
		
		/*ONLY RUN ON SESSION DATA. NEVER SEND ID BY PARAMETER*/
		public function get($pdo, $id, $tableName) {
			$statement = $pdo->prepare("SELECT * FROM $tableName WHERE id = ?");
			$statement->execute([$id]);
			if($statement->rowCount() === 0) {
				return null;
			}
			$data = $statement->fetchAll();
			foreach($data as $item) {
				$this->addValue($item);
			}
		}
		
		/*Error check this*/
		public function insert() {
			$sql = $this->pdo->prepare("INSERT INTO users SET username=?, password=?, email=?");
			$sql->execute([$this->username, hash('sha256', $this->password), $this->email]);
		}
	}