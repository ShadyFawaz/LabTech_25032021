<!DOCTYPE html>   
<html>   
<head>  
<meta name="viewport" content="width=device-width, initial-scale=1">  
<title> LabTech Software (New Out Lab Test)</title>  
<style>   
Body {  
  font-family:  serif;  
  background-color: lightgrey;  
}  

          
 form {   
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
        font-family:  serif;  
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
<form role="form" name="NewOutLabTest"  onsubmit="return validateForm()" action = "{{url('newoutlabtestscreate/'.$outlab_id)}}" method = "post">
    {{ method_field('post') }}
    {{ csrf_field() }}
	    
    <center> <h1 > {{__('title.create_new_outlab_test')}} </h1> </center>   
        <div >   
        <b><label>{{__('title.outlab_outlab_test_new')}} </label>   </b>
            <input hidden readonly="readonly" type = 'integer' name = 'outlab_id'
                value = '{{$outlab_id}}'/>{{$out_lab}} </td>
            </div>
            <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for tests.." title="Type in a name">
<td><input type="submit" value="{{__('title.save_btn')}}"></input></td>

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
<th>Test Name</th>
<th>Select</th>
<th></th>

</tr>
</thead>
<tbody>
<tr>
@foreach ($MegaTests as $test)
<td ondblclick="dblselectmega({{$test->megatest_id}})"> {{ $test->test_name }}</td>
<td><input class="megatestids" id="megatest_id-{{$test->megatest_id}}" onchange='setmegaid({{$test->megatest_id}})' type="checkbox" name="megatest_id[{{$test->megatest_id}}]" value="{{ $test->megatest_id }}" ></td>
<td><input class="megachecks" hidden   id="megatestcheck-{{$test->megatest_id}}" name="megacheck[{{$test->megatest_id}}]" value="0" type="number" >

</td>
</tr>
@endforeach

@foreach ($GroupTests as $group)
<td ondblclick="dblselectgroup({{$group->grouptest_id}})"> {{ $group->test_name }}</td>
<td><input class="grouptestids" id="grouptest_id-{{$group->grouptest_id}}" onchange='setgroupid({{$group->grouptest_id}})' type="checkbox" name="grouptest_id[{{$group->grouptest_id}}]" value="{{ $group->grouptest_id }}" ></td>
<td><input class="groupchecks"  hidden id="grouptestcheck-{{$group->grouptest_id}}" name="groupcheck[{{$group->grouptest_id}}]" value="0" type="number" >

</td>
</tr>
@endforeach

@foreach ($TestData as $test2)
<td ondblclick="dblselecttest({{$test2->test_id}})">{{ $test2->abbrev }}</td>
<td><input class="testids" id="test_id-{{$test2->test_id}}" onchange='settestid({{$test2->test_id}})'  type="checkbox" value="{{$test2->test_id}}" onchange='settestid({{$test->test_id}})'  name="test_id[]" >
<td><input class="testchecks"  hidden id="testcheck-{{$test2->test_id}}" name="seperatecheck[{{$test2->test_id}}]" value="0" type="number" >

</td>
</tr>
@endforeach
</tbody>
</table>
</div>
</div>
        
            <div>
            <button type="submit" class="NewProfileTest"> <b>{{__('title.new_profile_test_btn')}}</button></b> 
            <button type="button" class="cancelbtn"> <b>{{__('title.cancel_btn')}}</button></b>
        </div>   
    </form>     
</body>  
<script src="{{asset('JS/jquery-3.5.1.min.js')}}" ></script> 

<script>


function setmegaid(megatest_id) {
  console.log(megatest_id);
  var megacheck      = document.getElementById("megatest_id-"+megatest_id).checked; 
  var megacheckinput = $('#megatestcheck-'+megatest_id); 
  
  console.log(megacheck);

  if (document.getElementById("megatest_id-"+megatest_id).checked) {
            megacheckinput.val('1');
        } else {
            megacheckinput.val('0');
        }
}

function setgroupid(grouptest_id) {
  console.log(grouptest_id);
  var groupcheck      = document.getElementById("grouptest_id-"+grouptest_id).checked; 
  var groupcheckinput = $('#grouptestcheck-'+grouptest_id); 
  
  console.log(groupcheck);

  if (document.getElementById("grouptest_id-"+grouptest_id).checked) {
            groupcheckinput.val('1');
        } else {
            groupcheckinput.val('0');
        }
}

function dblselectgroup(grouptest_id) {
  console.log(grouptest_id);
  var grouptestcheck =  document.getElementById("grouptest_id-"+grouptest_id).checked; 
  var groupcheckinput = $('#grouptestcheck-'+grouptest_id); 

  console.log(grouptestcheck);
  if (grouptestcheck == false){
    document.getElementById("grouptest_id-"+grouptest_id).checked = true; 
    groupcheckinput.val('1');
  }
  if (grouptestcheck == true){
    document.getElementById("grouptest_id-"+grouptest_id).checked = false; 
    groupcheckinput.val('0');
}}



function dblselecttest(test_id) {
  console.log(test_id);
  var testcheck =  document.getElementById("test_id-"+test_id).checked; 
  var testcheckinput  = $('#testcheck-'+test_id); 

  console.log(testcheck);
  if (testcheck == false){
    document.getElementById("test_id-"+test_id).checked = true; 
    testcheckinput.val('1');
  }
  if (testcheck == true){
    document.getElementById("test_id-"+test_id).checked = false; 
    testcheckinput.val('0');

}}

function dblselectmega(megatest_id) {
  console.log(megatest_id);
  var megatestcheck =  document.getElementById("megatest_id-"+megatest_id).checked; 
  var megacheckinput = $('#megatestcheck-'+megatest_id); 

  console.log(megatestcheck);
  if (megatestcheck == false){
    document.getElementById("megatest_id-"+megatest_id).checked = true; 
    megacheckinput.val('1');
  }
  if (megatestcheck == true){
    document.getElementById("megatest_id-"+megatest_id).checked = false; 
    megacheckinput.val('0');
}}
</script>

<script>
function settestid(test_id) {
  console.log(test_id);
  var testcheck       = document.getElementById("test_id-"+test_id).checked; 
  var testcheckinput  = $('#testcheck-'+test_id); 
  
  console.log(testcheck);

  if (document.getElementById("test_id-"+test_id).checked) {
            testcheckinput.val('1');
        } else {
            testcheckinput.val('0');
        }
   
}

</script>

<script>

function validateForm() {
    var megachecked = 0;
$('.megachecks').each(function(i,megacheck){
  console.log(megacheck);
  megachecked = megachecked + parseInt($(megacheck).val());
});
console.log(megachecked);

var groupchecked = 0;
$('.groupchecks').each(function(i,groupcheck){
  console.log(groupcheck);
  groupchecked = groupchecked + parseInt($(groupcheck).val());
});
console.log(groupchecked);


var testchecked = 0;
$('.testchecks').each(function(i,testcheck){
  console.log(testcheck);
  testchecked = testchecked + parseInt($(testcheck).val());
});
console.log(testchecked);

var testtotal = megachecked + testchecked + groupchecked;
 if ( testtotal == 0) {
alert("{{__('title.no_tests_selected')}}");
return false;
 }
  }
</script>  
</html>  