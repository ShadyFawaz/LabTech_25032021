<!DOCTPE html>
<html>
<head>
<title>LabTech Software (Test Data)</title>
<style>   
Body {  
  font-family:  sans-serif;  
  background-color: lightgrey;  
}  
  
 form {   
        /* border: 1px solid #f1f1f1;    */
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
    font:normal 11px/22px Serif;
    color:black;
    border:1px solid #ccc;
}  

    label {   
        font-family:  Helvetica, serif;  
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
    }   
    
    #table-wrapper {
  position:relative;
}
#table-scroll {
  height:390px;
  overflow-y:auto;  
  margin-top:20px;
  
}
#table-wrapper table {
  width:auto;
  font-size:12px;
  font-weight:bold;

}
#table-wrapper table * {
  background:white;
  color:black;
}
#table-wrapper table thead th .text {
  top:0;
  z-index:2;
  height:20px;
  width:35%;
  border:1px solid red;
  position: fixed;
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
@if(Auth::user()->hasPermissionTo(57))
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
@if (session('status'))
<div class="alert alert-success" role="alert">
	<button type="button" class="close" data-dismiss="alert">×</button>
	{{ session('status') }}
</div>
@elseif(session('failed'))
<div class="alert alert-danger" role="alert">
	<button type="button" class="close" data-dismiss="alert">×</button>
	{{ session('failed') }}
</div>
@endif
<center> <h1 > {{__('title.testdata_all')}} </h1> </center>   
<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for tests.." title="Type in a name">


<script>
function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
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
<div id="table-wrapper">
  <div id="table-scroll">
  <table id="myTable">
        <thead>
            <tr>
<th style="color:red;"> Test ID</th>
<th style="color:red;" >{{__('title.testdata_shortcut')}}</th>
<th style="color:red;">{{__('title.testdata_reportname')}}</th>
<th style="color:red;">{{__('title.testdata_group')}}</th>
<th style="color:blue;">{{__('title.testdata_profile')}}</th>
<th style="color:blue;">{{__('title.testdata_testheader')}}</th>
<th style="color:blue;">{{__('title.testdata_unit')}}</th>
<th style="color:blue;">{{__('title.testdata_testorder')}}</th>
<th style="color:blue;">{{__('title.testdata_culturelink')}}</th>
<th style="color:red;">{{__('title.testdata_sampletype')}}</th>
<th style="color:red;">{{__('title.testdata_samplecondition')}}</th>
<th style="color:red;">{{__('title.testdata_labunit')}}</th>
<th>{{__('title.testdata_calculated')}}</th>
<th>{{__('title.testdata_testequation')}}</th>
<th>{{__('title.testdata_defaultvalue')}}</th>
<th>{{__('title.testdata_active')}}</th>
<th>{{__('title.outlab_testdata')}}</th>
<th>{{__('title.outlabid_testdata')}}</th>

<th>{{__('title.testdata_assaytime')}}</th>
<th>{{__('title.testdata_edit_btn')}}</th>
<th>{{__('title.testdata_normalranges')}}</th>
<th>{{__('title.testdata_testparameters')}}</th>
</tr>
</thead>
<tbody>
@foreach ($users as $user)
<tr>
<td>{{ $user->test_id }}</td>
<td ondblclick="location.href='{{url('normalranges/'.( $user->test_id ))}}'">{{ $user->abbrev }}</td>
<td>{{ $user->report_name }}</td>
<td>{{ $user->Groups->group_name }}</td>
<td>{{ $user->profile }}</td>
<td>{{ $user->test_header }}</td>
<td>{{ $user->resultsunits? $user->resultsunits->result_unit:"" }}</td>
<td>{{ $user->test_order }}</td>
<td>{{ $user->culturelink? $user->culturelink->culture_name:"" }}</td>
<td>{{ $user->sampletype->sample_type }}</td>
<td>{{ $user->samplecondition->sample_condition }}</td>
<td>{{ $user->labunit->lab_unit }}</td>
<td><input type="checkbox" {{ $user->calculated==1 ? "checked":"" }} disabled ></td>
<td>{{ $user->test_equation }}</td>
<td>{{ $user->default_value }}</td>
<td><input type="checkbox" {{ $user->active==1 ? "checked":"" }} disabled ></td>
<td><input type="checkbox" {{ $user->out_lab==1 ? "checked":"" }} disabled ></td>
<td>{{ $user->outlab_id? $user->OutLabs->out_lab:"" }}</td>

<td>{{ $user->assay_time }} </td>
@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(58))
<td><input type="button" onclick="location.href='{{url('edittestdata/'.( $user->test_id ))}}'" value="{{__('title.edit_btn')}}" ></input></td>
@endif
@endif
<td><input type="button" onclick="location.href='{{url('normalranges/'.( $user->test_id ))}}'" value="{{__('title.testdata_normalranges')}}" ></input></td>
<td><input type="button" onclick="location.href='{{url('testparameters_testdata/'.( $user->test_id ))}}'" value="{{__('title.testdata_testparameters')}}" ></input></td>
</tr>
@endforeach
</tbody>
</table>
</div>
</div>

@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(58))
<td><input type="button" onclick="location.href='{{url('newtestdata')}}'" value="{{__('title.create_new_test')}}" ></input></td>
@endif
@endif
<!-- <script type="text/javascript" src="{{asset('JS/jquery-3.5.1.min.js')}}"></script> 
<script type="text/javascript" src="{{asset('JS/datatables.min.js')}}"></script>
<script>
$(document).ready(function() {
    $('#myTable').DataTable();
} );
</script> -->
</body>
</html>
    