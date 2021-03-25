
<title>LabTech Software (New Patient Reg)</title>

<style>
/* Latest compiled and minified CSS included as External Resource*/

/* Optional theme */

body {
    margin-top:30px;
    font-weight:bold;
    font-size:10px;

}
.stepwizard-step p {
    margin-top: 0px;
    color:#666;
}
.stepwizard-row {
    display: table-row;
}
.stepwizard {
    display: table;
    width: 100%;
    position: relative;
}
.stepwizard-step button[disabled] {
    /*opacity: 1 !important;
    filter: alpha(opacity=100) !important;*/
}
.stepwizard .btn.disabled, .stepwizard .btn[disabled], .stepwizard fieldset[disabled] .btn {
    opacity:1 !important;
    color:#bbb;
}
.stepwizard-row:before {
    top: 14px;
    bottom: 0;
    position: absolute;
    content:" ";
    width: 100%;
    height: 1px;
    background-color: #ccc;
    z-index: 0;
}
.stepwizard-step {
    display: table-cell;
    text-align: center;
    position: relative;
}
.btn-circle {
    width: 30px;
    height: 30px;
    text-align: center;
    padding: 6px 0;
    font-size: 12px;
    line-height: 1.428571429;
    border-radius: 15px;
}
#table-wrapper {
  position:relative;
}
#table-scroll {
  height: 180px;
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
  font-size: 12px;
  padding: 5px 5px 10px 20px;
  border: 1px solid #ddd;
  margin-bottom: 10px;
  font-weight:bold;
}
 
</style>
@if(isset(Auth::user()->login_name))
  @else
  <script>window.location = "{{url('/')}}";</script>
  @endif

@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(3))
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
<head>
</head>
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


