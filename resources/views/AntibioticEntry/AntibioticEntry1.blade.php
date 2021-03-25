<!DOCTPE html>
<html>
<head>
<title>LabTech Software</title>
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

    table {
        font: 12px/12px  Serif;
        border-collapse: collapse;
        width: auto;
        margin: 0 auto;
     
}
 th {
   
  border: 1px solid #dddddd;
  text-align: center;
  padding: 3px;
  background-color: white;
}
td {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 3px;
  background-color: white;
}
b {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 5px;
  width: 100px;
  background-color:white;
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
  @if (session('organism_select'))
<div class="alert alert-success" role="alert">
	<button type="button" class="close" data-dismiss="alert">×</button>
	{{ session('organism_select') }}
</div>
@endif
<center> <h1  style="background-color:DodgerBlue;"> Antibiotic Entry </h1> </center>   
<!-- <center><input type="button" style="color:black;" onclick="newAntibioticEntry()" value="Add New Antibiotic"></a></center> -->

@if( isset($users) && count($users) > 0 && isset($users[0]) && $users[0] )
<form name="myForm" onsubmit="return validateForm()" action = "{{url('submitantibioticentry/'.($users[0]->regkey),($users[0]->culture_link))}}" method = "post">
@endif
{{method_field('post')}}
{{csrf_field()}}

<!-- <center><td><input type="submit" value="Save All"/> </td></center> -->
          <div> 
           <center><input id="" type="submit" name="newEntry" value="New Entry" ></center>
           </div>
           <center><input id="SaveAll" type="submit" name="SaveAll" value="Save" > </center>
           <div>
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

            <select style="width:20%" type="number" name="antibiotic_select" >
                <option value="{{old('antibiotic_select')}}"> Select Antibiotic </option>
                @foreach($Antibiotics as $antibiotic)
                <option value="{{$antibiotic->antibiotic_id}}" {{ old('antibiotic_select') ==$antibiotic->antibiotic_id? "selected":"" }} >{{$antibiotic->antibiotic_name}}</option>
                @endforeach
                </select>
           </div>

<table  id="myTable" border = "1">
<tr class="header">
<th>Organism</th>
<th>Antibiotic</th>
<th>Sensitivity</th>
</tr>
@foreach ($users as $user)
<tr>
<td><select type="number" name="organism_id[{{$user->antibioticentry_id}}]" required>
<option value=""></option>
  @foreach($Organism as $organism)
      <option value="{{$organism->organism_id}}" {{ $user->organism_id==$organism->organism_id? "selected":"" }}>{{$organism->organism}}</option>
      @endforeach
    </select>
</td>

<td><select type="number" name="antibiotic_id[{{$user->antibioticentry_id}}]" >
<option value="{{old ('organic_select')}}"></option>
      @foreach($Antibiotics as $antibiotic)
          <option value="{{$antibiotic->antibiotic_id}}" {{ $user->antibiotic_id==$antibiotic->antibiotic_id? "selected":"" }}>{{$antibiotic->antibiotic_name}}</option>
          @endforeach
      </select>
</td>

<td><select type="string" name="sensitivity[{{$user->antibioticentry_id}}]" >
      <option value=""></option>
      <option value="Sensitive" {{ $user->sensitivity=="Sensitive"? "selected":"" }}>Sensitive</option>
      <option value="Moderately Sensitive" {{ $user->sensitivity=="Moderately Sensitive"? "selected":"" }}>Moderately Sensitive</option>
      <option value="Resistant" {{ $user->sensitivity=="Resistant"? "selected":"" }}>Resistant</option>
  </select>
</td>
<td><a href = "{{url('deleteantibioticentry/'.($user->antibioticentry_id))}}">Delete</a></td>
<td><input type="button" onclick="location.href='{{url('deleteantibioticentry/'.($user->antibioticentry_id))}}'" value="Delete" ></input></td>

</tr>


@endforeach
</table>
</form>
<!-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>  -->


</body>
<script>
function newAntibioticEntry(){
      window.location = "{{url('newantibioticentry/'.$regkey,$culture_link)}}";
      // {{url('newantibioticentry/'.$regkey,$culture_link)}}
  }

//   function validateForm(){
//   var OrganismSelect = document.forms["myForm"]["organism_select"].value;
//   var NewEntry       = document.forms["myForm"]["newEntry"].value;
//   var newentry       = document.getElementById(""); 
//   var saveAll        = document.forms["myForm"]["SaveAll"].value;

// var checking  = saveAll + OrganismSelect + NewEntry
//     console.log(OrganismSelect);

//   if (checking == 'SaveNew Entry' )
//   {
//     alert ('Please Select Organism');
//   return false;
//   }
//   }

</script>
</html>