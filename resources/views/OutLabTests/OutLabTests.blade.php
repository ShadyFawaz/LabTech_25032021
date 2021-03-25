<!DOCTPE html>
<html>
<head>
<title>LabTech Software (Out Lab Tests)</title>
<style>   
Body {  
  font-family:  serif;  
  background-color: lightgrey;  
}  
  
 form {   
        /* border: 1px solid #f1f1f1;    */
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
        font-family:  serif;     
        width: auto;   
        margin: 0px 0px;  
        padding: 3px 2px;   
        display: inline-block;   
        border: 2px black;   
        box-sizing: border-box;   
        text-align: left;
        line-height:15px;
    }
    /* input[type=number]::-webkit-inner-spin-button, */
    input[type=number]  {   
        font-family: serif;     
        width: auto;   
        margin: 0;  
        padding: 3px 2px;   
        display: inline-block;   
        border: 2px black;   
        box-sizing: border-box;   
        text-align: left;
       font-weight: bold;
  -webkit-appearance: none;

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
        width: 7%;   
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
  line-height:10px;

}
#table-scroll {
  height:390px;
  overflow:auto;  
  margin-top:20px;
}
#table-wrapper table {
  width:50% !important;
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
  width: 50%;
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
@if(Auth::user()->hasPermissionTo(67))
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
<center> <h1  > {{__('title.outlabtests/outlab')}} </h1> </center>  
@if( isset($users) && count($users) > 0 && isset($users[0]) && $users[0] )
<center> <b >  {{$users[0]->OutLabs->out_lab}} </b> </center> 
@endif
@if( isset($users) && count($users) > 0 && isset($users[0]) && $users[0] )
<form action = "{{url('updateoutlab/'.($outlab_id))}}" method = "post">
@endif
    {{ method_field('post') }}
    {{ csrf_field() }}
    
<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for tests.." title="Type in a name">
<input type="submit" id="submit" name="savePrices" value="{{__('title.save_btn')}}" >  

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
<th>{{__('title.outlab_test')}}</th>
<th>{{__('title.price_priceliststests')}}</th>
<th>{{__('title.duration_outlab_test')}}</th>

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

@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(152))
<td><input  type="number" step="1" min="0"   name="price[{{$user->testprice_id}}]" value="{{ $user->price }}"></td>
@else
<td><input readonly="readonly" type="number" step="1" min="0"   name="price[{{$user->testprice_id}}]" value="{{ $user->price }}"></td>
@endif
@endif

<td><input  type="number" step="1" min="1"   name="duration[{{$user->testprice_id}}]" value="{{ $user->duration }}"></td>


@if ($user->megatest_id)
<td><input type="button" onclick="deletemegatest({{$user->testprice_id}})" value="{{__('title.delete_btn')}}" ></input></td>
@endif
@if ($user->grouptest_id)
<td><input type="button" onclick="deletegrouptest({{$user->testprice_id}})" value="{{__('title.delete_btn')}}" ></input></td>
@endif
@if ($user->test_id)
<td><input type="button" onclick="deletetest({{$user->testprice_id}})" value="{{__('title.delete_btn')}}" ></input></td>
@endif
</tr>
@endforeach
</tbody>
</table>
</div>
</div>
<td><input type="button" onclick="newoutlabtest({{$outlab_id}})" value="{{__('title.create_new_outlab_test')}}" ></input></td>
</body>
</form>
<script>
function newoutlabtest(outlab_id){
    console.log(outlab_id);
    window.location = "{{url('newoutlabtests/')}}"+'/'+outlab_id;
}
function deletemegatest(testprice_id){
  console.log(testprice_id);
  var deletemegatest = confirm("Want to delete ?");
  if (deletemegatest){
    window.location = "{{url('deleteoutlabtest/')}}"+'/'+testprice_id;
  }
}
function deletegrouptest(testprice_id){
  console.log(testprice_id);
  var deletegrouptest = confirm("Want to delete ?");
  if (deletegrouptest){
    window.location = "{{url('deleteoutlabtest/')}}"+'/'+testprice_id;
  }
}
function deletetest(testprice_id){
  console.log(testprice_id);
  var deletetest = confirm("Want to delete ?");
  if (deletetest){
    window.location = "{{url('deleteoutlabtest/')}}"+'/'+testprice_id;
  }
}
</script>
</html>