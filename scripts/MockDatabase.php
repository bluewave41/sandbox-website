<?php
	class MockDatabase {
		public function __construct($data) {
			$this->data = $data;
		}
		
		public function prepare() {
			return $this;
		}
		
		public function execute() {
			return $this;
		}
		
		public function fetch() {
			return $this->data;
		}
	}