<!DOCTPE html>
<html>
<head>
<title>LabTech Software (Profile Tests)</title>
<style>   
Body {  
  font-family: serif;  
  background-color: lightgrey;  
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
    width: 25%;  
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
        font-family:  serif;  
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
        padding: 0px;  
        margin: 0px 0;  
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
<center> <h1  > {{__('title.profiletests/profile')}} </h1> </center>  
@if( isset($users) && count($users) > 0 && isset($users[0]) && $users[0] )
<center> <b >  {{$users[0]->Profiles->profile_name}} </b> </center> 
@endif
@if( isset($users) && count($users) > 0 && isset($users[0]) && $users[0] )
<form action = "{{url('/profiletests/'.$users[0]->profile_id)}}" method = "get">
@endif
    {{ method_field('post') }}
    {{ csrf_field() }}
    
<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for tests.." title="Type in a name">

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
<th> Test ID</th>
<th>{{__('title.profile_test')}}</th>

</tr>
</thead>
<tbody>
@foreach ($users as $user)
<tr>
@if ($user->megatest_id)
<td>{{ $user->megatest_id }}</td>
<td>{{ $user->megatests->test_name }}</td>
@endif

@if ($user->grouptest_id)
<td>{{ $user->grouptest_id }}</td>
<td>{{ $user->GroupTests->test_name }}</td>
@endif

@if ($user->test_id)
<td>{{ $user->test_id }}</td>
<td>{{ $user->TestData->abbrev }}</td>
@endif


@if ($user->megatest_id)
<td><input type="button" onclick="deletemegatest({{$user->profiletest_id}})" value="{{__('title.delete_btn')}}" ></input></td>
@endif
@if ($user->grouptest_id)
<td><input type="button" onclick="deletegrouptest({{$user->profiletest_id}})" value="{{__('title.delete_btn')}}" ></input></td>
@endif
@if ($user->test_id)
<td><input type="button" onclick="deletetest({{$user->profiletest_id}})" value="{{__('title.delete_btn')}}" ></input></td>
@endif
</tr>
@endforeach
</tbody>
</table>
</div>
</div>
<td><input type="button" onclick="newprofiletest({{$profile_id}})" value="{{__('title.create_new_profile_test')}}" ></input></td>
</body>
</form>
<script>
function newprofiletest(profile_id){
    console.log(profile_id);
    window.location = "{{url('newprofiletest/')}}"+'/'+profile_id;
}
function deletemegatest(profiletest_id){
  console.log(profiletest_id);
  var deletemegatest = confirm("Want to delete ?");
  if (deletemegatest){
    window.location = "{{url('deleteprofiletest/')}}"+'/'+profiletest_id;
  }
}
function deletegrouptest(profiletest_id){
  console.log(profiletest_id);
  var deletegrouptest = confirm("Want to delete ?");
  if (deletegrouptest){
    window.location = "{{url('deleteprofiletest/')}}"+'/'+profiletest_id;
  }
}
function deletetest(profiletest_id){
  console.log(profiletest_id);
  var deletetest = confirm("Want to delete ?");
  if (deletetest){
    window.location = "{{url('deleteprofiletest/')}}"+'/'+profiletest_id;
  }
}
</script>
</html>