<!DOCTYPE html>   
<html>   
<head>  
<meta name="viewport" content="width=device-width, initial-scale=1">  
<title> New Patient Visit </title> 


<style>   
Body {  
  font-family:  serif;  
  background-color: lightgrey; 
  /* background-color: RGB(239,228,176);  */
}  

.container {   
        padding: 0px;   
    }   
button {   
        font-family: serif;
        background-color: RGB(70,87,244);   
        width: 8%;  
        color: Black;   
        padding: 5px;   
        border: none;   
        cursor: pointer; 
        font-weight: bold;
  
         }  
          
 form {   
        border: 1px solid #f1f1f1;   
    }   
 input[type=text] {   
        font-family:  serif;     
        width: 30%;   
        margin: 3px 0px;  
        padding: 8px 5px;   
        font-weight: bold;
        box-sizing: border-box;   
        text-align: left;
    }  
    textarea {   
        font-family: serif;     
        width: 30%;   
        margin: 3px 0px;  
        padding: 8px 5px;   
        font-weight: bold;
        box-sizing: border-box;   
        text-align: left;
    }  

    input[type=string] {   
        font-family:  serif;   
        width: 18%;   
        margin: 0px 0px;  
        padding: 2px 0px;      
        box-sizing: border-box;   
        text-align: left;
        font-weight: bold;
        line-height:10px

    } 

    input[type=number] {   
        font-family:  serif;     
        width: 18%;   
        margin: 0px 0px;  
        padding: 2px 0px;      
        box-sizing: border-box;   
        text-align: left;
        font-weight: bold;

    } 
    
    input[type=date] {   
        font-family:  serif;     
        width: 18%;   
        margin: 0px 0px;  
        padding: 2px 0px;      
        box-sizing: border-box;   
        text-align: left;
        font-weight: bold;
    } 
    
    input[type=timestamp] {   
        font-family:  serif;     
        width: 18%;   
        margin: 0px 0px;  
        padding: 2px 0px;      
        box-sizing: border-box;   
        text-align: left;
        font-weight: bold;
        line-height:10px

    } 
    select {   
        font-family:  serif;     
        width: 12%;   
        margin: 0px 0px;  
        padding: 2px 0px;      
        box-sizing: border-box;   
        text-align: left;
        font-weight: bold;
    } 

    label {   
        font-family: serif;  
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
    #table-wrapper {
  position:relative;
}
#table-scroll {
  height:80px;
  overflow:auto;  
  margin-top:20px;
}
#table-wrapper table {
  width:auto;

}
#table-wrapper table * {
  background:white;
  color:black;
  font-size: 13px;
  font-weight:bold;
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
    <Center> <h1 class="text-center">Patient Registration</h1></center>
    <!-- <input type="button" onclick="location.href='{{url('viewpatientdata')}}'" value="Patient Data"></input>     -->

    <a id="patient_link" href = '' >Search</a> 
              <div>
                  <b> <label  style="width:10%;color:green;" style="float:left">Patient ID </label> </b>  
                  <input style="width:15%"  type="string"  name="patient_id" id="patient_id" onChange="setPatientID()" value='{{ isset($patient) ? "$patient->Patient_ID" : "" }}' >  </b>
          
              <b><label style="width:4%">Title  </label> </b>  
              <select name="title_id"  style="width:7%">
              <option value=""> </option>
              @foreach($Titles as $titles)
              <option value="{{$titles->title_id}}" {{ (isset ($patient) && $patient->Title_id==$titles->title_id)? "selected" :"" }} >{{ $titles->title }}</option>
              @endforeach
              </select> 
              </div>
          </div>



          <div>
                  <b><label style="color:red">Patient Name  </label> </b>
                  <input  style="width:15%" type="string"  name="patient_name" value='{{ isset($patient) ? "$patient->patient_name" : "" }}' required >
        
              <b> <label style="color:red;width:4%">Gender  </label> </b>
                  <select  style="width:7%" name="gender" required>
                  <option value="Male" {{ (isset ($patient) && $patient->Gender=="Male")? "selected" :"" }} >Male</option>
                  <option value="Female" {{ (isset ($patient) && $patient->Gender=="Female")? "selected" :"" }} >Female</option>
                  </select>
              
              <b><label style="width:4%">DOB  </label>  </b> 
              <input style="width:14%;"  type="date" onchange='calculateAge()' name="dob" value='{{ isset($patient) ? "$patient->DOB" : "" }}'>
              
      
              <b><label style="color:red;width:2%">Age </label></b>
              
              <!-- <input type="number" style="width:4%" min="1" step="1" class="form-control" id="ag"  name="ag" value='{{ (isset($patient) && isset($patient->age)) ? "$patient->age" : "" }}' required> -->
              
              <b><label style="color:black;width:1%">Y</label></b>
              <input type="number" style="width:4%" min="0" step="1"  id="age_y"  name="age_y" value='{{ (isset($patient) && isset($patient->age_y)) ? "$patient->age_y" : "0" }}' >
              
              <b><label style="color:black;width:1%">M</label></b>
              <input type="number" style="width:4%" min="0" step="1"  id="age_m"  name="age_m" value='{{ (isset($patient) && isset($patient->age_m)) ? "$patient->age_m" : "0" }}' >
              
              <b><label style="color:black;width:1%">D</label></b>
              <input type="number" style="width:4%" min="0" step="1"  id="age_d"  name="age_d" value='{{ (isset($patient) && isset($patient->age_d)) ? "$patient->age_d" : "0" }}' >
