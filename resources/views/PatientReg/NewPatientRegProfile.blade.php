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
  height: 200px;
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
@if(Auth::user()->hasPermissionTo(4))
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
@endif<head>
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
<form role="form" name="NewPatrientReg"  onsubmit="return validateForm()"  action="{{url('newpatientregprofilecreate')}}" method="post" class="login-box">
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
              <input type="number" style="width:3%" min="0" step="1"  id="age_y"  name="age_y" value='{{ (isset($patient) && isset($patient->age_y)) ? "$patient->age_y" : "0" }}' >
              
              <b><label style="color:black;width:1%">M</label></b>
              <input type="number" style="width:3%" min="0" step="1"  id="age_m"  name="age_m" value='{{ (isset($patient) && isset($patient->age_m)) ? "$patient->age_m" : "0" }}' >
              
              <b><label style="color:black;width:1%">D</label></b>
              <input type="number" style="width:3%" min="0" step="1"  id="age_d"  name="age_d" value='{{ (isset($patient) && isset($patient->age_d)) ? "$patient->age_d" : "0" }}' >
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
                <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for profiles.." title="Type in a name">

<input type="submit" class="default-btn next-step" value="Save"></input>      

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
<td ondblclick="dblselectprofile({{$test->profile_id}})"> {{ $test->profile_name }}</td>
<td><input class="profileids" id="profile_id-{{$test->profile_id}}" onchange='setprofileid({{$test->profile_id}})' type="checkbox" name="profile_id[{{$test->profile_id}}]" value="{{ $test->profile_id }}" ></td>
<td><input class="profilechecks"  hidden id="profilecheck-{{$test->profile_id}}" name="profilecheck[{{$test->profile_id}}]" value="0" type="number" >
</td>
</tr>
@endforeach
</tbody>
</table>
</div>
</div>



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
        document.getElementById("patient_link").href = "{{url('newpatientregprofile')}}/"+id;
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
<script>

function setprofileid(profile_id) {
  console.log(profile_id);
  var profilecheck      = document.getElementById("profile_id-"+profile_id).checked; 
  var profilecheckinput = $('#profilecheck-'+profile_id); 
  
  console.log(profilecheck);

  if (document.getElementById("profile_id-"+profile_id).checked) {
    profilecheckinput.val('1');
        } else {
    profilecheckinput.val('0');
        }

}

function dblselectprofile(profile_id) {
  console.log(profile_id);
  var profilecheck       =  document.getElementById("profile_id-"+profile_id).checked; 
  var profilecheckinput  = $('#profilecheck-'+profile_id); 

  console.log(profilecheck);
  if (profilecheck == false){
    document.getElementById("profile_id-"+profile_id).checked = true; 
    profilecheckinput.val('1');
  }
  if (profilecheck == true){
    document.getElementById("profile_id-"+profile_id).checked = false; 
    profilecheckinput.val('0');

}}

  </script>
<script>

function validateForm() {
    var profilechecked = 0;
$('.profilechecks').each(function(i,profilecheck){
  console.log(profilecheck);
  profilechecked = profilechecked + parseInt($(profilecheck).val());
});
console.log(profilechecked);

 if ( profilechecked == 0) {
alert("{{__('title.no_profiles_selected')}}");
return false;
 }
  }
</script>
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
    </script>