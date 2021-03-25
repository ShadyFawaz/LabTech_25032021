<!DOCTYPE html>   
<html>   
<head>    
<title> LabTech Software (Titles) </title>  
<style>   
Body {  
  font-family:  serif;  
  background-color: lightgrey;  
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
    width: 10%;  
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
    #table-wrapper {
  position:relative;
}
#table-scroll {
  height:390px;
  overflow:auto;  
  margin-top:20px;
}
#table-wrapper table {
  width:50%;

}
#table-wrapper table * {
  background:white;
  color:black;
  font-size: 13px;
  font-weight:bold;
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
@if(Auth::user()->hasPermissionTo(78))
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
    
    <center> <h1> {{__('title.titles_all')}} </h1> </center>   
<div id="table-wrapper">
<div id="table-scroll">
<table id="myTable">
<thead>
<tr>
<td><b> Title ID </b></td>
<td><b> {{__('title.title')}} </b></td>
<td><b> {{__('title.gender')}} </b></td>
</tr>
</thead>
<tbody>
@foreach ($users as $user)
<tr>
<td>{{ $user->title_id }}</td>
<td>{{ $user->title }}</td>
<td>{{ $user->gender }}</td>
@if(!$user->deleted_at)
@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(80))
<td><input type="button" onclick="edittitle({{$user->title_id}})" value="{{__('title.edit_btn')}}" ></input></td>
@endif
@endif
@endif


@if(!$user->deleted_at)
@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(81))
<td><input type="button" onclick="deletetitle({{$user->title_id}})" value="{{__('title.delete_btn')}}" ></input></td>
@endif
@endif
@else
@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(81))
<td><input type="button" onclick="restoretitle({{$user->title_id}})" value="{{__('title.restore_btn')}}" ></input></td>
@endif
@endif
@endif
</tr>
@endforeach
</tbody>
</table>
</div>
</div>
@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(79))
<input type="button" onclick="location.href='{{url('newtitle')}}'" value="{{__('title.create_new_title')}}" ></input>
@endif
@endif
<div>
@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(81))  
<input type="button" onclick="location.href='{{url('trashedtitles')}}'" value="{{__('title.trashed_title')}}" ></input>
@endif
@endif
</body>   

<script>
  function edittitle(title_id){
    console.log(title_id);
    window.location = "{{url('edittitle/')}}"+'/'+title_id;
}
function deletetitle(title_id){
  console.log(title_id);
  var deletetitle = confirm("Want to delete ?");
  if (deletetitle){
    window.location = "{{url('deletetitle/')}}"+'/'+title_id;
  }
}
function restoretitle(title_id){
  var restoretitle = confirm("Want to restore ?");
  if (restoretitle){
    window.location = "{{url('restoretitle/')}}"+'/'+title_id;
  }
}
  </script>
</html>  