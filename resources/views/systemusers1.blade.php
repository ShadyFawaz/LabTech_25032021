<!DOCTYPE html>
<html>
<head>
<title>users Management | Add</title>
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
<form action = "{{url('create')}}" method = "post">
    {{ method_field('post') }}
    {{ csrf_field() }}
	<table>
	<tr>
	<td>login name</td>
	<td><input type='text' name='login_name' /></td>
	<tr>
	<td>user name</td>
	<td><input type="text" name='user_name'/></td>
	</tr>
	<tr>
	<td>password</td>
	<td><input type="text" name='Password'/></td>
	</tr>

	<tr>
	<td colspan = '2'>
	<input type = 'submit' value = "New User"/>
	</td>
	</tr>
	</table>
</form>
</body>
</html>