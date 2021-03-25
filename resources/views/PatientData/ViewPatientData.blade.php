<!DOCTPE html>
<html>
<head>
<title>LabTech Software (Patient Data)</title>
<style>   
Body {  
  font-family:  serif;  
  background-color: lightgrey;
  /* background-color: rgb(135,135,135);   */
}  
  
 form {   
        border: 1px solid #f1f1f1;  
         
    }   
 input[type=text] {   
        font-family: serif;     
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
    font:normal 11px/22px  Serif;
    color:black;
    border:1px solid #ccc;
}  

    label {   
        font-family: serif;  
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
  width:100% ;
  font-size:12px;
  font-weight:bold;
  /* margin:auto; */
  line-height:24px;
}
#table-wrapper table * {
  background:white;
  color:black;
  font-size: 13px;
  /* font-weight:bold; */
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
  font-family: times_new_roman, Helvetica, sans-serif; 
  margin-bottom: 10px; 
} */

</style>  
@if(isset(Auth::user()->login_name))
  @else
  <script>window.location = "{{url('/')}}";</script>
  @endif

@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(87))
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
<center> <h1 > {{__('title.patient_data_all')}} </h1> </center>   
<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names.." title="Type in a name">


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
<a><input type="button" onclick="location.href='{{url('newpatientdata')}}'" value="{{__('title.create_new_patient_data')}}" ></input></a>

<div id="table-wrapper">
<div id="table-scroll">
<table id="myTable">
    <thead>
        <tr>
<th>{{__('title.patient_code')}}</th>
<th>{{__('title.patient_id_patientdata')}}</th>
<th>{{__('title.title_patientdata')}}</th>
<th>{{__('title.patient_name_patientdata')}}</th>
<th>{{__('title.gender_patientdata')}}</th>
<th>{{__('title.dob_patientdata')}}</th>

<th>{{__('title.phone_number_patientdata')}}</th>
<th>{{__('title.address_patientdata')}}</th>
<th>{{__('title.email_patientdata')}}</th>
<th>{{__('title.website_patientdata')}}</th>
<th>{{__('title.country_patientdata')}}</th>
<th>{{__('title.nationality_patientdata')}}</th>
</tr>
</thead>
<tbody>
@foreach ($users as $user)
<tr>
<td>{{ $user->patient_code }}</td>
<td>{{ $user->Patient_ID }}</td>
<td>{{ $user->Title_id? $user->title->title:"" }}</td>
<td>{{ $user->patient_name }}</td>
<td>{{ $user->Gender }}</td>
<td>{{ $user->DOB }}</td>
<td>{{ $user->phone_number }}</td>
<td>{{ $user->Address }}</td>
<td>{{ $user->Email }}</td>
<td>{{ $user->Website }}</td>
<td>{{ $user->Country }}</td>
<td>{{ $user->Nationality }}</td>

@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(88))
<td><input type="button" onclick="editpatientdata({{$user->patient_code}})" value="{{__('title.edit_btn')}}" ></input></td>
@endif
@endif
<td><input type="button" onclick="newvisit({{$user->Patient_ID}})" value="{{__('title.new_visit')}}" ></input></td>

</tr>
@endforeach
</tbody>
</table>
</div>
</div> 


</body>
<script>
  function editpatientdata(patient_code){
    console.log(patient_code);
    window.location = "{{url('editpatientdata/')}}"+'/'+patient_code;
}
  function newvisit(Patient_ID){
    console.log(Patient_ID);
    window.location = "{{url('newpatientreg/')}}"+'/'+Patient_ID;
}
</script> 

</html>