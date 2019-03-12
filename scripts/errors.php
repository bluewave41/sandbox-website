<?php	
	/*Code should match code of $errors*/
	function getError($code) {
		$errors = [
			[-1, "Username cannot be empty."],
			[-2, "Password cannot be empty."],
			[-3, "Email cannot be empty."],
			[-4, "Username contains invalid characters."],
			[-5, "Usernames must be less than 20 characters."],
			[-6, "Username already exists."],
			[-7, "Username or password are incorrect"],
			[-8, "You already have the maximum number of keys."],
			[-9, "You didn't provide an apikey."],
			[-10, "You didn't specify an endpoint."],
			[-11, "Invalid apikey."],
			[-12, "You aren't logged in."],
		];
		return $errors[abs($code)-1];
	}
?>