<form role="form" name="NewPatrientReg"  onsubmit="return validateForm()"  action="{{url('newpatientregcreate')}}" method="post" class="login-box">
            {{method_field('post')}}
            {{csrf_field()}}

            <div class="panel-body" style="float:left;">
                <div class="form-group">
                <a style="color:black;text-decoration:underline;" id="patient_link" href = '' >Search</a> 
              <div>
                  <b> <label  style="width:6%;color:green;" style="float:left">Patient ID </label> </b>  
                  <input style="width:12%"  type="string"  name="patient_id" id="patient_id" onChange="setPatientID()" value='{{ isset($patient) ? "$patient->Patient_ID" : "" }}' >  </b>
          
              <b><label style="width:5%">Title  </label> </b>  
              <select name="title_id"  style="width:%">
              <option value=""> </option>
              @foreach($Titles as $titles)
              <option value="{{$titles->title_id}}" {{ (isset ($patient) && $patient->Title_id==$titles->title_id)? "selected" :"" }} >{{ $titles->title }}</option>
              @endforeach
              </select> 
         
         
                  <b><label style="width:7%;color:red">Patient Name  </label> </b>
                  <input  style="width:15%" type="string"  name="patient_name" value='{{ isset($patient) ? "$patient->patient_name" : "" }}' required >
        
              <b> <label style="color:red;width:4%">Gender  </label> </b>
                  <select  style="width:7%" name="gender" required>
                  <option value="Male" {{ (isset ($patient) && $patient->Gender=="Male")? "selected" :"" }} >Male</option>
                  <option value="Female" {{ (isset ($patient) && $patient->Gender=="Female")? "selected" :"" }} >Female</option>
                  </select>
              
              <b><label style="width:5%">DOB  </label>  </b> 
              <input style="width:12%"  type="date" onchange='calculateAge()' name="dob" value='{{ isset($patient) ? "$patient->DOB" : "" }}'>
              
      
              <b><label style="color:red;width:2%">Age </label></b>
                            
              <b><label style="color:black;width:1%">Y</label></b>
              <input type="number" style="width:3%" min="0" step="1"  id="age_y"  name="age_y" value='{{ (isset($patient) && isset($patient->age_y)) ? "$patient->age_y" : "0" }}' required>
              
              <b><label style="color:black;width:1%">M</label></b>
              <input type="number" style="width:3%" min="0" step="1"  id="age_m"  name="age_m" value='{{ (isset($patient) && isset($patient->age_m)) ? "$patient->age_m" : "0" }}' required>
              
              <b><label style="color:black;width:1%">D</label></b>
              <input type="number" style="width:3%" min="0" step="1"  id="age_d"  name="age_d" value='{{ (isset($patient) && isset($patient->age_d)) ? "$patient->age_d" : "0" }}' required>
              <div>
              <div class="form-group">
              <b><label style="width:6%">Phone No.  </label> </b>
              <input type="string" style="width:12%"   name="phone_number" >
            
              <b><label style="width:5%;color:red">Req Date  </label>  </b> 
              @if(isset(Auth::user()->login_name))   
              @if(Auth::user()->hasPermissionTo(110))
              <input  type="timestamp" style="width:9%"  name="req_date" value='{{date("Y-m-d\ H:i")}}' required>
              @else
              <input readonly="readonly" type="timestamp" style="width:9%"  name="req_date" value='{{date("Y-m-d\ H:i")}}' required>
              @endif
              @endif
              </div>
            </div>

          <div>
              <b><label style="width:9%;color:purple;">Select Price List </label> </b>  
              <select name="rank_pricelist_id" style="width:15%" id="rank_pricelist_id" class="dynamic" data-dependent="relative_pricelist_id" data-type="relative_pricelist_name" required>
              <option value="" >Select Price List</option>
              @foreach($RelativePriceLists as $relativepricelist)
              <option value="{{ $relativepricelist->rank_pricelist_id}}">{{ $relativepricelist->rankpricelists->rank_pricelist_name }}</option>
              @endforeach
              </select>
         
              <b><label style="width:9%;color:purple;">Relative Price List </label> </b>  
              <select style="width:15%" name="relative_pricelist_id" id="relative_pricelist_id" class="dynamic" required>
              <option value="">Relative Price list</option>
              </select>
              </div>

              <div >
              <div >
              
          </div>
          
          
              <b> <label style="width:6%">Doctor </label>  </b> 
              <select style="width:12%" name="doctor_id" >
              <option value=""></option>
              @foreach($Doctor as $doctor)
              <option value="{{$doctor->doctor_id}}">{{$doctor->doctor}}</option>
              @endforeach
              </select> 

              <b> <label style="width:6%">Diagnosis </label>  </b> 
              <select style="width:12%"  name="diagnosis_id">
              <option value=""></option>
              @foreach($Diagnosis as $diagnosis)
              <option value="{{$diagnosis->diagnosis_is}}">{{$diagnosis->diagnosis}}</option>
              @endforeach
              </select>
              
   
          <b><label style="color:green;width:9%">Patient Condition  </label> </b>  
              <select style="width:12%" name="patient_condition" >
              <option value=""></option>
              @foreach($PatientCondition as $patientcondition)
              <option value="{{$patientcondition->patientcondition_id}}">{{$patientcondition->patient_condition}}</option>
              @endforeach
              </select> 
            <div>
              <b><label style="width:6%">Country  </label> </b>  
              <select style="width:12%"  name="country_id">
              <option value=""></option>
              @foreach($Country as $country)
              <option value="{{$country->country_id}}">{{$country->country}}</option>
              @endforeach
              </select> 
          
              <b><label style="width:6%">Nationality  </label>  </b> 
              <input style="width:12%" type="string"  name="nationality"  >
     
              <b><label style="width:9%">E_Mail  </label>  </b> 
              <input style="width:12%" type="string" placeholder="example@mail.com"  name="email"  >
          
              <b><label style="width:9%">Web Site  </label>  </b> 
              <input style="width:12%" type="string" placeholder="www.example.com"  name="website" >
              
          <div>
              <b><label>Comment </label>  </b> 
              </div>
              <input style="width:80%" type="text"  name="comment" >
    </div>
            <div class="panel-body" >
                <div class="form-group">
                <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for tests.." title="Type in a name">
                <input type="submit" class="default-btn next-step" value="Save"></input>    

                
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

<div id="table-wrapper" >
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
@foreach ($tests as $test)
<td ondblclick="dblselectmega({{$test->megatest_id}})"> {{ $test->test_name }}</td>
<td><input class="testids" id="megatest_id-{{$test->megatest_id}}" onchange='setmegaid({{$test->megatest_id}})'  type="checkbox" name="megatest_id[{{$test->megatest_id}}]" value="{{ $test->megatest_id }}" ></td>
<td><input class="megachecks" hidden  id="megatestcheck-{{$test->megatest_id}}" name="megacheck[{{$test->megatest_id}}]" value="0" type="number" >
<td><input class="meganames" hidden  id="megatest_name-{{$test->megatest_id}}" name="megatest_name[{{$test->megatest_id}}]" value="{{ $test->test_name }}">

</td>
</tr>
@endforeach

@foreach ($groups as $group)
<td ondblclick="dblselectgroup({{$group->grouptest_id}})"> {{ $group->test_name }}</td>
<td><input class="testids" id="grouptest_id-{{$group->grouptest_id}}" onchange='setgroupid({{$group->grouptest_id}})' type="checkbox" name="grouptest_id[{{$group->grouptest_id}}]" value="{{ $group->grouptest_id }}" ></td>
<td><input class="groupchecks" hidden  id="grouptestcheck-{{$group->grouptest_id}}" name="groupcheck[{{$group->grouptest_id}}]" value="0" type="number" >
<td><input class="groupnames" hidden  id="grouptest_name-{{$group->grouptest_id}}" name="grouptest_name[{{$group->grouptest_id}}]" value="{{ $group->test_name }}">

</td>
</tr>
@endforeach

