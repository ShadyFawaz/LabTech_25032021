<!DOCTPE html>
<html>
<head>
<title>LabTech Software</title>
<style>   
Body {  
  font-family: times_new_roman, serif;  
  background-color: #495C70;  
}  
button {   
        font-family: times_new_roman, serif;
        background-color: grey;   
        width: 10%;  
        color: Black;   
        padding: 5px;   
        border: none;   
        cursor: pointer;   
         }   
 form {   
        border: 1px solid #f1f1f1;   
    }   
 input[type=text] {   
        font-family: times_new_roman, serif;     
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
    font:normal 11px/22px times_new_roman, Serif;
    color:black;
    border:1px solid #ccc;
}  

    label {   
        font-family: times_new_roman, serif;  
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

    table {
        font:normal 13px/13px times_new_roman, Serif;
        border-collapse: collapse;
        width: auto;
}
td, th {
  text-align: left;
  padding: 5px;
}
tr:nth-child(even) {
  background-color: white;
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
</head>
@include('MainMenu')
<body>
<center> <h1  style="background-color:DodgerBlue;"> {{__('title.resultsmenu_testentry')}} </h1> </center>   

<center>
<table  id="myTable0" border = "1">
<tr class="header">
<th style="color:red;"> Visit No.</th>
<th style="color:red;"> Patient Name</th>
<th style="color:red;"> Req Date</th>
<th style="color:red;"> Gender</th>
<th style="color:red;"> Age</th>
</tr>
<tr>
<td>{{ $visit_no }}</td>
<td>{{ $patientName }}</td>
<td>{{Carbon\Carbon::parse($reqdate)->format('Y-m-d g:i A')}} </td>
<td>{{ $gender }} </td>
<td>{{ $ag }} / {{ $age }}</td>
</tr>
</table>
</center>

    {{ method_field('post') }}
    {{ csrf_field() }}
    
<table  id="myTable" border = "1">
<tr class="header">
<th>{{__('title.visit_no_resultsmenu')}}</th>
<th>{{__('title.patient_name_resultsmenu')}}</th>
<th>{{__('title.group_resultsmenu')}}</th>
<th>{{__('title.subgroup_resultsmenu')}}</th>

<th></th>
</tr>

@foreach ($ResultEntries as $entry)
<tr>
<td>{{ $entry->PatientReg->visit_no }}</td>
<td>{{ $entry->PatientReg->patient_name }}</td>
<td>{{ $entry->TestData->SubGroups->Groups->group_name }} </td>
<td>{{ $entry->TestData->SubGroups->subgroup_name }}</td>


<!-- <td><a href = "{{url('resultentry/'.($entry->first()->regkey),($entry->first()->TestData->subgroup))}}">{{__('title.result_entry_resultsmenu')}}</a></td> -->
<td><a href="{{url('resultentry',[$entry->regkey, $entry->TestData->subgroup,$entry->seperate_test])}}" >results</a></td>

</tr>
@endforeach
</table>


</body>
</html>