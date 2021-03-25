<!DOCTPE html>
<html>
<head>
<title>LabTech Software (Normal Ranges)</title>
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
    input[type=number] {   
        font-family:  serif;     
        width: 70%;   
        margin: 0px 0px;  
        padding: 3px 2px;   
        display: inline-block;   
        border: 2px black;   
        box-sizing: border-box;   
        text-align: left;
    }
    select {
    width: auto;  
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
        font-family:  serif;  
        width: 20%;   
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
  height:380px;
  overflow:auto;  
  margin-top:20px;
}
#table-wrapper table {
  width:82%;
margin:auto;
}
#table-wrapper table * {
  background:white;
  color:black;
  font-size: 13px;
  /* font-weight:bold; */
}
#table-wrapper table thead th .text {
  position:absolute;   
  top:-20px;
  z-index:2;
  height:20px;
  width:35%;
  border:1px solid red;
}
#table-wrapper table  th {
  top:0;
  position: sticky;
}
</style>  

</head>
@include('MainMenu')
<body>
<center> <h1 > {{__('title.normals')}} </h1> </center>   
@if( isset($users) && count($users) > 0 && isset($users[0]) && $users[0] )
<center> <b >  {{ $users[0]->testdata? $users[0]->TestData->abbrev:"" }} </b> </center>
@endif
@if( isset($users) && count($users) > 0 && isset($users[0]) && $users[0] )
<a action = "/normalranges/{{$users[0]->test_id}}"></a>
@endif
<br>
@if( isset($users) && count($users) > 0 && isset($users[0]) && $users[0] )
<form name="NormalRanges"  onsubmit="return validateForm()" method="post"  action = "{{url('editnormalranges/'.$users[0]->test_id)}}">
@endif


{{method_field('post')}}
{{csrf_field()}}
<center><td><input type="submit" value="{{__('title.save_normals')}}"/> </td></center>
<br>
<center><input type="button" onclick="location.href='{{url('newtestnormalranges/'.( $test_id ))}}'" value="{{__('title.createnewnormal_normals')}}" ></input></center>

<div id="table-wrapper">
  <div id="table-scroll">
  <table id="myTable">
        <thead>
    <tr>

<th style="text-align:center;" colspan="3">{{__('title.agefrom_normals')}}</th>
<th style="text-align:center;" colspan="3">{{__('title.ageto_normals')}}</th>

<th>{{__('title.normals_from')}}</th>
<th>{{__('title.normals_to')}}</th>
<th>{{__('title.nn_normal_normals')}}</th>
<th>{{__('title.gender_normals')}}</th>
<th>{{__('title.patientcondition_normals')}}</th>
<th>{{__('title.active_normals')}}</th>

<tr>

<th>{{__('title.normals_d')}}</th>
<th>{{__('title.normals_m')}}</th>
<th>{{__('title.normals_y')}}</th>

<th>{{__('title.normals_d')}}</th>
<th>{{__('title.normals_m')}}</th>
<th>{{__('title.normals_y')}}</th>
</tr>
</thead>
<tbody>
@foreach ($users as $user)
<tr>
<td style="display:none">
</td>
<!-- <td><input type="hidden"  name="test_id[{{$user->normal_id}}]"  value="{{ $user->test_id }}" required></td> -->
<td><input class="agefromds"   type="number" min="0" step="1"   name="age_from_d[{{$user->normal_id}}]"  value="{{ $user->age_from_d }}" required></td>
<td><input class="agefromms"   type="number" min="0" step="1"   name="age_from_m[{{$user->normal_id}}]"    value="{{ $user->age_from_m }}" required></td>
<td><input class="agefromys" onchange='checking({{$user->normal_id}})'   type="number" min="0" step="1"   name="age_from_y[{{$user->normal_id}}]"  value="{{ $user->age_from_y }}" required></td>

<td><input  class="agetods"  type="number" min="0" step="1"   name="age_to_d[{{$user->normal_id}}]"    value="{{ $user->age_to_d }}" required></td>
<td><input  class="agetoms"  type="number" min="0" step="1"   name="age_to_m[{{$user->normal_id}}]"  value="{{ $user->age_to_m }}" required></td>
<td><input  class="agetoys"  type="number" min="0" step="1"   name="age_to_y[{{$user->normal_id}}]"    value="{{ $user->age_to_y }}" required></td>

<td><input    type="number" min="0" step="0.01"   name="low[{{$user->normal_id}}]"       value="{{ $user->low }}"></td>
<td><input    type="number" min="0" step="0.01"   name="high[{{$user->normal_id}}]"      value="{{ $user->high }}"></td>
<td><textarea style="height:20;width:150px;" name="nn_normal[{{$user->normal_id}}]">{{ $user->nn_normal }}</textarea></td>
<td><select   type="string"   name="gender[{{$user->normal_id}}]"     required>
    <option value="Male"   {{ $user->gender=="Male"? "selected":"" }}>Male</option>
    <option value="Female" {{ $user->gender=="Female"? "selected":"" }}>Female</option>
</select>
</td>
<td>
<select name="patient_condition[{{$user->normal_id}}]">
<option value=""></option>
    @foreach($PatientCondition as $patientcondition)
    <option value="{{$patientcondition->patientcondition_id}}" {{ $user->patient_condition==$patientcondition->patientcondition_id? "selected" :""}}>{{$patientcondition->patient_condition}}</option>
    @endforeach
    </select> </td>
<td><input  type="checkbox"  name="active[{{$user->normal_id}}]" value="1"  {{ $user->active==1 ? "checked":"" }} ></td>
<td><input id="agefromtotal" class="agefromtotals" hidden  name="age_from_total[{{$user->normal_id}}]"  value="{{ $user->age_from_total }}"></td>
<td><input id="agetototal"   class="agetototals"    hidden  name="age_to_total[{{$user->normal_id}}]"  value="{{ $user->age_to_total }}"></td>
<td><input type="button" onclick="deletenormal({{$user->normal_id}})" value="{{__('title.delete_btn')}}" ></input></td>


</tr>
@endforeach
</tbody>
</table>
</div>
</div>





<script src="{{asset('JS/jquery-3.5.1.min.js')}}" ></script> 

<script>
function deletenormal(normal_id){
  console.log(normal_id);
  var deletenormalrange = confirm("Want to delete ?");
  if (deletenormalrange){
    window.location = "{{url('deletenormal/')}}"+'/'+normal_id;
  }
}

function newnormal(test_id){
  console.log(test_id);
    window.location = "{{url('newtestnormalranges/')}}"+'/'+test_id;
  
}
function validateForm() {
 
  }
</script>
<script>
function checking(normal_id) {
}
</script>
</form>
</body>
</html>