<!DOCTYPE html>   
<html>   
<head>    
<title> LabTech Software (Profiles) </title>  
<style>   
Body {  
  font-family: serif;  
  background-color: lightgrey;  
}  

 form {   
        border: 1px solid #f1f1f1;   
    }   
 input[type=text] {   
        font-family: serif;     
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
    font:normal 11px/22px  Serif;
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
    
        
     
 .container {   
        padding: 5px;  
        margin: 8px 0;  
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
  width:40%;

}
#table-wrapper table * {
  background:white;
  color:black;
  font-size: 13px;
  /* font-weight:bold; */
}
#table-wrapper table  th {
  top:0;
  position: sticky;
}
</style>   
@if(isset(Auth::user()->login_name))
  @else
  <script>window.location = "{{url('/')}}";</script>
  @endif

@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(64))
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
    
    <center> <h1 > {{__('title.profiles_all')}} </h1> </center>   

<div id="table-wrapper">
<div id="table-scroll">
<table id="myTable">
<thead>
  <tr>
<th> Profile ID </th>
<th> {{__('title.profile_name')}} </th>
<th> {{__('title.active_profile')}}</th>
</tr>
</thead>
<tbody>
@foreach ($users as $user)
<tr>
<td>{{ $user->profile_id }}</td>
<td>{{ $user->profile_name }}</td>
<td><input type="checkbox" {{ $user->active==1 ? "checked":"" }} disabled ></td>
@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(65))
<td><input type="button" onclick="editprofile({{$user->profile_id}})" value="{{__('title.edit_btn')}}" ></input></td>
@endif
@endif
<td><input type="button" onclick="profiletests({{$user->profile_id}})" value="{{__('title.profile_tests_profiles')}}" ></input></td>


</tr>
@endforeach
</tbody>
</table>
</div>
</div>

<a>
@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(129))
<input type="button" onclick="location.href='{{url('newprofile')}}'" value="{{__('title.create_new_profile')}}" ></input></a>
@endif
@endif
</body> 

<script>
  function editprofile(profile_id){
    console.log(profile_id);
    window.location = "{{url('editprofile/')}}"+'/'+profile_id;
}
  function profiletests(profile_id){
    console.log(profile_id);
    window.location = "{{url('profiletests/')}}"+'/'+profile_id;
}
</script>
</html>  