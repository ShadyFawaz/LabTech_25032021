<!DOCTPE html>
<html>
<head>
<title>LabTech Software</title>
<style>   
Body {  
  font-family:  serif;  
  background-color: lightgrey;  
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
        font-family: serif;  
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
        font:normal 15px/15px  Serif;
        border-collapse: collapse;
        width: auto;
}
td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 5px;
}
tr:nth-child(even) {
  background-color: white;
}
#myInput {
  width: 20%;
  font-size: 14px;
  padding: 10px 15px 10px 20px;
  border: 1px solid #ddd;
  margin-bottom: 10px;
}

#myTable tr.header, #myTable tr:hover {
  background-color: #f1f1f1;
  font-family:  serif; 
  margin-bottom: 10px; 
}

</style>  
</head>
@include('MainMenu')
<body>
<center> <h1  style="background-color:DodgerBlue;"> {{__('title.subgroups/group')}} </h1> </center>  
@if( isset($users) && count($users) > 0 && isset($users[0]) && $users[0] )
<center> <b  style="background-color:lightblue;">  {{ $users[0]->groups? $users[0]->Groups->group_name:"" }} </b> </center> 
@endif
@if( isset($users) && count($users) > 0 && isset($users[0]) && $users[0] )
<form action = "{{url('/subgroups/'.$users[0]->group_id)}}" method = "get">
@endif
    {{ method_field('post') }}
    {{ csrf_field() }}
    
<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for subgroups.." title="Type in a name">

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
@if( isset($users) && count($users) > 0 && isset($users[0]) && $users[0] )
<a href="{{url('newgroupsubgroup/'.($users[0]->group_id))}}">{{__('title.create_new_subgroup')}}</a>
@endif
<table  id="myTable" border = "1">
<tr class="header">

<th>{{__('title.subgroup')}}</th>
<th>{{__('title.report_name_subgroup')}}</th>

</tr>
@foreach ($users as $user)
<tr>

<td>{{ $user->subgroup_name }}</td>
<td>{{ $user->report_name }}</td>

<td><a href = "{{url('editsubgroups/'.($user->subgroup_id))}}">{{__('title.subgroup_edit_btn')}}</a></td>
<td><a href = "{{url('subgrouptests/'.($user->subgroup_id))}}">{{__('title.subgroup_tests_btn')}}</a></td>

</tr>
@endforeach
</table>
<a href="{{url('newsubgroups')}}">{{__('title.create_new_subgroup')}}</a>  
</body>
</html>