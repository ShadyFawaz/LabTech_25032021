<!DOCTPE html>
<html>
<head>
<title>LabTech Software (ٌReceipt)</title>
<style>   
Body {  
  font-family: serif !important;  
  background-color: white !important ;  
  margin: 0;
}  
button {   
        font-family: serif;
        background-color: grey;   
        width: 10%;  
        color: Black;   
        padding: 5px;   
        border: none;   
        cursor: pointer;   
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
        text-align: center;

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
        font-family: tserif;  
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
        background-color: #B9CDE5;  
    }   

    #table-wrapper {
  position:relative;
}
#table-scroll {
  height:200px;
  overflow:auto;  
  margin-top:20px;
}
#table-wrapper table {
  width:30%;
margin:auto;
}
#table-wrapper table * {
  /* background:white; */
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
<body >

<hr style="border:double;">

<center> <b> Cairo 2000 Labs </b> </center>  
<center> <b> Receipt </b> </center>  
<hr style="border:double;">


<center><table  id="myTable0" border = "1" style="border:black;">

<tr class="header">

<th style="color:red;padding: 0px;font-size: 12px;"> Patient Name</th>
<th style="color:red;padding: 0px;font-size: 12px;"> Req Date</th>
<th style="color:red;padding: 0px;font-size: 12px;"> Age</th>
<th style="color:red;padding: 0px;font-size: 12px;"> Refered By</th>
<th style="color:red;padding: 0px;font-size: 12px;"> Contract</th>
<th style="color:red;padding: 0px;font-size: 12px;"> Relative</th>

</tr>
<tr>

<td style="padding: 0px;font-size: 12px;font-weight:bold;width:35%">{{$patients[0]->title_id? $patients[0]->Titles->title." / ":"" }} {{ $patients[0]->patient_name }}</td>
<td style="padding: 0px;font-size: 12px;font-weight:bold">{{Carbon\Carbon::parse($patients[0]->req_date)->format('Y-m-d g:i A')}} </td>
<td style="padding: 0px;font-size: 12px;font-weight:bold"> 
@if ($patients[0]->age_y > 0)
{{ $patients[0]->age_y }} / Years
@elseif ( $patients[0]->age_y == 0 && $patients[0]->age_m > 0 )
{{ $patients[0]->age_m }} / Months
@elseif ( $patients[0]->age_y == 0 && $patients[0]->age_m == 0 && $patients[0]->age_d > 0 )
{{ $patients[0]->age_d }} / Days
@endif
</td>
@if($patients[0]->gender == "Male")
<td style="padding: 0px;font-size: 12px;font-weight:bold">{{ $patients[0]->doctor_id? $patients[0]->doctor->doctor:"Himself"  }} </td>
@endif
@if($patients[0]->gender == "Female")
<td style="padding: 0px;font-size: 12px;font-weight:bold">{{ $patients[0]->doctor_id? $patients[0]->doctor->doctor:"Herself"  }} </td>
@endif

<td style="padding: 0px;font-size: 12px;font-weight:bold">{{ $patients[0]->rankpricelists->rank_pricelist_name }} </td>
<td style="padding: 0px;font-size: 12px;font-weight:bold">{{ $patients[0]->relativepricelists->relative_pricelist_name }} </td>
</tr>
</table>

<div>
<center> <b style="text-decoration:underline;background-color:lightgrey;"> Requested Tests : </b> </center>  

<table style="width:50%">
<tr >
<!-- <th style="color:black;"> Test Name</th> -->
</tr>
<tr>
@foreach($TestReg as $test)
@if($test->megatest_id)
<td style="color:black;font-size:11px;font-weight:bold;">{{$test->MegaTests->test_name}}</td>
@endif
@if($test->grouptest_id)
<td style="color:black;font-size:11px;font-weight:bold;"> {{$test->GroupTests->test_name}}</td>
@endif
@if($test->test_id)
<td style="color:black;font-size:11px;font-weight:bold;">{{$test->TestData->abbrev}}</td>
@endif

</tr>
@endforeach
</table>
</div>

<div>
<table id="myTable0" border = "1" style="border:black;">
<tr >
<th style="font-size:14px;font-weight:bold;"> Total Required</th>
<th style="font-size:14px;font-weight:bold;"> Discount %</th>
<th style="font-size:14px;font-weight:bold;"> Discount (EGP)</th>
<th style="font-size:14px;font-weight:bold;"> Total After Discount</th>
<th style="font-size:14px;font-weight:bold;"> Payed</th>
<th style="font-size:14px;font-weight:bold;"> Change</th>
</tr>
<tr>
<td style="color:black;font-size:12px;font-weight:bold;">{{ $total }}</td>
<td style="color:black;font-size:12px;font-weight:bold;">{{ $users[0]->PatientReg->disc }}</td>
<td style="color:black;font-size:12px;font-weight:bold;">{{ $users[0]->PatientReg->discount }}</td>
<td style="color:black;font-size:12px;font-weight:bold;">{{ $priceafter}}</td>
<td style="color:black;font-size:12px;font-weight:bold;">{{ $payed}}</td>

@if ($change > 0)
<td style="color:black;font-size:12px;font-weight:bold;background-color:red;">
{{ $change }}
</td>
@endif
@if ($change == 0)
<td style="color:black;font-size:12px;font-weight:bold;">
{{ $change }}
</td>
@endif
</tr>
</table>
</center>
<hr style="border:double;">

<center> <b style="color:white;font-size:16px;font-weight:bold;background-color:black;"> برجاء الاحتفاظ بالايصال لحين استلام النتيجه </b> </center>  

<hr style="border:double;">


<center> <b style="font-size:12px;"> Website : www.cairo2000labs.com </b> </center>  
<center> <b style="font-size:12px;"> Facebook : Cairo2000Labs </b> </center>  
<center> <b style="font-size:12px;"> فرع المقطم : عيادات شارع 9 بالمقطم امام مسجد القدس </b> </center>  
<center> <b style="font-size:12px;"> Tel : 01028787266 / 0228462120 </b> </center>  

<center> <b style="font-size:12px;">فرع شبين القناطر : برج 6 اكتوبر امام محطه السكه الحديد </b> </center>  
<center> <b style="font-size:12px;"> Tel : 0132724411 / 01018122637 </b> </center>  
<center> <b style="font-size:12px;"> مواعيد العمل بجميع الفروع من العاشره صباحا حتى العاشره مساء عدا الجمعه </b> </center>  
<center> <b style="font-size:12px;"> فرع المقطم فى خدمتكم على مدار 24 ساعه طوال الاسبوع </b> </center>  
<hr style="border:double;">

 <b style="font-size:12px;"> Printed By : @if(isset(Auth::user()->login_name))
{{ (Auth::user()->user_name) }}
@endif
</b> 
</form>

</body>
</html>