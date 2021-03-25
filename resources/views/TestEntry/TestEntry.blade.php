<!DOCTPE html>
<html>
<head>
<title>LabTech Software (Results)</title>
<style>   
Body {  
  font-family:  serif;  
  background-color: #495C70;  
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
 form {   
        border: 1px solid #f1f1f1;   
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
        font-weight: bold;

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
        font-family:  serif;  
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
    #table-wrapper {
  position:relative;

}
#table-scroll {
  height:450px;
  overflow:auto;  
  margin-top:20px;

}
#table-wrapper table {
  width:50%;
  font-size:12px;
  font-weight:bold;
  /* margin:auto; */
  line-height:24px;

}
#table-wrapper table * {
  background:white;
  color:black;
  font-weight: bold;
  margin:auto;
  border: none;
}
#table-wrapper table thead th .text {
  position:absolute;   
  top:-20px;
  z-index:2;
  height:20px;
  width:35%;
  /* border:1px solid red; */
  line-height:10px
}
#table-wrapper table  th {
  top:0;
  position: sticky;
  background-color: aqua;
  text-align: center;
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
<center> <h1 > {{__('title.resultsmenu_testentry')}} </h1> </center>   

    {{ method_field('post') }}
    {{ csrf_field() }}
    
<div id="table-wrapper">
<div id="table-scroll">
<table id="myTable">
<thead>
<tr>
<th>{{__('title.visit_no_resultsmenu')}}</th>
<th>{{__('title.patient_name_resultsmenu')}}</th>
<th>{{__('title.group_resultsmenu')}}</th>
<th>{{__('title.meganame_resultsmenu')}}</th>

<th style="background-color:antiquewhite;"></th>
</tr>
</thead>
<tbody>
@foreach ($ResultEntries as $entry)
<tr>

<!-- verified and printed -->
@if(($entry->pr == $entry->regcheck )) 
<td style="background-color:lightgreen;">{{ $entry->visit_no }}</td>

<!-- Not verified and Not printed -->
@elseif(($entry->ver == $entry->regcheck )) 
<td style="background-color:orange;">{{ $entry->visit_no }}</td>

<!-- completed and Not verified -->
@elseif(($entry->comp == $entry->regcheck )) 
<td style="background-color:lightgrey;">{{ $entry->visit_no }}</td>
@else
<td >{{ $entry->visit_no }}</td>
@endif

<td>{{ $entry->patient_name }}</td>
<td>{{ $entry->group }} </td>
<td>{{ $entry->meganame }} </td>

@if($entry->megatest_id)
<td style="background-color:lightskyblue;width:10%;"  ><input   style="background-color: lightskyblue;" type="button" onclick="window.open('{{url('resultentry',[$entry->regkey, $entry->group_id,$entry->megatest_id,$entry->seperate_test])}}')" value="{{__('title.result_entry_resultsmenu')}}" ></input></td>
@else
<td style="background-color:lightskyblue;width:10%;" ><input style="background-color: lightskyblue;" type="button" onclick="window.open('{{url('resultentry',[$entry->regkey, $entry->group_id,$entry->seperate_test])}}')" value="{{__('title.result_entry_resultsmenu')}}" ></input></td>
@endif

</tr>
@endforeach

</tr>
</tbody>
</table>

</body>
</html>