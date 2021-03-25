<!DOCTPE html>
<html>
<head>
<title>LabTech Software</title>
<style>   
Body {  
  font-family: times_new_roman, serif;  
  background-color: #495C70;  
}  
input[type=button] {   
        font-family: times_new_roman, serif;
        background-color: #e7e7e7;   
        width: auto;  
        color: Black;   
        padding: 2px;   
        border: none; 
        font-weight: bold;
        font-size: 12px; 
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
        font-weight: bold;

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
        font-weight: bold;

    }  
    input[type=button]:hover {   
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
        font-weight: bold;

}
td, th {
  text-align: left;
  padding: 5px;
  font-weight: bold;

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
<td>{{ $entry->first()->PatientReg->visit_no }}</td>
<td>{{ $entry->first()->TestData->SubGroups->Groups->group_name }} </td>
<td>{{ $entry->first()->TestData->SubGroups->subgroup_name }}</td>


<td><a href = "{{url('resultentry/'.($entry->first()->regkey),($entry->first()->TestData->subgroup),($entry->first()->seperate_test))}}">{{__('title.result_entry_resultsmenu')}}</a></td>
<td><input type="button" onclick="location.href='{{url('resultentry/'.($entry->first()->regkey),($entry->first()->TestData->first()->subgroup))}}'" value="{{__('title.result_entry_resultsmenu')}}" ></input></td>
<td><a href="{{url('resultentry',[$entry->first()->regkey, $entry->first()->TestData->subgroup,$entry->first()->seperate_test])}}" >results</a></td>

</tr>
@endforeach
</table>
</body>
</html>