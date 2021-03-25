<!DOCTYPE html>   
<html>   
<head>  
<meta name="viewport" content="width=device-width, initial-scale=1">  
<title> LabTech Software (New Group Test Child) </title>  
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
  position:relative ;
}
#table-scroll {
  height:390px ;
  overflow:auto ;  
  margin-top:20px ;
}
#table-wrapper table {
  width:50% ;

}
#table-wrapper table * {
  background:white ;
  color:black ;
}
#table-wrapper table thead th .text {
  position:absolute ;   
  top:-20px ;
  z-index:2 ;
  height:20px ;
  width:35% ;
  border:1px solid red ;
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
<form role="form" onsubmit="return validateForm()" action = "{{url('newgrouptestschildcreate/'.($grouptest_id))}}" method = "post">
    {{ method_field('post') }}
    {{ csrf_field() }}
	    
    <center> <h1  > {{__('title.create_new_grouptestchild')}} </h1> </center>   
        <div >   
        <b><label>{{__('title.parent_name')}} </label>   </b>
    
            <input type="number" hidden  name="grouptest_id" value="{{$grouptest_id}}" required> 
            <b><label style="width:18%;">{{$test_name}} </label>   </b>
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


@foreach ($TestData as $test2)
<td ondblclick="dblselecttest({{$test2->test_id}})">{{ $test2->abbrev }}</td>
<td><input class="testids" id="test_id-{{$test2->test_id}}" onchange='settestid({{$test2->test_id}})'  type="checkbox" value="{{$test2->test_id}}"   name="test_id[]" >
<td><input class="testchecks"  hidden id="testcheck-{{$test2->test_id}}" name="seperatecheck[{{$test2->test_id}}]" value="0" type="number" >

</td>
</tr>
@endforeach
</tbody>
</table>
</div>
</div>



            <div >
            <button type="submit" class="NewGroupTestChild"> <b>{{__('title.save_btn')}}</button></b>    
            <button type="button" class="cancelbtn"> <b>{{__('title.cancel_btn')}}</button></b>
        </div>   
    </form>     
</body>  
<script src="{{asset('JS/jquery-3.5.1.min.js')}}" ></script> 

<script>






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
var testchecked = 0;
$('.testchecks').each(function(i,testcheck){
  console.log(testcheck);
  testchecked = testchecked + parseInt($(testcheck).val());
});
console.log(testchecked);

var testtotal =  testchecked ;
 if ( testtotal == 0) {
alert("{{__('title.no_tests_selected')}}");
return false;
 }
  }
</script>       
</html>  