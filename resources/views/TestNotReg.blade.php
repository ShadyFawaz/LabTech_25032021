<!DOCTPE html>
<html>
<head>
<title>LabTech Software (Add Tests)</title>
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
    width: 100%;  
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
  height:280px;
  overflow:auto;  
  margin-top:20px;
}
#table-wrapper table {
  width:50%;

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

/* #myTable tr.header, #myTable tr:hover {
  background-color: #f1f1f1;
  font-family: times_new_roman, serif; 
  margin-bottom: 10px; 
} */

</style>  
</head>
@include('MainMenu')
<body>
<center> <h1 > {{__('title.patienttests_testreg')}} </h1> </center>   
<form name="NewTestPatientReg"  onsubmit="return validateForm()" action = "{{url('/newtestpatientreg/'.($users[0]->regkey))}}" method = "post">
    {{ method_field('post') }}
    {{ csrf_field() }}
    

<center><h1 class="text-center">Select Tests</h1></center>
<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for tests.." title="Type in a name">
<input type="submit" value="Save"></input>

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

</tr>
</thead>
<tbody>
<tr>
@foreach ($MegaTestNotReg as $test)
<td ondblclick="dblselectmega({{$test->megatest_id}})"> {{ $test->test_name }}</td>
<td><input class="megatestids" id="megatest_id-{{$test->megatest_id}}" onchange='setmegaid({{$test->megatest_id}})' type="checkbox" name="megatest_id[{{$test->megatest_id}}]" value="{{ $test->megatest_id }}" ></td>
<td><input class="megachecks" hidden  id="megatestcheck-{{$test->megatest_id}}" name="megacheck[{{$test->megatest_id}}]" value="0" type="number" >
<td><input class="meganames" hidden  id="megatest_name-{{$test->megatest_id}}" name="megatest_name[{{$test->megatest_id}}]" value="{{ $test->test_name }}">

</td>
</tr>
@endforeach

@foreach ($GroupTestNotReg as $group)
<td ondblclick="dblselectgroup({{$group->grouptest_id}})"> {{ $group->test_name }}</td>
<td><input class="grouptestids" id="grouptest_id-{{$group->grouptest_id}}" onchange='setgroupid({{$group->grouptest_id}})' type="checkbox" name="grouptest_id[{{$group->grouptest_id}}]" value="{{ $group->grouptest_id }}" ></td>
<td><input class="groupchecks" hidden  id="grouptestcheck-{{$group->grouptest_id}}" name="groupcheck[{{$group->grouptest_id}}]" value="0" type="number" >
<td><input class="groupnames" hidden  id="grouptest_name-{{$group->grouptest_id}}" name="grouptest_name[{{$group->grouptest_id}}]" value="{{ $group->test_name }}">

</td>
</tr>
@endforeach

@foreach ($TestNotReg as $test2)
<td ondblclick="dblselecttest({{$test2->test_id}})">{{ $test2->abbrev }}</td>
<td><input class="testids" id="test_id-{{$test2->test_id}}" onchange='settestid({{$test2->test_id}})'  type="checkbox" name="test_id[{{$test2->test_id}}]" value="{{$test2->test_id}}"   >
<td><input class="testchecks" hidden  id="testcheck-{{$test2->test_id}}" name="seperatecheck[{{$test2->test_id}}]" value="0" type="number" >
<td><input class="testnames" hidden  id="test_name-{{$test2->test_id}}" name="test_name[{{$test2->megatest_id}}]" value="{{ $test2->abbrev }}">

</td>
</tr>
@endforeach
</tbody>
</table>
</div>
</div>
<br>
<textarea style="width:50%;line-height:25px;" id="get_checked"></textarea>

</body>
</form>
<script src="{{asset('JS/jquery-3.5.1.min.js')}}" ></script> 

<script>


function setmegaid(megatest_id) {
  console.log(megatest_id);
  var megacheck      = document.getElementById("megatest_id-"+megatest_id).checked; 
  var megacheckinput = $('#megatestcheck-'+megatest_id); 
  var megatestname   = $('#megatest_name-'+megatest_id).val(); 
  var text = megatestname; 
  var concat = $("#get_checked").val();
  var tests  = concat + ", "+ text 
  console.log(megacheck);

  if (document.getElementById("megatest_id-"+megatest_id).checked) {
            megacheckinput.val('1');
            $("#get_checked").val(tests);
        } else {
            megacheckinput.val('0');
            var notests = concat.replace((", "+text),"")
            $("#get_checked").val(notests);
        }
}



