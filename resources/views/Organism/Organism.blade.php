<!DOCTYPE html>   
<html>   
<head>    
<title> LabTech Software (Organisms) </title>  
<style>   
Body {  
  font-family: serif;  
  background-color: lightgrey;  
}  

    
 input[type=text] {   
        font-family:  serif;     
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
@if(Auth::user()->hasPermissionTo(48))
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
    
    <center> <h1> {{__('title.organisms_all')}}</h1> </center>   
    <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for organisms.." title="Type in a name">


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
<th><b> Organism ID </b></th>
<th><b> {{__('title.organism')}} </b></th>
</tr>
  </thead>
  <tbody>
@foreach ($users as $user)
<tr>
<td>{{ $user->organism_id }}</td>
<td>{{ $user->organism }}</td>

@if(!$user->deleted_at)
@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(50))
<td><input type="button" onclick="editorganism({{$user->organism_id}})" value="{{__('title.edit_antibiotic_btn')}}" ></input></td>
@endif
@endif
@endif


@if(!$user->deleted_at)
@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(51))
<td><input type="button" onclick="deleteorganism({{$user->organism_id}})" value="{{__('title.delete_antibiotic_btn')}}" ></input></td>
@endif
@endif
@else
@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(51))
<td><input type="button" onclick="restoreorganism({{$user->organism_id}})" value="{{__('title.restore_antibiotic_btn')}}" ></input></td>
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
@if(Auth::user()->hasPermissionTo(49))
<input type="button" onclick="location.href='{{url('neworganism')}}'" value="{{__('title.create_new_organism')}}" ></input></a>
@endif
@endif
<div>  
<a>
@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(51))
<input type="button" onclick="location.href='{{url('trashedorganism')}}'" value="{{__('title.trashed_organism')}}" ></input></a>
@endif
@endif
</body> 
<script>
  function editorganism(organism_id){
    console.log(organism_id);
    window.location = "{{url('editorganism/')}}"+'/'+organism_id;
}
function deleteorganism(organism_id){
  console.log(organism_id);
  var deleteorganism = confirm("Want to delete ?");
  if (deleteorganism){
    window.location = "{{url('deleteorganism/')}}"+'/'+organism_id;
  }
}
function restoreorganism(organism_id){
  var restoreorganism = confirm("Want to restore ?");
  if (restoreorganism){
    window.location = "{{url('restoreorganism/')}}"+'/'+organism_id;
  }
}
  </script>    
</html>  