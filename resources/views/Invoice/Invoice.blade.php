<!DOCTPE html>
<html>
<head>
<title>LabTech Software (Invoice)</title>
<style>   
Body {  
  font-family:  serif;  
  background-color: lightgrey;  
}  
 
 form {   
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
        font-family:  serif;     
        width: 15%;   
        margin: 0px 0px !important;  
        padding: 2px 0px !important;      
        box-sizing: border-box;   
        text-align: left;
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
    input[type=button] {   
        color:black;   
    }  
        
     
 .container {   
        padding: 0px;  
        margin: 0px 0;  
        background-color: white;  
    }   

    table {
        font:normal 13px/13px  Sans-Serif;
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

#myTable tr.header, #myTable tr:hover {
  background-color: #f1f1f1;
  font-family: serif; 
  margin-bottom: 10px; 
}

</style>  
@if(isset(Auth::user()->login_name))
  @else
  <script>window.location = "{{url('/')}}";</script>
  @endif

@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(134))
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
<center> <h1 > {{__('title.invoice_statistics')}} </h1> </center>   

<form method="post" action="{{url('invoicedata')}}">
            {{method_field('post')}}
            {{csrf_field()}}
            <b><label >{{__('title.datefrom_search')}}  </label>   </b>
            <input type="datetime"  name="datefrom" value="{{Carbon\Carbon::now()->format('Y-m-d\ 00:00')}}"> 
            </div>
            <div >
            <b><label > {{__('title.dateto_search')}}  </label></b>   
            <input type="datetime" name="dateto" value="{{Carbon\Carbon::now()->format('Y-m-d\ 23:59')}}"> 
            </div>
           
            <b><label > {{__('title.doctor_invoice')}}   </label> </b>  
            <select name="doctor">
            <option value="">Choose Doctor</option>
            @foreach($Doctor as $doctor)
               <option value="{{$doctor->doctor_id}}" >{{$doctor->doctor}}</option>
            @endforeach
            </select> 
            </div>

        <b><label >{{__('title.rank_pricelist_invoice')}} </label> </b>  
        <select name="rank_pricelist_id" id="rank_pricelist_id" class="lg dynamic" data-dependent="relative_pricelist_id" data-type="relative_pricelist_name">
        <option value="">Select Price List</option>
        @foreach($RelativePriceLists as $relativepricelist)
        <option value="{{ $relativepricelist->rank_pricelist_id}}">{{ $relativepricelist->rankpricelists->rank_pricelist_name }}</option>
        @endforeach
        </select>
        </div>

        <b><label >{{__('title.relative_pricelist_invoice')}} </label> </b>  
        <select name="relative_pricelist_id" id="relative_pricelist_id" class="lg dynamic" >
        <option value="">Relative Price list</option>
        </select>
        </div>
    </div>

           <div> 
           <input type="submit" name="invoicePatientData" value="{{__('title.invoicedata_btn')}}" >  
           <input type="checkbox" name="PatientLoadInvoice"  >Patient Load</input>  
           <input type="checkbox" name="InsuranceLoadInvoice"  >Insurance Load</input>  

           </div>
           @if(isset(Auth::user()->login_name))   
            @if(Auth::user()->hasPermissionTo(139))
           <input type="submit" name="invoiceTest" value="{{__('title.teststatistics_btn')}}" >  
           @endif
           @endif

           <input type="submit" name="labtolabInvoice" value="{{__('title.labtolabinvoice_btn')}}" >  

           <a><input type="button" onclick="location.href='{{url('invoice')}}'" value="{{__('title.clearall_search_btn')}}" ></input></a>

</form>
<script src="{{asset('JS/jquery-3.5.1.min.js')}}" ></script> 

<script>
$().ready(function(){

 $('.dynamic').change(function(){
  if($(this).val() != '')
  {
   var select    = $(this).attr("id");
   var value     = $(this).val();
   var dependent = $(this).data('dependent');
   var nam       = $(this).data('type');
   console.log(nam);
   console.log(dependent);

   var _token    = $('input[name="_token"]').val();
//    $.ajaxSetup({
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         }   
//     });
   $.ajax({
    url:"{{ route('dynamicdependent.fetch') }}",
    method:"POST",
    data:{select:select, value:value, _token:_token, dependent:dependent ,nam:nam},
    success:function(result)
    {
     $('#'+dependent).html(result);
    }
   })
  }
 });

  $('#pricelist_id').change(function(){
  $('#relative_pricelist_id').val('');
 });
 

});
</script>
</body>
</html>