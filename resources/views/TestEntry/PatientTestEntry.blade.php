<!DOCTPE html>
<html>
<head>
<title>LabTech Software (Patient Results)</title>
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
  height:380px;
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
<center> <h1> {{__('title.resultsmenu_testentry')}} </h1> </center>   

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
<td>
@if ($age_y > 0)
{{ $age_y }} Years
@elseif ( $age_y == 0 && $age_m > 0 )
{{ $age_m }} Months
@elseif ( $age_y == 0 && $age_m == 0 && $age_d > 0 )
{{ $age_d }} Days
@endif
</td>
</tr>
</table>
</center>

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

@foreach ($users as $user)
<tr>
<!-- verified and printed -->
@if(($user->pr == $user->regcheck )) 
<td style="background-color:lightgreen;">{{ $user->visit_no }}</td>

<!-- Not verified and Not printed -->
@elseif(($user->ver == $user->regcheck )) 
<td style="background-color:orange;">{{ $user->visit_no }}</td>

<!-- completed and Not verified -->
@elseif(($user->comp == $user->regcheck )) 
<td style="background-color:lightgrey;">{{ $user->visit_no }}</td>
@else
<td >{{ $user->visit_no }}</td>
@endif

<td>{{ $user->patient_name }}</td>
<td>{{ $user->group }} </td>
<td>{{ $user->meganame }} </td>

@if($user->megatest_id)
<td style="background-color: lightskyblue;width:10%;"><input   style="background-color: lightskyblue;" type="button" onclick="window.open('{{url('resultentry',[$user->regkey, $user->group_id,$user->megatest_id,$user->seperate_test])}}')" value="{{__('title.result_entry_resultsmenu')}}" ></input></td>
@else
<td style="background-color: lightskyblue;width:10%;" ><input style="background-color: lightskyblue;" type="button" onclick="window.open('{{url('resultentry',[$user->regkey, $user->group_id,$user->seperate_test])}}')" value="{{__('title.result_entry_resultsmenu')}}" ></input></td>
@endif
</tr>
@endforeach
</tbody>
</table>


<script>
function PrintAll() {
  var pages =  ["forms/82040PDFCreator.cfm", "forms/poa.cfm", "forms/Billofsalevehicle.cfm"];

  var printNext = function(i) {
    i = i || 0;
    if (i >= pages.length) {
      return;
    }

    var wdw = window.open(pages[i], 'print');
    wdw.onload = function() {
      wdw.print();

      wdw.close();
      setTimeout(function() { 
        printNext(++i);
      }, 100);

    }
  };

  printNext();
}
</script>
</body>
</html>