@foreach ($tests2 as $test2)
<td ondblclick="dblselecttest({{$test2->test_id}})">{{ $test2->abbrev }}</td>
<td><input class="testids" id="test_id-{{$test2->test_id}}" onchange='settestid({{$test2->test_id}})'  type="checkbox" value="{{$test2->test_id}}" onchange='settestid({{$test->test_id}})'  name="test_id[]" >
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


<script src="{{asset('JS/jquery-3.5.1.min.js')}}" ></script> 

<!-- <script>


$(document).ready(function () {

var navListItems = $('div.setup-panel div a'),
    allWells = $('.setup-content'),
    allNextBtn = $('.nextBtn');

allWells.hide();

navListItems.click(function (e) {
    e.preventDefault();
    var $target = $($(this).attr('href')),
        $item = $(this);

    if (!$item.hasClass('disabled')) {
        navListItems.removeClass('btn-success').addClass('btn-default');
        $item.addClass('btn-success');
        allWells.hide();
        $target.show();
        $target.find('input:eq(0)').focus();
    }
});

allNextBtn.click(function () {
    var curStep = $(this).closest(".setup-content"),
        curStepBtn = curStep.attr("id"),
        nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
        curInputs = curStep.find("input[type='text'],input[type='url']"),
        isValid = true;

    $(".form-group").removeClass("has-error");
    for (var i = 0; i < curInputs.length; i++) {
        if (!curInputs[i].validity.valid) {
            isValid = false;
            $(curInputs[i]).closest(".form-group").addClass("has-error");
        }
    }

    if (isValid) nextStepWizard.removeAttr('disabled').trigger('click');
});

$('div.setup-panel div a.btn-success').trigger('click');
});
</script> -->

<script>


    function setPatientID(){
        console.log("test");
        var id=document.getElementById("patient_id").value;
        document.getElementById("patient_link").href = "{{url('newpatientreg')}}/"+id;
    }
  </script>   
  
<script src="{{asset('JS/jquery-3.5.1.min.js')}}" ></script> 


<script>
$().ready(function(){

$('.dynamic').change(function(){
 if($(this).val() != '')
 {
  var select    = $(this).attr("id");
  var value     = $(this).val();
  var dependent = $(this).data('dependent');
  var nam       = $(this).data('type');
  console.log(nam);
  console.log(dependent);

  var _token    = $('input[name="_token"]').val();
//    $.ajaxSetup({
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         }   
//     });
  $.ajax({
   url:"{{ route('dynamicdependent.fetch') }}",
   method:"POST",
   data:{select:select, value:value, _token:_token, dependent:dependent ,nam:nam},
   success:function(result)
   {
    $('#'+dependent).html(result);
   }
  })
 }
});

 $('#pricelist_id').change(function(){
 $('#relative_pricelist_id').val('');
});


});
</script>

<!-- <script>
$(document).ready(function(){
  $('.testids').click(function(){
    // var text = "";
    $('.testids:checked').each(function(){
      text= $(this).val();
      console.log(text)
    });
    // $('#get_checked').val($("[type='checkbox']:checked").length);
    $('#get_checked').val(text);
  });
});
</script> -->


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

  <h1 id="age" ></h1>
  <script>
    function calculateAge(dob) {
      var now = new Date();
      var dob = new Date($('input[name=dob]').val());
      var year=now.getYear()-dob.getYear();
      var month=now.getMonth()-dob.getMonth();
      if(month<0){
        month=now.getMonth()+12-dob.getMonth();
        year=year-1;
      }
      var day=now.getDate()-dob.getDate();
      if(day<0){
        var monthNumber=dob.getMonth();
        var fullDate=getFullDate(monthNumber);
        day=now.getDate()+fullDate-dob.getDate();
        month=month-1;
      }
// console.log(day);
$('#age_y').val(year)
$('#age_m').val(month)
$('#age_d').val(day)
    };
    function getFullDate(x){
      switch(x){
        case 0:
          return 31;
          break;
        case 1:
          return 28;
          break;
        case 2:
          return 31;
          break;
        case 3:
          return 30;
          break;
        case 4:
          return 31;
          break;
        case 5:
          return 30;
          break;
        case 6:
          return 31;
          break;
        case 7:
          return 31;
          break;
        case 8:
          return 30;
          break;
        case 9:
          return 31;
          break;
        case 10:
          return 30;
          break;
        case 11:
          return 31;
      }
    }
    function getAge(){
      x=prompt("Please Enter Your Date of Birth in format (yyyy-mm-dd): ","");
      x=new Date(x);
      document.getElementById("age").innerHTML="Your age is: "+calculateAge(x);
    }
  </script>
  <script>
  var unsaved = false;

$(":input").change(function(){ //triggers change in all input fields including text type
    unsaved = true;
});

function unloadPage(){ 
    if(unsaved){
        return "You have unsaved changes on this page";
    }
}

// window.onbeforeunload = unloadPage;
  </script>
