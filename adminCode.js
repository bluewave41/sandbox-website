var backup;

$(document).ready(function() {
	$('body').on('click', '.name', function() {
		$.ajax({
			type: "POST",
			url: 'api/api.php',
			data: {type: 'getUserInfo', apikey: '4faecf3be27bc01d4c4e0a0736eac39e764c168e', username: $(this).text()},
			dataType: 'JSON',
			success: function(data) {
				$('#userList tr').hide();
				showUser(data);
			}
		})
	});
	$('body').on('click', '#back', function() {
		$('#userList tr:visible').remove();
		$('#userList tr').show();
	});
	$('body').on('click', '#update', function() {
		let data = {
			type: 'updateUserInfo',
			apikey: '4faecf3be27bc01d4c4e0a0736eac39e764c168e',
			username: $('#username').val(),
			password: $('#password').val(),
			email: $('#email').val(),
			id: $('#id').text(),
			admin: $('#admin').val(),
		}
		$.ajax({
			type: "POST",
			url: 'api/api.php',
			data: data,
			success: function() {
				$('#userList tr:visible').remove();
				$('#userList tr').show();
			}
		})
	});
});

function showUser(user) {
	let table = `<tr><td>Username: </td><td><input id="username" type="text" value="${user.username}"></input></td></tr>`;
	table += `<tr><td>Password: </td><td><input id="password" type="text" value="${user.password}"</input><td></tr>`;
	table += `<tr><td>Email: </td><td><input id="email" type="text" value="${user.email}"</input><td></tr>`;
	table += `<tr><td>ID: </td><td><span id="id">${user.id}</span><td></tr>`;
	table += `<tr><td>Admin: </td><td><input id="admin" type="text" value="${user.admin}"></input><td></tr>`;
	table += `<tr><td><button id="update">Update</button></td><td><button id="back">Back</button></td></tr>`;
	$('#userList').append(table);
}

function createTable() {
	$.ajax({
		type: "POST",
		url: 'scripts/userList.php',
		dataType: 'JSON',
		success: function(data) {
			let table = '<thead><tr><td>Username</td><td>Password</td><td>Email</td><td>ID</td></tr></thead>';
			for(var x=0;x<data.length;x++) {
				table += `<tr><td class="name">${data[x].username}</td><td>${data[x].password}</td><td>${data[x].email}</td><td>${data[x].id}</td></tr>`;
			}
			$('#userList').html(table);
		}
	});
}