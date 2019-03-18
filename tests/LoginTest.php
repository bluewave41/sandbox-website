<?php

declare(strict_types=1);
require('./scripts/MockDatabase.php');

use PHPUnit\Framework\TestCase;

final class LoginTest extends TestCase {
	
    public function testUsernameMissing(): void {
		$user = new User(new MockDatabase(false), '', 'a', 'a');
		$user->isValid();
		$errors = $user->errors();
		$this->assertTrue(count($errors) === 1);
		$this->assertTrue($errors[0] === "Username cannot be empty.");
    }
	
	public function testPasswordMissing(): void {
		$user = new User(new MockDatabase(false), 'a', '', 'a');
		$user->isValid();
		$errors = $user->errors();
		$this->assertTrue(count($errors) === 1);
		$this->assertTrue($errors[0] === "Password cannot be empty.");
    }
	
	public function testEmailMissing(): void {
		$user = new User(new MockDatabase(false), 'a', 'a', '');
		$user->isValid();
		$errors = $user->errors();
		$this->assertTrue(count($errors) === 1);
		$this->assertTrue($errors[0] === "Email cannot be empty.");
    }
	
	public function testAccountAlreadyExists(): void {
		$user = new User(new MockDatabase(true), 'a', 'a', 'a');
		$user->isValid();
		$errors = $user->errors();
		$this->assertTrue(count($errors) === 1);
		$this->assertTrue($errors[0] === "Username already exists.");
    }
}
