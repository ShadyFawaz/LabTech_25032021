<!DOCTYPE html>   
<html>   
<head>    
<title> LabTech Software (System Users) </title>  
<style>   
Body {  
  font-family: sans-serif;  
  background-color: lightgrey;  
}  
button {   
        font-family:  sans-serif;
        background-color: grey;   
        width: 10%;  
        color: Black;   
        padding: 5px;   
        border: none;   
        cursor: pointer;   
         }   
 form {   
        border: 1px solid #f1f1f1;   
    }   
 input[type=text] {   
        font-family: sans-serif;     
        width: 10%;   
        margin: 0px 0px;  
        padding: 3px 2px;   
        display: inline-block;   
        border: 2px black;   
        box-sizing: border-box;   
        text-align: left;
    }
    select {
    width: 10%;  
    margin: 0px 0px;  
    padding: 3px 2px;    
    cursor:pointer;
    display:inline-block;
    position:relative;
    font:normal 11px/22px Serif;
    color:black;
    border:1px solid #ccc;
}  

    label {   
        font-family: serif;  
        width: 10%;   
        margin: 0px 0;  
        padding: 3px 2px;  
        display: inline-block;   
        border: 2px black;   
        box-sizing: border-box; 
        text-align: left; 
    }  
 button:hover {   
        opacity: 0.7;   
    }   
    
    input[type=button] {   
        color:black;   
    }      
     
 .container {   
        padding: 0px;  
        margin: 0px 0;  
        background-color: #B9CDE5;  
    }   

    #table-wrapper {
  position:relative;
}
#table-scroll {
  height:390px;
  overflow:auto;  
  margin-top:20px;
}
#table-wrapper table {
  width:50%;

}
#table-wrapper table * {
  background:white;
  color:black;
  font-size: 13px;
  font-weight:bold;
}
#myInput {
  width: 30%;
  font-size: 14px;
  padding: 10px 15px 10px 20px;
  border: 1px solid #ddd;
  margin-bottom: 10px;
}
.hidetext { -webkit-text-security: disc; /* Default */ }

</style> 
@if(isset(Auth::user()->login_name))
  @else
  <script>window.location = "{{url('/')}}";</script>
  @endif

@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(121))
@else
<script>
alert ('You cannot access this page');
window.location = "{{url('home')}}";
</script>
@endif  
@endif
</head> 
@if(isset(Auth::user()->login_name))
@include('MainMenu') 
@endif  
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
    
<center> <h1> {{__('title.users_all')}} </h1> </center> 
<div id="table-wrapper">
<div id="table-scroll">
<table id="myTable">
<thead>
<tr>
<td><b> User ID </b></td>
<td><b> {{__('title.username_users')}} </b></td>
<td><b> {{__('title.loginname_users')}} </b></td>

</tr>
</thead>
<tbody>
@foreach ($users as $user)
<tr>
<td>{{ $user->user_id }}</td>
<td>{{ $user->user_name }}</td>
<td>{{ $user->login_name }}</td>
@if(isset(Auth::user()->login_name))
@if(Auth::user()->hasPermissionTo(125))
<td><input type="button" onclick="edituser({{$user->user_id}})" value="{{__('title.edit_btn')}}" ></input></td>
@endif
@endif
</tr>
@endforeach
</tbody>
</table>
</div>
</div>
<a> 
@if(isset(Auth::user()->login_name))
@if(Auth::user()->hasPermissionTo(126))
<input type="button" onclick="location.href='{{url('newuser')}}'" value="{{__('title.create_new_user')}}" ></input></a>   
@endif
@endif
</body> 
<script>
  function edituser(user_id){
    console.log(user_id);
    window.location = "{{url('edituser/')}}"+'/'+user_id;
}
</script>    
</html>  