<!DOCTYPE html>   
<html>   
<head>    
<title> LabTech Software (Groups) </title>  
<style>   
Body {  
  font-family:serif;  
  background-color: lightgrey;  
}  

 form {   
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
  width:70%;

}
#table-wrapper table * {
  background:white;
  color:black;
}
#table-wrapper table thead th .text {
  position:absolute;   
  top:-20px;
  z-index:2;
  height:20px;
  width:35%;
  border:1px solid red;
}
#table-wrapper table  th {
  top:0;
  position: sticky;
}
#myInput {
  width: 30%;
  font-size: 14px;
  padding: 10px 15px 10px 20px;
  border: 1px solid #ddd;
  margin-bottom: 10px;
}
</style>   
@if(isset(Auth::user()->login_name))
  @else
  <script>window.location = "{{url('/')}}";</script>
  @endif

@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(89))
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
    
    <center> <h1 > {{__('title.groups_all')}} </h1> </center>   
    <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for groups.." title="Type in a name">


<script>
function myFunction() {
var input, filter, table, tr, td, i, txtValue;
input = document.getElementById("myInput");
filter = input.value.toUpperCase();
table = document.getElementById("myTable");
tr = table.getElementsByTagName("tr");
for (i = 0; i < tr.length; i++) {
td = tr[i].getElementsByTagName("td")[1];
if (td) {
  txtValue = td.textContent || td.innerText;
  if (txtValue.toUpperCase().indexOf(filter) > -1) {
    tr[i].style.display = "";
  } else {
    tr[i].style.display = "none";
  }
}       
}
}

</script>

<div id="table-wrapper">
<div id="table-scroll">
<table id="myTable">
    <thead>
        <tr>
<th> Group ID </th>
<th> {{__('title.group')}} </th>
<th> {{__('title.report_name_group')}}</th>
</tr>
</thead>
<tbody>
@foreach ($users as $user)
<tr>
<td>{{ $user->group_id }}</td>
<td>{{ $user->group_name }}</td>
<td>{{ $user->report_name }}</td>
@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(91))
<td><input type="button" onclick="editgroup({{$user->group_id}})" value="{{__('title.edit_btn')}}" ></input></td>
@endif
@endif
<td><input type="button" onclick="grouptests({{$user->group_id}})" value="{{__('title.group_tests_btn')}}" ></input></td>
</tr>
@endforeach
</tbody>
</table>
</div>
</div>  
<a>
@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(90))
<input type="button" onclick="location.href='{{url('newgroups')}}'" value="{{__('title.create_new_group')}}" ></input></a>
  @endif
  @endif
<script>
  function editgroup(group_id){
    console.log(group_id);
    window.location = "{{url('editgroups/')}}"+'/'+group_id;
}
  function grouptests(group_id){
    console.log(group_id);
    window.location = "{{url('grouptests/')}}"+'/'+group_id;
}
</script>
</html>  