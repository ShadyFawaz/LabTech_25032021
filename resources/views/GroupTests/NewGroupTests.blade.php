<!DOCTYPE html>   
<html>   
<head>  
<meta name="viewport" content="width=device-width, initial-scale=1">  
<title> LabTech Software (New Group Test) </title>  
<style>   
Body {  
  font-family:  serif;  
  background-color: lightgrey;  
}  
          
  
 input[type=text] {   
        font-family: serif;     
        width: 30%;   
        margin: 3px 0px;  
        padding: 3px 0px;   
        display: inline-block;   
        border: 2px black;   
        box-sizing: border-box;   
        text-align: left;
    }  

    label {   
        font-family:  serif;  
        width: 10%;   
        margin: 0px 0;  
        padding: 0px 0px;  
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
  height:280px;
  overflow:auto;  
  margin-top:20px;
}
#table-wrapper table {
  width:60%;

}
#table-wrapper table * {
  background:white;
  color:black;
  font-size: 13px;
  /* font-weight:bold; */
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
@if(Auth::user()->hasPermissionTo(115))
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
<form name="NewGroupTest"  onsubmit="return validateForm()"  action = "{{url('newgrouptestscreate')}}" method = "post">
    {{ method_field('post') }}
    {{ csrf_field() }}
	   
    <center> <h1> {{__('title.create_new_grouptest')}} </h1> </center>     
        <div>   
        <b><label style="color:red">{{__('title.grouptest_name')}} </label>   </b>
            <input type="text"  name="test_name" required> 
            </div>
            <div >
            <b><label>{{__('title.active_grouptest')}} </label></b>   
            <input type="checkbox"  name="active"  value="1"> 
            </div>
            <div >
            <b><label>{{__('title.outlab_grouptest')}}</label>  </b> 
            <input type="checkbox"  name="outlab"value="1" >

            <b><label>{{__('title.outlabid_grouptest')}}  </label> </b>  
            <select name="outlab_id">
            <option value="" ></option>
                @foreach($OutLabs as $outlab)
                <option value="{{$outlab->outlab_id}}" >{{$outlab->out_lab}}</option>
                @endforeach
            </select> 

            </div>
            

            
            <center><label style="color:red;">{{__('title.tests_grouptests')}}  </label></center> 

<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for Tests.." title="Type in a name">

<button type="submit" >{{__('title.save_btn')}}</button>      

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
<th> Test name</th>
<th>Select</th>
</tr>
</thead>
</tbody>
<tr>
@foreach ($TestData as $test)
<td > {{ $test->abbrev }}</td>
<td><input  id="test_id-{{$test->test_id}}"  type="checkbox" name="test_id[{{$test->test_id}}]" onchange='settestid({{$test->test_id}})' value="{{ $test->test_id }}"></td>
<td><input class="testids" hidden  id="test-id-{{$test->test_id}}" name="id[{{$test->test_id}}]" value="0" type="number" >

</td>
</tr>
@endforeach
</tbody>
</table>
</div>
</div>
          
            <script src="{{asset('JS/jquery-3.5.1.min.js')}}" ></script> 

<script>
function settestid(test_id) {
  console.log(test_id);
  var testid  = document.getElementById("test_id-"+test_id).checked; 
  var testidinput = $('#test-id-'+test_id); 
  
  console.log(testid);

  if (document.getElementById("test_id-"+test_id).checked) {
            testidinput.val('1');
        } else {
            testidinput.val('0');
        }
}
</script>
<script>
function validateForm() {
    var testids = 0;
$('.testids').each(function(i,testid){
  console.log(testid);
  testids = testids + parseInt($(testid).val());
});
console.log(testids);

 if ( testids == 0) {
alert("{{__('title.no_tests_selected')}}");
return false;
 }
  }
</script>    
<div>
            <button type="submit" class="NewRole"> <b>{{__('title.save_btn')}}</button> 
            <button type="button" class="cancelbtn"> <b>{{__('title.cancel_btn')}}</button>

    </form>     
</body>     
</html>  