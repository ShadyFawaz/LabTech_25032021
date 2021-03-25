<!DOCTPE html>
<html>
<head>
<title>LabTech Software (Today's Patients)</title>
<style>   
Body {  
  font-family:  serif;  
  background-color: lightgrey;  
}  

 form {   
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
        width: 8%;   
        margin: 0px 0px;  
        padding: 3px 2px;   
        display: inline-block;   
        border: 2px black;   
        box-sizing: border-box;   
        text-align: left;
    }
    input[type=datetime] {   
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
        background-color: #e7e7e7;   
        width: auto;  
        color: Black;   
        padding: 2px;   
        border: none; 
        font-weight: bold;
        font-size: 12px; 
    } 
    input[type=button]:hover {   
        opacity: 0.7;   
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
        font-family:serif;  
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
  height:390px;
  overflow:auto;  
  margin-top:20px;
}
#table-wrapper table {
  width:100%;
}
#table-wrapper table th  {
  background:white;
  color:black;
  font-size: 13px;
  font-weight:bold;
  line-height:24px;
}
#table-wrapper table td {
  background:white;
  color:black;
  font-size: 13px;
  font-weight:bold;
  line-height:24px;
}
#table-wrapper table  th {
  top:0;
  position: sticky;
}

#table-wrapper table tr:nth-child(even) {background-color: lightsalmon;}


#myInput {
  width: 30%;
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
@if(Auth::user()->hasPermissionTo(1))
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
<form method="post" action="{{url('patientregsearch')}}">
            {{method_field('post')}}
            {{csrf_field()}}

<center> <h1 > {{__('title.patients_reg')}} </h1> </center>   
<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for Patients.." title="Type in a name"></input>


<script>
function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[3];
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
@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(3))
<input type="button" onclick="newPatient()" value="{{__('title.newpatientreg')}}"></input>
@endif
@endif
@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(4))
<input type="button" onclick="newPatientProfile()" value="{{__('title.newpatientregprofile')}}"></input>
@endif
@endif
<label style="float:right;width:15%;background-color:yellow"> {{__('title.patient_count')}} = {{$patient_count}} </label>

<div>
<th> {{__('title.patientid_reg')}}</th>
<input type="text" name="patient_id" >
<th>{{__('title.visitno_reg')}}</th>
<input type="number" min="1" step="1" name="visit_no" >
<th>{{__('title.patientname_reg')}}</th>
<input type="text" name="patient_name" >
<th>{{__('title.reqdatefrom_reg')}}</th>
<input type="datetime" name="datefrom" value="{{Carbon\Carbon::now()->format('Y-m-d\ 00:00')}}">
<th>{{__('title.reqdateto_reg')}}</th>
<input type="datetime" name="dateto" value="{{Carbon\Carbon::now()->format('Y-m-d\ 23:59')}}">
<input type="submit" name="PatientRegSearch" value="{{__('title.search_btn')}}" >  

</div>


<div id="table-wrapper">
<div id="table-scroll">
<table id="myTable">
    <thead>
        <tr >
<th style="color:red;"> {{__('title.patientid_reg')}}</th>
<th> {{__('title.visitno_reg')}}</th>
<th>{{__('title.title_reg')}}</th>
<th>{{__('title.patientname_reg')}}</th>
<th>{{__('title.gender_reg')}}</th>
<th style="color:orange;">{{__('title.dob_reg')}}</th>
<th>{{__('title.age_reg')}}</th>
<th>{{__('title.reqdate_reg')}}</th>
<th>{{__('title.pricelist_reg')}}</th>
<th>{{__('title.relative_pricelist_reg')}}</th>
<th>{{__('title.doctor_reg')}}</th>
<th>{{__('title.patientcondition_reg')}}</th>
<th>{{__('title.diagnosis_reg')}}</th>
<th>{{__('title.country_reg')}}</th>
<th>{{__('title.nationality_reg')}}</th>
<th>{{__('title.email_reg')}}</th>
<th>{{__('title.website_reg')}}</th>
<th>{{__('title.comment_reg')}}</th>
</tr>
</thead>
<tbody>
@foreach ($users as $user)
<tr>
<td>{{ $user->patient_id }}</td>
<td>{{ $user->visit_no }}</td>
<td>{{ $user->titles? $user->titles->title:"" }}</td>

@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(3))
<td ondblclick="location.href='{{url('newpatientreg/'.( $user->patient_id ))}}'">{{ $user->patient_name }}</td>
@else
<td>{{ $user->patient_name }}</td>
@endif
@endif

<td>{{ $user->gender }}</td>
<td>{{ $user->dob}}</td>
<td> {{ $user->age_y }} Y {{ $user->age_m}} M {{ $user->age_d}} D</td>

<td>{{ $user->req_date }} </td>
<td>{{ $user->RankPriceLists->rank_pricelist_name }}</td>
<td>{{ $user->relativepricelists->relative_pricelist_name }}</td>
<td>{{ $user->doctor? $user->doctor->doctor:"" }}</td>
<td>{{ $user->patientcondition? $user->patientcondition->patient_condition:"" }}</td>
<td>{{ $user->diagnosis? $user->diagnosis->diagnosis:"" }}</td>
<td>{{ $user->country? $user->country->country:"" }}</td>
<td>{{ $user->nationality }}</td>
<td>{{ $user->email }}</td>
<td>{{ $user->website }}</td>
<td>{{ $user->comment }}</td>
@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(127))
<td><input type="button" onclick="editpatient({{$user->regkey}})" value="{{__('title.edit_patientreg_btn')}}" ></input></td>
@endif
@endif
@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(128))
<td><input type="button" onclick="payment({{$user->regkey}})" value="{{__('title.transaction_patientreg_btn')}}" ></input></td>
@endif
@endif
@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(118))
<td><input style="background-color:red;" type="button" onclick="deletePatient({{$user->regkey}})" value="{{__('title.delete_btn')}}" ></input></td>
@endif
@endif
<td><input type="button" onclick="patTests({{$user->regkey}})" value="{{__('title.patienttests_reg')}}" ></input></td>
<td><input type="button" onclick="patResults({{$user->regkey}})" value="{{__('title.results_reg')}}" ></input></td>
<!-- <td><a href = "{{url('transactionpatientreg/'.($user->regkey))}}">{{__('title.transaction_patientreg_btn')}}</a></td>
<td><a href = "{{url('testreg/'.($user->regkey)) }}">{{__('title.patienttests_reg')}}</a></td>
<td><a href = "{{url('patientresults/'.($user->regkey)) }}">{{__('title.results_reg')}}</a></td> -->
</tr>
@endforeach
</tbody>
</table>
</div>
</div> 

<script>
function newPatient(){
      window.location = "{{url('newpatientreg')}}";
  }
  function newPatientProfile(){
      window.location = "{{url('newpatientregprofile')}}";
  }
  function editpatient(regkey){
    console.log(regkey);
    window.location = "{{url('editpatientreg/')}}"+'/'+regkey;
}

function payment(regkey){
    console.log(regkey);
    window.location = "{{url('transactionpatientreg/')}}"+'/'+regkey;
}

function patTests(regkey){
    console.log(regkey);
    window.location = "{{url('testreg/')}}"+'/'+regkey;
}

function patResults(regkey){
    console.log(regkey);
    window.location = "{{url('patientresults/')}}"+'/'+regkey;
}
function deletePatient(regkey){
    console.log(regkey);
    var deletepatient = confirm("Want to delete ?");
  if (deletepatient){
    window.location = "{{url('deletepatient/')}}"+'/'+regkey;
}}
</script>

</body>
</form>
</html>