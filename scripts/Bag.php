<?php
	class Bag {
		
		private $pdo;
		private $errors = [];
		
		public function __construct($pdo, $id) {
			$this->pdo = $pdo;
			$this->id = $id;
			$this->items = [];
		}
		
		public function errors() {
			return $this->errors;
		}
		
		public function addItem($item) {
			$index = $item['itemID'];
			$count = $item['count'];
			$this->items[$index] = $count;
		}
		
		public function useItem() {
			
		}
		
		public function tossItem() {
			
		}
		
		public function update() {
			//$statement = $pdo->prepare("UPDATE bag SET )
		}
		
		public static function get($pdo, $id) {
			$statement = $pdo->prepare("SELECT itemID, count FROM bag WHERE id = ?");
			$statement->execute([$id]);
			if($statement->rowCount() === 0) {
				return null;
			}
			$data = $statement->fetchAll();
			$bag = new Bag($pdo, $id);
			foreach($data as $item) {
				$bag->addItem($item);
			}
			return $bag;
		}
		
		/*Error check this*/
		public function insert() {
			$sql = $this->pdo->prepare("INSERT INTO users SET username=?, password=?, email=?");
			$sql->execute([$this->username, hash('sha256', $this->password), $this->email]);
		}
	}