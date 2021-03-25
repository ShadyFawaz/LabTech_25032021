<!DOCTYPE html>   
<html>   
<head>  
<meta name="viewport" content="width=device-width, initial-scale=1">  
<title> LabTech Software (Mega Tests) </title>  
<style>   
Body {  
  font-family:  serif;  
  background-color: lightgrey;  
}  
  

 input[type=text] {   
        font-family:  serif;     
        width: 30%;   
        margin: 3px 0px;  
        padding: 8px 5px;   
        display: inline-block;   
        border: 2px black;   
        box-sizing: border-box;   
        text-align: left;
    }  

    label {   
        font-family: serif;  
        width: 10%;   
        margin: 0px 0;  
        padding: 5px 0px;  
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
    }   
    #table-wrapper {
  position:relative;
}
#table-scroll {
  height:350px;
  overflow:auto;  
  margin-top:20px;
}
#table-wrapper table {
  width:70%;

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

/* #myTable tr.header, #myTable tr:hover {
  background-color: #f1f1f1;
  font-family: times_new_roman, Helvetica, sans-serif; 
  margin-bottom: 10px; 
} */
</style>   
@if(isset(Auth::user()->login_name))
  @else
  <script>window.location = "{{url('/')}}";</script>
  @endif

@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(62))
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
    
    <center> <h1 > {{__('title.megatests_all')}} </h1> </center>   

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
<th><b> Mega Test ID </b></th>
<th><b> {{__('title.megatest_name')}}</b></th>
<th><b> {{__('title.report_name_megatest')}} </b></th>
<th><b> {{__('title.report_type_megatest')}} </b></th>
<th><b> {{__('title.active_megatest')}} </b></th>
<th><b> {{__('title.outlab_megatest')}} </b></th>
<th><b> {{__('title.outlabid_megatest')}} </b></th>

</tr>
</thead>
<tbody>
@foreach ($users as $user)
<tr>
<td>{{ $user->megatest_id }}</td>
<td ondblclick="megatestchilds({{$user->megatest_id}})">{{ $user->test_name }}</td>
<td>{{ $user->report_name }}</td>
<td>{{ $user->report_type }}</td>
<td><input type="checkbox" {{ $user->active==1 ? "checked":"" }} disabled ></td>
<td><input type="checkbox" {{ $user->outlab==1 ? "checked":"" }} disabled ></td>
<td>{{ $user->outlab_id? $user->OutLabs->out_lab:"" }}</td>

@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(63))
<td><input type="button" onclick="editmegatest({{$user->megatest_id}})" value="{{__('title.edit_btn')}}" ></input></td>
@endif
@endif
<td><input type="button" onclick="megatestchilds({{$user->megatest_id}})" value="{{__('title.megatestschild_btn')}}" ></input></td>

</tr>
@endforeach
</tbody>
</table>
</div>
</div> 
<a>
@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(116))
<input type="button" onclick="location.href='{{url('newmegatests')}}'" value="{{__('title.create_new_megatest')}}" ></input></a>
@endif
@endif
</body>  
<script>
  function editmegatest(megatest_id){
    console.log(megatest_id);
    window.location = "{{url('editmegatests/')}}"+'/'+megatest_id;
}
  function megatestchilds(megatest_id){
    console.log(megatest_id);
    window.location = "{{url('megatestschild/')}}"+'/'+megatest_id;
}
</script> 

</html>  