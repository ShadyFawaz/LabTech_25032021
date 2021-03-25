<!DOCTYPE html>
<html>
<head>
<title>Student Management | Add</title>
</head>
<body>
@if (session('status'))
<div class="alert alert-success" role="alert">
	<button type="button" class="close" data-dismiss="alert">×</button>
	{{ session('status') }}
</div>
@elseif(session('failed'))
<div class="alert alert-danger" role="alert">
	<button type="button" class="close" data-dismiss="alert">×</button>
	{{ session('failed') }}
</div>
@endif
<form action = "/create" method = "post">
	<input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
	<table>
	<tr>
	<td>Login Name</td>
	<td><input type='text' name='login_name' /></td>
	<tr>
	<td>User Name</td>
	<td><input type="text" name='user_name'/></td>
	</tr>
	<tr>
	<td>Password</td>
	<td>
	<td><input type="text" name='passowrd'/></td>	
	</select></td>
	</tr>
	<tr>
	<td colspan = '2'>
	<input type = 'submit' value = "Create User"/>
	</td>
	</tr>
	</table>
</form>
</body>
</html>