<!-- 
              <select class="form-control" style="width:10%" name="age" >
                  <option value="Years">Years</option>
                  <option value="Months">Months</option>
                  <option value="Weeks">Weeks</option>
                  <option value="Days">Days</option>
              </select>
        -->

          <div>
              <b><label style="color:purple;">Select Price List </label> </b>  
              <select name="rank_pricelist_id" style="width:15%" id="rank_pricelist_id" class="dynamic" data-dependent="relative_pricelist_id" data-type="relative_pricelist_name" required>
              <option value="" >Select Price List</option>
              @foreach($RelativePriceLists as $relativepricelist)
              <option value="{{ $relativepricelist->rank_pricelist_id}}">{{ $relativepricelist->rankpricelists->rank_pricelist_name }}</option>
              @endforeach
              </select>
          
              <b><label style="color:purple;">Relative Price List </label> </b>  
              <select style="width:15%" name="relative_pricelist_id" id="relative_pricelist_id" class="dynamic" required>
              <option value="">Relative Price list</option>
              </select>
              </div>

              <div >
              <div >
              <b><label style="color:red;">Req Date  </label>  </b> 
              <input  type="timestamp" style="width:15%"  name="req_date" value='{{date("Y-m-d\ H:i")}}' required>
              </div>
          </div>
          
          <div>
              <div class="form-group">
              <b><label>Phone Number  </label> </b>
              <input type="string" style="width:15%"   name="phone_number" >
            
              <b> <label style="width:6%">Doctor </label>  </b> 
              <select style="width:15%" name="doctor_id" >
              <option value=""></option>
              @foreach($Doctor as $doctor)
              <option value="{{$doctor->doctor_id}}">{{$doctor->doctor}}</option>
              @endforeach
              </select> 

              <b> <label style="width:6%">Diagnosis </label>  </b> 
              <select style="width:15%"  name="diagnosis_id">
              <option value=""></option>
              @foreach($Diagnosis as $diagnosis)
              <option value="{{$diagnosis->diagnosis_is}}">{{$diagnosis->diagnosis}}</option>
              @endforeach
              </select>
              
         <div>
          <b><label style="color:green;width:10%">Patient Condition  </label> </b>  
              <select style="width:15%" name="patient_condition" >
              <option value=""></option>
              @foreach($PatientCondition as $patientcondition)
              <option value="{{$patientcondition->patientcondition_id}}">{{$patientcondition->patient_condition}}</option>
              @endforeach
              </select> 
            
              <b><label style="width:6%">Country  </label> </b>  
              <select style="width:15%"  name="country_id">
              <option value=""></option>
              @foreach($Country as $country)
              <option value="{{$country->country_id}}">{{$country->country}}</option>
              @endforeach
              </select> 
          
              <b><label style="width:6%">Nationality  </label>  </b> 
              <input style="width:15%" type="string"  name="nationality"  >
          <div>
              <b><label style="width:10%">E_Mail  </label>  </b> 
              <input style="width:15%" type="string" placeholder="example@mail.com"  name="email"  >
          
              <b><label style="width:6%">Web Site  </label>  </b> 
              <input style="width:15%" type="string" placeholder="www.example.com"  name="website" >
              
          <div>
              <b><label>Comment </label>  </b> 
              </div>
              <input style="width:100%" type="text"  name="comment" >
      

          <center><h1>Select Tests</h1></center>
                
            
