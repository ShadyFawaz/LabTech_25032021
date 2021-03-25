<!DOCTPE html>
<html>
<head>
<title>LabTech Software (Price Lists)</title>
<style>   
Body {  
  font-family:  serif;  
  background-color: lightgrey;  
}  
 
 form {   
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
    input[type=button] {   
    color:black
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
  width:50%;
  font-size:12px;
  font-weight:bold;
  /* margin:auto; */
  line-height:24px;
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
@if(Auth::user()->hasPermissionTo(136))
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
<center> <h1  > Price Lists </h1> </center>   
<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for pricelist.." title="Type in a name">

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
<div id="table-wrapper">
<div id="table-scroll">
<table id="myTable">
  <thead>
      <tr>
<th>{{__('title.pricelist_name')}}</th>
</tr>
</thead>
<tbody>
@foreach ($users as $user)
<tr>
<td ondblclick="location.href='{{url('priceliststests/'.( $user->pricelist_id ))}}'">{{ $user->price_list }}</td>
<td><input type="button" onclick="pricelisttests({{$user->pricelist_id}})" value="{{__('title.pricelisttests_btn')}}" ></input></td>
@if(!$user->deleted_at)
@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(141))
<td><input type="button" onclick="editpricelist({{$user->pricelist_id}})" value="{{__('title.edit_antibiotic_btn')}}" ></input></td>
@endif
@endif
@endif


@if(!$user->deleted_at)
@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(142))
<td><input type="button" onclick="deletepricelist({{$user->pricelist_id}})" value="{{__('title.delete_antibiotic_btn')}}" ></input></td>
@endif
@endif
@else
@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(142))
<td><input type="button" onclick="restorepricelist({{$user->pricelist_id}})" value="{{__('title.restore_antibiotic_btn')}}" ></input></td>
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
@if(Auth::user()->hasPermissionTo(140))
<input type="button" onclick="location.href='{{url('newpricelists')}}'" value="{{__('title.create_new_pricelist')}}" ></input></a>
@endif
@endif
<div>
<a>
@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(142))
<input type="button" onclick="location.href='{{url('trashedpricelists')}}'" value="{{__('title.trashed_pricelist')}}" ></input></a>
@endif
@endif
</div>
</body>

<script>
  function editpricelist(pricelist_id){
    console.log(pricelist_id);
    window.location = "{{url('editpricelists/')}}"+'/'+pricelist_id;
}
  function pricelisttests(pricelist_id){
    console.log(pricelist_id);
    window.location = "{{url('priceliststests/')}}"+'/'+pricelist_id;
}

function deletepricelist(pricelist_id){
  console.log(pricelist_id);
  var deletepricelist = confirm("Want to delete ?");
  if (deletepricelist){
    window.location = "{{url('deletepricelists/')}}"+'/'+pricelist_id;
  }
}
function restorepricelist(pricelist_id){
  var restorepricelist = confirm("Want to restore ?");
  if (restorepricelist){
    window.location = "{{url('restorepricelists/')}}"+'/'+pricelist_id;
  }
}
</script>  
</html>