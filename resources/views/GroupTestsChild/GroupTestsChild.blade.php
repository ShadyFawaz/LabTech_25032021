<!DOCTPE html>
<html>
<head>
<title>LabTech Software (GroupTest Parameters)</title>
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
    width: 100%;  
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
@if(Auth::user()->hasPermissionTo(60))
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
<center> <h1  >  {{__('title.grouptestschild_all')}} </h1> </center> 
<center> <b  >  {{$test_name}} </b> </center>   
<form action = "{{url('editgrouptestchilds/'.$grouptest_id)}}" method = "post">
    {{ method_field('post') }}
    {{ csrf_field() }}
    
<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for Parameters.." title="Type in a name">

<script>
function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
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
<input type="submit" value="Save All">

<div id="table-wrapper">
  <div id="table-scroll">
  <table id="myTable">
        <thead>
            <tr>
<th></th>
<th></th>
<th>{{__('title.grouptestchild_name')}}</th>
<th>{{__('title.grouptestchild_active')}}</th>

</tr>
</thead>
<tbody>
@foreach ($users as $user)
<tr>
<td><input type="hidden" name="test_id[{{$user->grouptest_code}}]" value="{{ $user->test_id }}"></td>
<td><input type="hidden" name="grouptest_id[{{$user->grouptest_code}}]" value="{{ $user->grouptest_id }}"></td>
<td>{{ $user->TestData->abbrev }}</td>
<td><input  type="checkbox"  name="active[{{$user->grouptest_code}}]" value="1"  {{ $user->active==1 ? "checked":"" }} ></td>

<td><input type="button" onclick="deletegrouptestchild({{$user->grouptest_code}})" value="{{__('title.delete_btn')}}" ></input></td>
<td><input type="button" onclick="normalgrouptestchild({{$user->test_id}})" value="{{__('title.normals_grouptestchild_btn')}}" ></input></td>
<td><input type="button" onclick="testdatagrouptestchild({{$user->test_id}})" value="{{__('title.grouptestchild_testdata_btn')}}" ></input></td>
</tr>
@endforeach
</tbody>
</table>
</div>
</div>  
<td><input type="button" onclick="newgrouptestchild({{$grouptest_id}})" value="{{__('title.create_new_grouptestchild')}}" ></input></td>
</body>

<script>
  function editgrouptestchild(grouptest_code){
    console.log(grouptest_code);
    window.location = "{{url('editgrouptestchild/')}}"+'/'+grouptest_code;
}
  function normalgrouptestchild(test_id){
    console.log(test_id);
    window.location = "{{url('normalsgrouptestchild/')}}"+'/'+test_id;
}
function testdatagrouptestchild(test_id){
    console.log(test_id);
    window.location = "{{url('grouptestchilddata/')}}"+'/'+test_id;
}
function newgrouptestchild(grouptest_id){
    console.log(grouptest_id);
    window.location = "{{url('newgrouptestschild/')}}"+'/'+grouptest_id;
}
function deletegrouptestchild(grouptest_code){
  console.log(grouptest_code);
  var deletegrouptestchild = confirm("Want to delete ?");
  if (deletegrouptestchild){
    window.location = "{{url('deletegrouptestchild/')}}"+'/'+grouptest_code;
  }
}
</script>  
</html>