<!DOCTPE html>
<html>
<head>
<title>LabTech Software (Payment)</title>
<style>   
Body {  
  font-family: serif !important;  
  background-color: lightgrey ;  
}  
input[type=button] {   
        font-family: serif;
        /* width: 20%;   */
        color: Black;   
        padding: 2px;   
        border: none;   
        cursor: pointer; 
        border:double;

         }  
  input[type=submit] {   
font-family: serif;
width: 10%;  
color: Black;   
padding: 5px;   
border: none;   
cursor: pointer; 
line-height: 25px;  
border:double;
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
@include('MainMenu')
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
  @endif
</div>

<center> <h1> Patient Payment </h1> </center>  

<center><table  id="myTable0" border = "1">
<tr class="header">
<th style="color:red;padding: 0px;font-size: 12px;"> Patient ID </th>
<th style="color:red;padding: 0px;font-size: 12px;"> Visit No.</th>
<th style="color:red;padding: 0px;font-size: 12px;"> Patient Name</th>
<th style="color:red;padding: 0px;font-size: 12px;"> Req Date</th>
<th style="color:red;padding: 0px;font-size: 12px;"> Gender</th>
<th style="color:red;padding: 0px;font-size: 12px;"> Age</th>
</tr>
<tr>
<td style="padding: 0px;font-size: 12px;font-weight:bold">{{ $users[0]->PatientReg->patient_id }}</td>
<td style="padding: 0px;font-size: 12px;font-weight:bold">{{ $users[0]->PatientReg->visit_no }}</td>
<td style="padding: 0px;font-size: 12px;font-weight:bold;width:35%">{{ $users[0]->PatientReg->patient_name }}</td>
<td style="padding: 0px;font-size: 12px;font-weight:bold">{{Carbon\Carbon::parse($users[0]->PatientReg->req_date)->format('Y-m-d g:i A')}} </td>
<td style="padding: 0px;font-size: 12px;font-weight:bold">{{ $users[0]->PatientReg->gender }} </td>
<td style="padding: 0px;font-size: 12px;font-weight:bold"> 
@if ($users[0]->PatientReg->age_y > 0)
{{ $users[0]->PatientReg->age_y }} Years
@elseif ( $users[0]->PatientReg->age_y == 0 && $users[0]->PatientReg->age_m > 0 )
{{ $users[0]->PatientReg->age_m }} Months
@elseif ( $users[0]->PatientReg->age_y == 0 && $users[0]->PatientReg->age_m == 0 && $users[0]->PatientReg->age_d > 0 )
{{ $users[0]->PatientReg->age_d }} Days
@endif
</td>
</tr>
</table>




<form action = "{{url('edittransactions/'.($regkey))}}" method = "post">

{{method_field('post')}}
{{csrf_field()}}

<div>
<table style="width:50%">
<tr >
<th style="color:black;"> Total</th>
<th style="color:black;"> Discount %</th>
<th style="color:black;"> Discount (EGP)</th>
<th style="color:black;"> Price After Discount</th>
<th style="color:black;"> Change</th>
</tr>
<tr>
<td><input id="total"  name='total'   disabled    value="{{ $users[0]->PatientReg->TestReg->sum('patient_fees') }}" /></td>
<td><input id='disc'    onchange='discountfn()'      type = 'number'  name = 'disc'   min="0" step="1" value="{{ $users[0]->PatientReg->disc }}"/></td>
<td><input id='discount' onchange='discount2fn()'     type = 'number'  name = 'discount'    min="0" step="1" value="{{ $users[0]->PatientReg->discount }}"/> </td>
<td><input id="priceafterdiscount" name="priceafterdiscount" disabled value="{{ ($users[0]->PatientReg->TestReg->sum('patient_fees'))-($users[0]->PatientReg->discount) }}" /></td>
<td><input id='change' name='change' disabled value="{{ (($users[0]->PatientReg->TestReg->sum('patient_fees'))-($users[0]->PatientReg->discount))-($users->sum('payed')) }}" /></td>

</tr>
</table></center>
<center><input type="button" style="color:black;" onclick="newPayment()" value="New Payment"></a></center>

<div id="table-wrapper">
<div id="table-scroll">
<table id="myTable">
<thead>
<tr>
<th>Payed</th>
<th>Transaction Date</th>
<th>Visa</th>

</tr>
</thead>
<tbody>
@foreach ($users as $user)
<tr>

<td><input style="font-weight:bold;"  id="payed" class="payments"   style="width:200px;" onchange='payedcheck()'  type="number" min="0" step="0.1"  name="payed[{{$user->transaction_id}}]" value="{{ $user->payed }}" {{ $user->user_id? 'readonly' : '' }} required></td>
<td><input style="font-weight:bold;"   readonly="readonly"  style="width:200px;"  type="timestamp" value='{{$user->transaction_date? $user->transaction_date:date("Y-m-d\ H:i:s")}}'   name="transaction_date[{{$user->transaction_id}}]" ></td>
<td><input   type="checkbox"  name="visa[{{$user->transaction_id}}]" value="1"  {{ $user->visa==1 ? "checked":"" }}   ></td>
<td><input id='user_id-{{$user->transaction_id}}' hidden  type="number"   name="user_id-[{{$user->transaction_id}}]" value="{{ $user->user_id }}"  ></td>
<td><input type="button"  onclick="deletetransaction({{$user->transaction_id}})"  value="{{__('title.delete_btn')}}"></td>

</tr>
@endforeach
</tbody>
</table>
</div>
</div>
<center><td><input type="submit" value="Save All"/> </td></center>

<script>
function discountfn(){
    var disc         = $('#disc').val();
    disc             = parseInt(disc);
    var discount     = $('#discount').val();
    var total        = $('#total').val();
    total            = parseInt(total);
    var priceafter   = $('#priceafterdiscount').val();
    priceafter       = parseInt(priceafter);

    var discount   = total*(disc/100) ;
    var priceafter = total - (total*(disc/100));
    var priceafter2 = parseInt(priceafter);

    // var priceafter  = $('#price_after');
    $('#discount').val(discount)
    $('#priceafterdiscount').val(priceafter2)

    console.log(discount);
}
function discount2fn(){
    var disc         = $('#disc').val();
    var discount     = $('#discount').val();
    discount         = parseInt(discount);
    var total        = $('#total').val();
    total            = parseInt(total);
    var priceafter   = $('#priceafterdiscount').val();
    priceafter       = parseInt(priceafter);

    var disc    = (discount/total)*100;
    var priceafter = total - (total*(disc/100));
    var disc2   = parseInt(disc);

    // var priceafter  = $('#price_after');
    $('#disc').val(disc2)
    $('#priceafterdiscount').val(priceafter)

    console.log(disc);
}

function payedcheck(){
  var total     = $('#priceafterdiscount').val();
  total         = parseInt(total);

console.log($('.payments'));

var payed = 0;
$('.payments').each(function(i,payment){
  console.log(payment);
payed = payed + parseInt($(payment).val());
});
console.log(payed);

  console.log(total);
  if (payed > total)
  {
  alert ("{{__('title.payed_alert')}}");
  $('.payments').last().val('')
  }
}

function newPayment(){
      window.location = "{{url('newtransaction/'.($regkey))}}";
  }
  function deletetransaction(transaction_id){
    var UserID = $('#user_id-'+transaction_id).val();

    console.log(UserID);
if(UserID){
  alert ("{{__('title.cannot_delete_saved_transaction')}}");
       event.preventDefault();
       event.stopPropagation();
}else{
  window.location = "{{url('deletetransaction/')}}"+'/'+transaction_id;
}
}
</script>

<script src="{{asset('JS/jquery-3.5.1.min.js')}}" ></script> 

</form>

</body>
</html>