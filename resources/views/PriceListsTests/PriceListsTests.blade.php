<!DOCTPE html>
<html>
<head>
<title>LabTech Software (Price List Tests)</title>
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
<center> <h1  s>  {{__('title.priceliststests_all')}} </h1> </center>  
@if( isset($users) && count($users) > 0 && isset($users[0]) && $users[0] )
<center> <b>  {{ $users[0]->PriceLists->price_list }} </b> </center>   
@endif
@if( isset($users) && count($users) > 0 && isset($users[0]) && $users[0] )
<form action = "{{url('updatepricelist/'.($users[0]->pricelist_id))}}" method = "post">
@endif
<td><input type="button" onclick="location.href='{{url('newpricelisttests/'.($pricelist_id))}}'" value="Add Tests To PriceList" ></input></td>
<div>
</div>
    {{ method_field('post') }}
    {{ csrf_field() }}


<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for tests.." title="Type in a name">
<!-- <td><input type="submit" id="submit" value="{{__('title.save_btn')}}"></input></td> -->
<input type="submit" id="submit" name="savePrices" value="{{__('title.save_btn')}}" >  
<td><input type="button" onclick="printpricelist()" value="{{__('title.print_pricelist')}}" ></input></td>

@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(149))
<label style="color:orange;">{{__('title.update_ratio')}} </label>
<input id="update_ratio"  name="update_percent" style="width:5%;" type="number" step="0.01" min="0.00" ></input>

<input type="submit" id="submit" onclick="updatepricelist()" name="updatePrices" value="{{__('title.update_pricelist_prices')}}" > 
@endif
@endif
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
<th>{{__('title.test_name_priceliststests')}}</th>
<th>{{__('title.price_priceliststests')}}</th>
</tr>
  </thead>
  <tbody>
@foreach ($users as $user)
<tr>
@if($user->megatest_id)
<td>{{ $user->megaTests->test_name }}</td>
@endif
@if($user->grouptest_id)
<td>{{ $user->GroupTests->test_name }}</td>
@endif
@if($user->test_id)
<td>{{ $user->TestData->abbrev }}</td>
@endif
@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(149))
<td><input  type="number" step="1" min="0"   name="price[{{$user->testprice_id}}]" value="{{ $user->price }}"></td>
@else
<td><input readonly="readonly" type="number" step="1" min="0"   name="price[{{$user->testprice_id}}]" value="{{ $user->price }}"></td>
@endif
@endif

</tr>
@endforeach
</tbody>
</table>
</div>
</div>
<script src="{{asset('JS/jquery-3.5.1.min.js')}}" ></script> 

<!-- <a href="{{url('newpriceliststests')}}">{{__('title.create_new_pricelisttest')}}</a>   -->
</body>
<script>
  var unsaved = false;
  $('#submit').click(function() {
    unsaved = false;
});

$(":input").change(function(){ //triggers change in all input fields including text type
    unsaved = true;
});

function unloadPage(){ 
    if(unsaved){
        return "You have unsaved changes on this page?";
    }
}
window.onbeforeunload = unloadPage;

function printpricelist(){
  var page     = "{{url('printpricelist',$pricelist_id)}}";
  var myWindow = window.open(page, "_blank", "scrollbars=yes,width=800,height=800,top=300");
         // focus on the popup //
         myWindow.focus();
}

  

  </script>
</html>