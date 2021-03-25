<!DOCTYPE html>   
<html>   
<head>  
<meta name="viewport" content="width=device-width, initial-scale=1">  
<title> LabTech Software (Antibiotics) </title>  
<style>   
Body {  
  font-family:  sans-serif;  
  background-color: lightgrey;  
}  
  
 form {   
        border: 1px solid #f1f1f1;   
    }   
 input[type=text] {   
        font-family:  sans-serif;     
        width: 30%;   
        margin: 3px 0px;  
        padding: 8px 5px;   
        display: inline-block;   
        border: 2px black;   
        box-sizing: border-box;   
        text-align: left;
    }  

    label {   
        font-family:  sans-serif;  
        width: 10%;   
        margin: 0px 0;  
        padding: 5px 0px;  
        display: inline-block;   
        border: 2px black;   
        box-sizing: border-box; 
        text-align: left; 
    }  
 button:hover {   
        opacity: 0.8;   
    }   
    
        
     
 .container {   
        padding: 0px;   
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
@if(Auth::user()->hasPermissionTo(38))
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
<center> <h1> {{__('title.antibiotics_all')}} </h1> </center>   
<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for antibiotics.." title="Type in a name">


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
<th><b> Antibiotic ID </b></th>
<th><b> {{__('title.antibiotic_shortcut')}} </b></th>
<th><b> {{__('title.report_name')}} </b></th>
</tr>
</thead>
<tbody>
@foreach ($users as $user)
<tr>
<td >{{ $user->antibiotic_id }}</td>
<td >{{ $user->antibiotic_name }}</td>
<td>{{ $user->report_name }}</td>

@if(!$user->deleted_at)
@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(46))
<td><input type="button" onclick="editantibiotic({{$user->antibiotic_id}})" value="{{__('title.edit_antibiotic_btn')}}" ></input></td>
@endif
@endif
@endif


@if(!$user->deleted_at)
@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(47))
<td><input type="button" onclick="deleteantibiotic({{$user->antibiotic_id}})" value="{{__('title.delete_antibiotic_btn')}}" ></input></td>
@endif
@endif
@else
@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(47))
<td><input type="button" onclick="restoreantibiotic({{$user->antibiotic_id}})" value="{{__('title.restore_antibiotic_btn')}}" ></input></td>
@endif
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
@if(Auth::user()->hasPermissionTo(114))
<input type="button" onclick="location.href='{{url('newantibiotic')}}'" value="{{__('title.create_new_antibiotic')}}" ></input></a>
@endif
@endif
<div>
 
<a>
@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(47)) 
<input type="button" onclick="location.href='{{url('trashedantibiotics')}}'" value="{{__('title.trashed_antibiotics')}}" ></input></a>
@endif
@endif
</body> 

  <script>
  function editantibiotic(antibiotic_id){
    console.log(antibiotic_id);
    window.location = "{{url('editantibiotic/')}}"+'/'+antibiotic_id;
}
function deleteantibiotic(antibiotic_id){
  console.log(antibiotic_id);
  var deleteantibiotic = confirm("Want to delete ?");
  if (deleteantibiotic){
    window.location = "{{url('deleteantibiotic/')}}"+'/'+antibiotic_id;
  }
}
function restoreantibiotic(antibiotic_id){
  var restoreantibiotic = confirm("Want to restore ?");
  if (restoreantibiotic){
    window.location = "{{url('restoreantibiotic/')}}"+'/'+antibiotic_id;
  }
}
  </script>

</html>  