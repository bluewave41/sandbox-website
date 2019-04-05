<?php
	include('Collection.php');
	
	class Bag extends Collection {
		
		public function __construct($pdo, $id) {
			parent::__construct($pdo, $id, 'bag');
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
		
		/*Error check this*/
		public function insert() {
			$sql = $this->pdo->prepare("INSERT INTO users SET username=?, password=?, email=?");
			$sql->execute([$this->username, hash('sha256', $this->password), $this->email]);
		}
	}