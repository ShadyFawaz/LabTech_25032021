<!DOCTYPE html>   
<html>   
<head>    
<title> LabTech Software (Country)</title>  
<style>   
Body {  
  font-family: serif;  
  background-color: lightgrey;  
}  

 form {   
    }   
 input[type=text] {   
        font-family: serif;     
        width: 50%;   
        margin: 3px 0px;  
        padding: 8px 2px;   
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
    
        
     
 .container {   
        padding: 0px;  
        margin: 0px 0;  
        background-color: #B9CDE5;  
    }   

    #table-wrapper  {
  position:relative !important;
}
#table-scroll {
  height:390px !important;
  overflow:auto !important;  
  margin-top:20px !important;
}
#table-wrapper table {
  width:50% !important;

}
#table-wrapper table * {
  background:white !important;
  color:black !important;
}
#table-wrapper table thead th .text {
  position:absolute !important;   
  top:-20px !important;
  z-index:2 !important;
  height:20px !important;
  width:35% !important;
  border:1px solid red !important;
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
@if(Auth::user()->hasPermissionTo(104))
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


    
    <center> <h1> {{__('title.country_all')}} </h1> </center>  

    <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for Country.." title="Type in a name">


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
<th><b> Country ID </b></th>
<th><b> {{__('title.country_name')}} </b></th>
</tr>
</thead>
<tbody>
@foreach ($users as $user)
<tr>
<td>{{ $user->country_id }}</td>
<td>{{ $user->country }}</td>
@if(!$user->deleted_at)
@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(106))
<td><input type="button" onclick="editcountry({{$user->country_id}})" value="{{__('title.edit_antibiotic_btn')}}" ></input></td>
@endif
@endif
@endif


@if(!$user->deleted_at)
@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(133))
<td><input type="button" onclick="deletecountry({{$user->country_id}})" value="{{__('title.delete_antibiotic_btn')}}" ></input></td>
@endif
@endif
@else
@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(133))
<td><input type="button" onclick="restorecountry({{$user->country_id}})" value="{{__('title.restore_antibiotic_btn')}}" ></input></td>
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
@if(Auth::user()->hasPermissionTo(105))
<input type="button" onclick="location.href='{{url('newcountry')}}'" value="{{__('title.create_new_country')}}" ></input></a>
@endif
@endif
<div>  
<a>
@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(133))
<input type="button" onclick="location.href='{{url('trashedcountry')}}'" value="{{__('title.trashed_country')}}" ></input></a>
@endif
@endif
</body>
<script>
  function editcountry(country_id){
    console.log(country_id);
    window.location = "{{url('editcountry/')}}"+'/'+country_id;
}
function deletecountry(country_id){
  console.log(country_id);
  var deletecountry = confirm("Want to delete ?");
  if (deletecountry){
    window.location = "{{url('deletecountry/')}}"+'/'+country_id;
  }
}
function restorecountry(country_id){
  var restorecountry = confirm("Want to restore ?");
  if (restorecountry){
    window.location = "{{url('restorecountry/')}}"+'/'+country_id;
  }
}
  </script>

</html>  