<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for tests.." title="Type in a name">

<input type="submit" class="default-btn next-step" value="Save"></input>    
<input type="text" style="float:right;width:15%" id="PatientInput" onkeyup="PatientSearch()" placeholder="Search for patients.." title="Type in a name">

<div>
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

<div id="table-wrapper" style="float:left">
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
<td><input class="megatestids" id="megatest_id-{{$test->megatest_id}}" onchange='setmegaid({{$test->megatest_id}})' type="checkbox" name="megatest_id[{{$test->megatest_id}}]" value="{{ $test->megatest_id }}" ></td>
<td><input class="megachecks" hidden  id="megatestcheck-{{$test->megatest_id}}" name="megacheck[{{$test->megatest_id}}]" value="0" type="number" >

</td>
</tr>
@endforeach

@foreach ($groups as $group)
<td ondblclick="dblselectgroup({{$group->grouptest_id}})"> {{ $group->test_name }}</td>
<td><input class="grouptestids" id="grouptest_id-{{$group->grouptest_id}}" onchange='setgroupid({{$group->grouptest_id}})' type="checkbox" name="grouptest_id[{{$group->grouptest_id}}]" value="{{ $group->grouptest_id }}" ></td>
<td><input class="groupcheck" hidden  id="grouptestcheck-{{$group->grouptest_id}}" name="groupcheck[{{$group->grouptest_id}}]" value="0" type="number" >

</td>
</tr>
@endforeach

@foreach ($tests2 as $test2)
<td ondblclick="dblselecttest({{$test2->test_id}})">{{ $test2->abbrev }}</td>
<td><input class="testids" id="test_id-{{$test2->test_id}}" onchange='settestid({{$test2->test_id}})'  type="checkbox" value="{{$test2->test_id}}" onchange='settestid({{$test->test_id}})'  name="test_id[]" >
<td><input class="testchecks" hidden  id="testcheck-{{$test2->test_id}}" name="seperatecheck[{{$test2->test_id}}]" value="0" type="number" >

</td>
</tr>
@endforeach
</tbody>
</table>
</div>
</div>

<script>
function PatientSearch() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("PatientInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("PatientTable");
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
<div id="table-wrapper" style="float:right">
<div id="table-scroll">
<table id="PatientTable">
<thead>
<tr>
<th>Patient Name</th>
</tr>
</thead>
<tbody>
<tr>
@foreach ($patients as $patient)
<td > {{ $patient->patient_name }}</td>
<td><input type="button" onclick="location.href='{{url('newpatientreg/'.( $patient->Patient_ID ))}}'" value="New Visit" ></input></td>

</td>
</tr>
@endforeach
</tbody>
</table>
</div>
</div>
        </form>
    </div>
    </div>
</div>
</div>
</div>
</section>


    <script>
    function setPatientID(){
        console.log("test");
        var id=document.getElementById("patient_id").value;
        document.getElementById("patient_link").href = "{{url('newpatientreg')}}/"+id;
    }
  </script>   
  
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script> -->
<!-- <script src="{{asset('JS/jquery-3.5.1.slim.min.js')}}" ></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" ></script> -->
<!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" ></script> 
<script src="{{asset('JS/patient_reg_form.js')}}"></script> -->
<!-- <script src="{{asset('JS/patient_reg_form.js')}}" ></script>  -->
<!-- <script src="{{asset('CSS/bootstrap v4.1.2.min.js')}}"></script> -->
<script src="{{asset('JS/jquery-3.5.1.min.js')}}" ></script> 

<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->


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
  var groupcheck =  document.getElementById("grouptest_id-"+grouptest_id).checked; 
  var groupcheckinput  = $('#groupcheck-'+grouptest_id); 

  console.log(groupcheck);
  if (groupcheck == false){
    document.getElementById("grouptest_id-"+grouptest_id).checked = true; 
    groupcheckinput.val('1');
  }
  if (groupcheck == true){
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

var testchecked = 0;
$('.testchecks').each(function(i,testcheck){
  console.log(testcheck);
  testchecked = testchecked + parseInt($(testcheck).val());
});
console.log(testchecked);

var testtotal = megachecked + testchecked;
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
</body>     
</html>  