<!DOCTPE html>
<html>
<head>
<title>LabTech Software (Antibiotic Entry)</title>
<style>   
Body {  
  font-family: serif !important;  
  background-color: lightgrey ;  
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
        text-align: center;

    }
    
    select {
      
    width: 100%;  
    margin: 0px 0px;  
    padding: 3px 2px;    
    cursor:pointer;
    display:inline-block;
    position:relative;
    font:normal 12px/12px , Serif;
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
        background-color: #B9CDE5;  
    }   

    #table-wrapper {
  position:relative;
}
#table-scroll {
  height:400px;
  overflow:auto;  
  margin-top:20px;
}
#table-wrapper table {
  width:50%;
margin:auto;
}
#table-wrapper table * {
  background:white;
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
<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous"> -->
<!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> -->

</head>
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

<center> <h1> Antibiotic Entry </h1> </center>   


@if( isset($users) && count($users) > 0 && isset($users[0]) && $users[0] )
<form  action = "{{url('newantibioticentry/'.($users[0]->regkey),($users[0]->culture_link))}}" method = "post">
@endif

<center>
<table  id="myTable0" border = "1">
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
<br>
<center> <b    style="background-color:lightblue;"> {{ $users[0]->CultureLink->culture_name }} </b> </center>   
<br>
           {{method_field('post')}}
           {{csrf_field()}}         
           <select style="width:30%" type="number" name="organism_select" >
                <option value="{{old('organism_select')}}"> Select Organism </option>
                @foreach($Organism as $organism)
                <option value="{{$organism->organism_id}}" {{ old('organism_select') ==$organism->organism_id? "selected":"" }} >{{$organism->organism}}</option>
                @endforeach
                </select>

            <select style="width:15%" type="text" name="sensitivity_select" >
                <option value="{{old('sensitivity_select')}}"> Select Sensitivity </option>
                <option value="Sensitive" {{ old('sensitivity_select') == "Sensitive"? "selected":"" }}>Sensitive</option>
                <option value="Moderately Sensitive" {{ old('sensitivity_select') == "Moderately Sensitive"? "selected":"" }}>Moderately Sensitive</option>
                <option value="Resistant" {{ old('sensitivity_select') == "Resistant"? "selected":"" }}>Resistant</option>           
            </select>

            <select style="width:15%" type="number" name="antibiotic_select" >
                <option value="{{old('antibiotic_select')}}"> Select Antibiotic </option>
                @foreach($Antibiotics as $antibiotic)
                <option value="{{$antibiotic->antibiotic_id}}" {{ old('antibiotic_select') ==$antibiotic->antibiotic_id? "selected":"" }} >{{$antibiotic->antibiotic_name}}</option>
                @endforeach
                </select>
     
                <input type="submit"  value="New Entry" > </input>


                <div id="table-wrapper">
<div id="table-scroll">
<table id="myTable">
<thead>
<tr>
<th>{{__('title.organism')}}</th>
<th>{{__('title.antibiotic_shortcut')}}</th>
<th>{{__('title.sensitivity')}}</th>
</tr>
</thead>
<tbody>
@foreach ($users as $user)
<tr>
<td>{{ $user->organism_id? $user->Organism->organism:"" }}</td>
<td>{{ $user->antibiotic_id? $user->Antibiotics->antibiotic_name:"" }}</td>
<td>{{ $user->sensitivity }}</td>
<td><input type="button" onclick="location.href='{{url('deleteantibioticentry/'.($user->antibioticentry_id))}}'" value="Delete" ></input></td>
</tr>
@endforeach
</tbody>
</table>
</div>
</div>

</form>
</body>

</html>