<!DOCTYPE html>   
<html>   
<head>    
<title> LabTech Software (Edit User) </title>  
<style>   
Body {  
  font-family: serif;  
  background-color: lightgrey; 
  /* background-color: RGB(239,228,176);  */
}  

.container {   
        padding: 0px;   
    }   
button {   
        font-family: serif;
        background-color: RGB(70,87,244);   
        width: 8%;  
        color: Black;   
        padding: 5px;   
        border: none;   
        font-weight: bold;
        cursor: pointer;   
         }  
          
 form {   
        border: 1px solid #f1f1f1;   
    }   
 input[type=text] {   
        font-family:  serif;     
        width: 30%;   
        margin: 3px 0px;  
        padding: 8px 5px;   
        font-weight: bold;
        box-sizing: border-box;   
        text-align: left;
    }  
    textarea {   
        font-family: serif;     
        width: 30%;   
        margin: 3px 0px;  
        padding: 8px 5px;   
        box-sizing: border-box;   
        text-align: left;
    }  

    input[type=string] {   
        font-family:  serif;     
        width: 18%;   
        margin: 0px 0px;  
        padding: 2px 0px;      
        box-sizing: border-box;   
        text-align: left;
        font-weight: bold;

    } 

    input[type=integer] {   
        font-family:  serif;     
        width: 18%;   
        margin: 0px 0px;  
        padding: 2px 0px;      
        box-sizing: border-box;   
        text-align: left;
        font-weight: bold;

    } 
    select {   
        font-family:  serif;     
        width: 18%;   
        margin: 0px 0px;  
        padding: 2px 0px;      
        box-sizing: border-box;   
        text-align: left;
        font-weight: bold;

    } 

    label {   
        font-family:  serif;  
        width: 10%;   
        margin: 0px 0;  
        padding: 5px 0px;  
        display: inline-block;   
        border: 2px black;   
        box-sizing: border-box; 
        text-align: left; 
        font-weight: bold;

    }  
 button:hover {   
        opacity: 0.7;   
    }  
    #table-wrapper {
  position:relative;
}
#table-scroll {
  height:250px;
  overflow-y:auto;  
  margin-top:20px;
}
#table-wrapper table {
  width:30%;

}
#table-wrapper table * {
  background:white;
  color:black;
  font-size: 13px;
  font-weight:bold;
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
</style>   
@if(isset(Auth::user()->login_name))
  @else
  <script>window.location = "{{url('/')}}";</script>
  @endif

@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(125))
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
<form onsubmit="return validateForm()" action = "{{url('edituser/'.$users[0]->user_id)}}" method = "post">
    {{ method_field('post') }}
    {{ csrf_field() }}
    <center> <h1 > {{__('title.edit_user')}} </h1> </center>        

<script>
function myFunction1() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput1");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable1");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
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
<script>
function myFunction2() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput2");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable2");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
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
<script>
function myFunction3() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput3");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable3");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
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
            <div >
            <b><label style="color:red;">{{__('title.loginname_newuser')}}  </label></b>   
            <input type="string"  name="login_name" value="{{$users[0]->login_name}}" required>
            </div>
            <div >
            <b><label style="color:red;">{{__('title.username_newuser')}}  </label> </b>  
            <input type="string"  name="user_name" value="{{$users[0]->user_name}}" required> 
            </div>
            <div >
            <b><label style="color:red;">{{__('title.password_newuser')}}  </label> </b>  
            <input  type="password" id="password"  name="password" value="{{$users[0]->password}}" required> 
            
            <b><label style="color:red;">{{__('title.password_conf_users')}}  </label> </b>  
            <input  type="password" id="conf_password"  name="conf_password" value="{{$users[0]->password}}" required> 
            
            </div>
            </table>
            <table >
        <td><b> User Roles </b></td>
        </tr>
        @foreach ($roles as $role)
        <tr>
        <td>{{ $role->name }}</td>
        </tr>
        @endforeach
        </table> 
<br>
  <input type="text" id="myInput1" onkeyup="myFunction1()" placeholder="Search for Screens.." title="Type in a name">
  <button type="submit" class="Update"> <b>{{__('title.update_btn')}}</button></b>   

<div id="table-wrapper" >
<div id="table-scroll">
<table id="myTable1" >
<thead>
<tr>
        <th><b> Screens </b></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($screens as $screen)
        <tr>
        <td > {{ $screen->name }}</td> 
        <td><input  id="id-{{$screen->id}}"  type="checkbox" name="id[{{$screen->id}}]" value="{{ $screen->id}}"  {{ $users[0]->hasPermissionTo($screen->id)? "checked" :""}}></td>
        </tr>
        @endforeach
        </tbody>
</table>
</div>
</div>
<br>

<input type="text" id="myInput2" onkeyup="myFunction2()" placeholder="Search for Permissions.." title="Type in a name">

<div id="table-wrapper" >
<div id="table-scroll">
<table id="myTable2" >
<thead>
<tr>
        <th><b> Permissions </b></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($rights as $right)
        <tr>
        <td > {{ $right->name }}</td> 
        <td><input  id="id-{{$right->id}}"  type="checkbox" name="id[{{$right->id}}]" value="{{ $right->id}}"  {{ $users[0]->hasPermissionTo($right->id)? "checked" :""}}></td>
        </tr>
        @endforeach
        </tbody>
</table>
</div>
</div>
<br>

<input type="text" id="myInput3" onkeyup="myFunction3()" placeholder="Search for Ranks.." title="Type in a name">

<div id="table-wrapper" >
<div id="table-scroll">
<table id="myTable3" >
<thead>
<tr>
        <th><b> Ranks & Relatives </b></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($relPriceLists as $rel)
        <tr>
        <td > {{ $rel->RelativePriceLists->RankPriceLists->rank_pricelist_name }}</td> 
        <td > {{ $rel->RelativePriceLists->relative_pricelist_name }}</td>
        <!-- <td><input  id="rel_id-{{$rel->rel_user_id}}"  type="checkbox" name="rel_id[{{$rel->rel_user_id}}]" value="{{ $rel->relative_pricelist_id}}" {{ $rel->active==1 ? "checked":"" }} ></td> -->
        <td><input  type="checkbox"  name="active[{{$rel->rel_user_id}}]" value="1"  {{ $rel->active==1 ? "checked":"" }} ></td>
        <td><input  hidden  name="rel_user_id[{{$rel->rel_user_id}}]" value=" {{ $rel->rel_user_id }}"  ></td>

        </tr>
        @endforeach
        </tbody>
</table>
</div>
</div>

    </form>     
</body>    
<script src="{{asset('JS/jquery-3.5.1.min.js')}}" ></script> 

<script>


function validateForm() {
var password      = $('#password').val();
var conf_password = $('#conf_password').val();

console.log(password);


 if ( password !== conf_password) {
  alert ("{{__('title.pass_not_match')}}");
return false;
 }
  }
</script>       

</html>  