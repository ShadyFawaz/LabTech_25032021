<!DOCTYPE html>   
<html>   
<head>    
<title> LabTech Software </title>  
<style>   
Body {  
  font-family: serif;  
  background-color: lightgrey;  
}  

    input[type=text] {   
        font-family:  serif;   
        font-weight:bold;  
        width: 30% !important;   
        margin: 0px 0px;  
        padding: 2px 0px;      
          
        box-sizing: border-box;   
        text-align: left;
    }  
    textarea {   
        font-family:  serif;     
        width: 80% !important;   
        margin: 3px 0px;  
        padding: 8px 5px;   
          
        box-sizing: border-box;   
        text-align: left;
    }  
    input[type=date] {   
        font-family:  serif; 
        font-weight:bold;    
        width: 30% !important;   
        margin: 0px 0px;  
        padding: 2px 0px;      
          
        box-sizing: border-box;   
        text-align: left;
    }  
    input[type=timestamp] {   
        font-family:  serif;   
        font-weight:bold;  
        width: 30% !important;   
        margin: 0px 0px;  
        padding: 2px 0px;      
          
        box-sizing: border-box;   
        text-align: left;
    }  
    input[type=string] {   
        font-family: serif; 
        font-weight:bold;    
        width: 30% !important;   
        margin: 0px 0px;  
        padding: 2px 0px;      
        box-sizing: border-box;   
        text-align: left;
    } 

    input[type=number] {   
        font-family: serif;  
        font-weight:bold;   
        width: 5%;   
        margin: 0px 0px;  
        padding: 2px 0px;      
        box-sizing: border-box;   
        text-align: left;
    } 
    select {   
        font-family:  serif; 
        font-weight:bold;   
        width: 30% !important;   
        margin: 0px 0px;  
        padding: 2px 0px;      
        box-sizing: border-box;   
        text-align: left;
    } 
    label {   
        font-family:  serif;  
        width: 40% ;   
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

    table {
  font-family: serif;
  border-collapse: collapse;
  font-weight:bold;
  width: 60%;
}
td, th {
  text-align: left;
  padding: 0px;
}
tr {
}


</style>  
@include('MainMenu') 
</head>    
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
<form action = "{{url('editpatientreg/'.$users[0]->regkey)}}" method = "post">
    {{ method_field('post') }}
    {{ csrf_field() }}
    
    <center> <h1 > {{__('title.edit_patient_visit')}} </h1> </center>   
   
<input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
<table>
<tr>
<td>{{__('title.patientid_reg_edit')}}</td>
<td>
<input type = 'text' name = 'patient_id'
value = '{{$users[0]->patient_id}}' readOnly="readonly"/> </td>
</tr>


<tr>
<td>{{__('title.title_reg_edit')}}</td>
<td>
<select name="title_id">
<option value=""> </option>
            @foreach($Titles as $titles)
            <option value="{{$titles->title_id}}" {{ $users[0]->title_id==$titles->title_id? "selected" :""}}>{{$titles->title}}</option>
            @endforeach
            </select> 
</td>
</tr>


<tr>
<td>{{__('title.patientname_reg_edit')}}</td>
<td>
<input type = 'text' name = 'patient_name'
value = '{{$users[0]->patient_name}}'/>
</td>
</tr>


<tr>
<td>{{__('title.gender_reg_edit')}}</td>
<td>
<select id="gender" name="gender" onchange='newGenderAlert()' required>
               <option value="Male" {{ $users[0]->gender=="Male"? "selected":"" }}>Male</option>
               <option value="Female" {{ $users[0]->gender=="Female"? "selected":"" }}>Female</option>
            </select>
</td>
</tr>


<tr>
<td>{{__('title.dob_reg_edit')}}</td>
<td>
<input type = 'date' name = 'dob'
value = '{{$users[0]->dob}}' onchange='calculateAge()'/>
</td>
</tr>


<td>{{__('title.age_reg_edit')}}</td>
<td>
<!-- <input type = 'number' step="1" min="1" id="ag" name = 'ag'
value = '{{$users[0]->ag}}' onchange='newAgeAlert()' required/>  -->
<!-- <select name="age" required>
               <option value="Days" {{ $users[0]->age=="Days"? "selected":"" }}>Days</option>
               <option value="Weeks" {{ $users[0]->age=="Weeks"? "selected":"" }}>Weeks</option>
               <option value="Months" {{ $users[0]->age=="Months"? "selected":"" }}>Months</option>
               <option value="Years" {{ $users[0]->age=="Years"? "selected":"" }}>Years</option>

            </select> -->
<b><label style="color:black;width:3%">Y</label></b>
<input onchange='newAgeAlert()' type="number" style="width:5%" min="0" step="1"  id="age_y"  name="age_y" value='{{ $users[0]->age_y }}' >

<b><label style="color:black;width:3%">M</label></b>
<input onchange='newAgeAlert()' type="number" style="width:5%" min="0" step="1"  id="age_m"  name="age_m" value='{{  $users[0]->age_m }}' >

<b><label style="color:black;width:3%">D</label></b>
<input onchange='newAgeAlert()' type="number" style="width:5%" min="0" step="1"  id="age_d"  name="age_d" value='{{  $users[0]->age_d}}' >

</td>
</tr>




<tr>
<td>{{__('title.reqdate_reg_edit')}}</td>
<td>
<input type = 'timestamp' name = 'req_date'
value = '{{$users[0]->req_date}}' readonly="readonly"/>
</td>
</tr>

<tr>
<td>{{__('title.doctor_reg_edit')}}</td>
<td>
<select name="doctor_id">
<option value=""></option>
            @foreach($Doctor as $doctor)
               <option value="{{$doctor->doctor_id}}" {{ $users[0]->doctor_id==$doctor->doctor_id? "selected":""}}>{{$doctor->doctor}}</option>
            @endforeach
            </select> 
</td>
</tr>

<tr>
<td>{{__('title.pricelist_reg')}}</td>
<td>
<input readonly type = 'text' name = 'rank_pricelist'
value = '{{$users[0]->relativepricelists->rankpricelists->rank_pricelist_name}}'/>
</td>
</tr>

<tr>
<td>{{__('title.relative_pricelist_reg')}}</td>
<td>
<input readonly type = 'text' name = 'rank_pricelist'
value = '{{$users[0]->relativepricelists->relative_pricelist_name}}'/>
</td>
</tr>

<tr>
<td>{{__('title.patientcondition_reg_edit')}}</td>
<td>
<select name="patient_condition">
<option value=""></option>
            @foreach($PatientCondition as $patientcondition)
               <option value="{{$patientcondition->patientcondition_id}}" {{ $users[0]->patient_condition==$patientcondition->patientcondition_id? "selected":""}}>{{$patientcondition->patient_condition}}</option>
            @endforeach
            </select> 
</td>
</tr>

<tr>
<td>{{__('title.diagnosis_reg_edit')}}</td>
<td>
<select name="diagnosis_id">
<option value=""></option>
            @foreach($Diagnosis as $diagnosis)
               <option value="{{$diagnosis->diagnosis_id}}" {{ $users[0]->diagnosis_id==$diagnosis->diagnosis_id? "selected":""}}>{{$diagnosis->diagnosis}}</option>
            @endforeach
            </select> 
</td>
</tr>

<tr>
<td>{{__('title.email_reg_edit')}}</td>
<td>
<input type = 'text' name = 'email'
value = '{{$users[0]->email}}'/>
</td>
</tr>


<tr>
<td>{{__('title.website_reg_edit')}}</td>
<td>
<input type = 'text' name = 'website'
value = '{{$users[0]->website}}'/>
</td>
</tr>


<tr>
<td>{{__('title.country_reg_edit')}}</td>
<td>
<select name="country_id">
<option value=""></option>
            @foreach($Country as $country)
               <option value="{{$country->country_id}}" {{ $users[0]->country_id==$country->country_id? "selected":""}}>{{$country->country}}</option>
            @endforeach
            </select> 
</td>
</tr>


<tr>
<td>{{__('title.nationality_reg_edit')}}</td>
<td>
<input type = 'text' name = 'nationality'
value = '{{$users[0]->nationality}}'/>
</td>
</tr>



<td>{{__('title.comment_reg_edit')}}</td>
<td>
<textarea type = 'text' name = 'comment'
value = '{{$users[0]->comment}}'></textarea>
</td>
</tr>


<td colspan = '2'>
<input type = 'submit' value = "{{__('title.update_patient_visit_btn')}}" />
</td>
</tr>
</table>
<script src="{{asset('JS/jquery-3.5.1.min.js')}}" ></script> 

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
<script>
function newAgeAlert(){
  var Age_Y = $('#age_y').val();
  var Age_M = $('#age_m').val();
  var Age_D = $('#age_d').val();

  alert ("This change may affect normal ranges");
}
</script>
<script>
function newGenderAlert(){
  var Gender = $('#gender').val();
console.log(Gender);
  alert ("This change may affect normal ranges");
}
</script>
</form>
</html>  