function setgroupid(grouptest_id) {
  console.log(grouptest_id);
  var groupcheck      = document.getElementById("grouptest_id-"+grouptest_id).checked; 
  var groupcheckinput = $('#grouptestcheck-'+grouptest_id); 
  var grouptestname   = $('#grouptest_name-'+grouptest_id).val(); 

  var text = grouptestname;
  var concat = $("#get_checked").val();
  var tests  = concat + ", "+ text 

  console.log(grouptestname);

  if (document.getElementById("grouptest_id-"+grouptest_id).checked) {
            groupcheckinput.val('1');
            $("#get_checked").val(tests);

        } else {
            groupcheckinput.val('0');
            var notests = concat.replace((", "+text),"")
            $("#get_checked").val(notests);
        }
}





function dblselectgroup(grouptest_id) {
  console.log(grouptest_id);
  var groupcheck =  document.getElementById("grouptest_id-"+grouptest_id).checked; 
  var groupcheckinput  = $('#grouptestcheck-'+grouptest_id); 
  var grouptestname   = $('#grouptest_name-'+grouptest_id).val(); 

    var text = grouptestname;
    var concat = $("#get_checked").val();
    var tests  = concat + ", "+ text; 
  console.log(groupcheckinput);

  console.log(groupcheck);
  if (groupcheck == false){
    document.getElementById("grouptest_id-"+grouptest_id).checked = true; 
    groupcheckinput.val('1');
    $("#get_checked").val(tests);

  }
  if (groupcheck == true){
    document.getElementById("grouptest_id-"+grouptest_id).checked = false; 
    groupcheckinput.val('0');
    var notests = concat.replace((", "+text),"")
    $("#get_checked").val(notests);

}}


function dblselecttest(test_id) {
  console.log(test_id);
  var testcheck =  document.getElementById("test_id-"+test_id).checked; 
  var testcheckinput  = $('#testcheck-'+test_id); 
  var testname   = $('#test_name-'+test_id).val(); 

    var text = testname;
    var concat = $("#get_checked").val();
    var tests  = concat + ", "+ text;

  console.log(testcheck);
  if (testcheck == false){
    document.getElementById("test_id-"+test_id).checked = true; 
    testcheckinput.val('1');
    $("#get_checked").val(tests);

  }
  if (testcheck == true){
    document.getElementById("test_id-"+test_id).checked = false; 
    testcheckinput.val('0');
    var notests = concat.replace((", "+text),"")
    $("#get_checked").val(notests);
}}

function dblselectmega(megatest_id) {
  console.log(megatest_id);
  var megatestcheck =  document.getElementById("megatest_id-"+megatest_id).checked; 
  var megacheckinput = $('#megatestcheck-'+megatest_id); 
  var megatestname   = $('#megatest_name-'+megatest_id).val(); 

    var text = megatestname;
    var concat = $("#get_checked").val();
    var tests  = concat + ", "+ text; 

  console.log(megatestcheck);
  if (megatestcheck == false){
    document.getElementById("megatest_id-"+megatest_id).checked = true; 
    megacheckinput.val('1');
    $("#get_checked").val(tests);

  }
  if (megatestcheck == true){
    document.getElementById("megatest_id-"+megatest_id).checked = false; 
    megacheckinput.val('0');
    var notests = concat.replace((", "+text),"")
    $("#get_checked").val(notests);
}}
</script>

<script>
function settestid(test_id) {
  console.log(test_id);
  var testcheck       = document.getElementById("test_id-"+test_id).checked; 
  var testcheckinput  = $('#testcheck-'+test_id); 
  var testname   = $('#test_name-'+test_id).val(); 

  var text = testname;
  var concat = $("#get_checked").val();
  var tests  = concat + ", "+ text 
  console.log(testcheck);

  if (document.getElementById("test_id-"+test_id).checked) {
            testcheckinput.val('1');
            $("#get_checked").val(tests);

        } else {
            testcheckinput.val('0');
            var notests = concat.replace((", "+text),"")
            $("#get_checked").val(notests);
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