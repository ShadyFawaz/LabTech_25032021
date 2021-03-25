<!DOCTPE html>
<html>
<head>
<title>LabTech Software (Relative Price Lists)</title>
<style>   
Body {  
  font-family:  serif;  
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
  font-weight:bold;
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
</head>
@include('MainMenu')
<body>
<center> <h1  > {{__('title.relativepricelists/rankpricelist')}} </h1> </center>  
@if( isset($users) && count($users) > 0 && isset($users[0]) && $users[0] )
<center> <b  >  {{ $users[0]->rankpricelists? $users[0]->RankPriceLists->rank_pricelist_name:"" }} </b> </center> 
@endif
<form action = "{{url('/relativepricelists/'.$rank_pricelist_id)}}" method = "get">
    {{ method_field('post') }}
    {{ csrf_field() }}
    
<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for relatives.." title="Type in a name">

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
@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(146))
<input type="button" onclick="location.href='{{url('newrelativepricelist'.'/'.$rank_pricelist_id)}}'" value="{{__('title.create_new_relativepricelist')}}" ></input>
@endif
@endif
<div id="table-wrapper">
<div id="table-scroll">
<table id="myTable">
<thead>
<tr>
<th>{{__('title.relativepricelist')}}</th>
<th>{{__('title.pricelist_relativepricelists')}}</th>
<th>{{__('title.insurance_factor_relativepricelist')}}</th>
<th>{{__('title.patient_load_relativepricelist')}}</th>
<th>{{__('title.insurance_load_relativepricelist')}}</th>
</tr>
</thead>
<tbody>
@foreach ($users as $user)
<tr>

<td>{{ $user->relative_pricelist_name }}</td>
<td>{{ $user->pricelists->price_list }}</td>
<td>{{ $user->insurance_factor }}</td>
<td>{{ $user->patient_load }}</td>
<td>{{ $user->insurance_load }}</td>

@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(147))
<td><input type="button" onclick="editrelative({{$user->relative_pricelist_id}})"    value="{{__('title.edit_btn')}}" ></input></td>
@endif
@endif
@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(148))
<td><input type="button" onclick="deleterelative({{$user->relative_pricelist_id}})"    value="{{__('title.delete_btn')}}" ></input></td>
@endif
@endif
</tr>
@endforeach
</tbody>
</table>
</div>
</div>


</body>
<script>
  function editrelative(relative_pricelist_id){
    console.log(relative_pricelist_id);
    window.location = "{{url('editrelativepricelist/')}}"+'/'+relative_pricelist_id;
}
function deleterelative(relative_pricelist_id){
    console.log(relative_pricelist_id);
    window.location = "{{url('deleterelativepricelist/')}}"+'/'+relative_pricelist_id;
}
</script>
</html>