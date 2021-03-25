<!DOCTYPE html>   
<html>   
<head>    
<title> LabTech Software (Rank Price Lists) </title>  
<style>   
Body {  
  font-family:serif;  
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
@if(isset(Auth::user()->login_name))
  @else
  <script>window.location = "{{url('/')}}";</script>
  @endif

@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(137))
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
    
    <center> <h1 > {{__('title.rankpricelists_all')}} </h1> </center> 
    @if(isset(Auth::user()->login_name))   
    @if(Auth::user()->hasPermissionTo(143))  
    <input type="button" onclick="location.href='{{url('newrankpricelist')}}'" value="{{__('title.create_new_rankpricelist')}}" ></input></td>
    @endif
    @endif

<div id="table-wrapper">
<div id="table-scroll">
<table id="myTable">
<thead>
<tr>
<th> Rank ID </th>
<th> {{__('title.rankpricelist')}} </th>
</tr>
</thead>
<tbody>
@foreach ($users as $user)
<tr>
<td>{{ $user->rank_pricelist_id }}</td>
<td>{{ $user->rank_pricelist_name }}</td>
<td><input type="button" onclick="relatives({{$user->rank_pricelist_id}})"   value="{{__('title.relativepricelists_rankpricelist')}}" ></input></td>
@if(!$user->deleted_at)
@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(144))
<td><input type="button" onclick="editrank({{$user->rank_pricelist_id}})" value="{{__('title.edit_antibiotic_btn')}}" ></input></td>
@endif
@endif
@endif


@if(!$user->deleted_at)
@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(145))
<td><input type="button" onclick="deleterank({{$user->rank_pricelist_id}})" value="{{__('title.delete_antibiotic_btn')}}" ></input></td>
@endif
@endif
@else
@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(145))
<td><input type="button" onclick="restorerank({{$user->rank_pricelist_id}})" value="{{__('title.restore_antibiotic_btn')}}" ></input></td>
@endif
@endif
@endif
</tr>
@endforeach
</tbody>
</table>
</div>
</div>

<div> 
@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(145)) 
<td><input type="button" onclick="location.href='{{url('trashedrankpricelists')}}'" value="{{__('title.trashed_rankpricelists')}}" ></input></td>
@endif
@endif
</body>  

<script>
  function editrank(rank_pricelist_id){
    console.log(rank_pricelist_id);
    window.location = "{{url('editrankpricelist/')}}"+'/'+rank_pricelist_id;
}

function relatives(rank_pricelist_id){
    console.log(rank_pricelist_id);
    window.location = "{{url('relativepricelists/')}}"+'/'+rank_pricelist_id;
}

function deleterank(rank_pricelist_id){
  console.log(rank_pricelist_id);
  var deleteantibiotic = confirm("Want to delete "+rank_pricelist_id +"?");
  if (deleteantibiotic){
    window.location = "{{url('deleterankpricelist/')}}"+'/'+rank_pricelist_id;
  }
}
function restorerank(rank_pricelist_id){
  var restorerank = confirm("Want to restore "+rank_pricelist_id +"?");
  if (restorerank){
    window.location = "{{url('restorerankpricelist/')}}"+'/'+rank_pricelist_id;
  }
  
}
  </script>
</html>  