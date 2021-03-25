<!DOCTPE html>
<html>
<head>
<title>LabTech Software (Lab To Lab Invoice)</title>
<style>   
Body {  
  font-family:  serif;  
  background-color: #495C70 ;  
}  
@media print {
  html, body {
    height: initial !important;
    overflow: initial !important;
    -webkit-print-color-adjust: exact;
  }
  div.divHeader {
    position: fixed;
  }
}

@page {
  size: auto;
  margin: 20mm;
} */
 
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
    }  
 button:hover {   
        opacity: 0.7;   
    }   
    
        
     
 .container {   
        padding: 0px;  
        margin: 0px 0;  
    }   

    table {
        font:normal 13px/13px  Serif;
        border-collapse: collapse;
        width: 80%;
        margin:auto;
}
td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 5px;
  background-color: white;
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
  font-family: times_new_roman, Helvetica, serif; 
  margin-bottom: 10px; 
} */

</style>
<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous"> -->

</head>
@include('MainMenu')
<body>

<center> <h1  > {{__('title.invoice_statistics')}} </h1> </center>   
@if($datefrom && $dateto)
<center> <b1  style="background-color:white;">{{$datefrom}} العينات المرسله خارجيا عن الفتره مــن  </b1> </center> 
<center> <b1  style="background-color:white;margin-right: 140px;" >{{$dateto}} الــى</b1> </center> 
@endif

    {{ method_field('post') }}
    {{ csrf_field() }}
    
</form>
<table  id="myTable" border = "1">
<tr class="header">
<th>Patient ID</th>
<th>Visit No.</th>
<th>Patient Name</th>
<th>Gender</th>
<th>Age</th>
<th>Req Date</th>
<th>Test Name</th>
<th>Lab Name</th>

<th>Patient Load</th>
<th>Fees</th>

<th>Total Fees</th>
</tr>
@foreach ($users as $user)
<tr>
<td>{{ $user->patient_id}}</td>
<td>{{ $user->visit_no }}</td>
<td>{{ $user->patient_name }}</td>
<td>{{ $user->gender }}</td>
<td>{{ $user->age_y }} Y {{ $user->age_m}} M {{ $user->age_d}} D</td>
<td>{{ $user->req_date }} </td>

<td>
  @foreach($user->testregsendout as $test) 
    @if($test->megatest_id)
    {{ $test->megatests->test_name }}
    @endif
    @if($test->grouptest_id)
    {{ $test->GroupTests->test_name }}
    @endif
    @if($test->test_id)
    {{ $test->TestData->abbrev }}
    @endif
  <br>
  @endforeach

<td>
  @foreach($user->testregsendout as $test) 
    {{ $test->OutLabs->out_lab }}
  <br>
  @endforeach
</td>
<td>
  @foreach($user->testregsendout as $test) 
    {{ $test->patient_fees }}
  <br>
  @endforeach
</td>
<td>
  @foreach($user->testregsendout as $test) 
    {{ $test->outlab_fees }}
  <br>
  @endforeach
</td>
<td>
    {{ $user->testregsendout->sum('patient_fees')  -  $user->testregsendout->sum('outlab_fees')}}
  <br>
</td>

</tr>
@endforeach
</table>

<label style="width:15%;background-color:yellow"> Patient Count = {{$patientcount}} </label>
<hr style="border:double;">

 <b style="font-size:12px;"> Printed By : @if(isset(Auth::user()->login_name))
{{ (Auth::user()->user_name) }}
@endif
</b> 
</body>

</html>