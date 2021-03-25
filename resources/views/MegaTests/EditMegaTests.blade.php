<!DOCTYPE html>   
<html>   
<head>  
<meta name="viewport" content="width=device-width, initial-scale=1">  
<title> LabTech Software (Edit Mega Test)</title>  
<style>   
Body {  
  font-family:  serif;  
  background-color: lightgrey;  
}  
          
 form {   
    }   
 input[type=text] {   
        font-family: serif;     
        width: 30%;   
        margin: 3px 0px;  
        padding: 5px 0px;   
        display: inline-block;   
        border: 2px black;   
        box-sizing: border-box;   
        text-align: left;
    }  
  
    label {   
        font-family:  serif;  
        width: 10%;   
        margin: 0px 0;  
        padding: 3px 0px;  
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
    } 
    #table-wrapper {
  position:relative;
}
#table-scroll {
  height:250px;
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
  /* font-weight:bold; */
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
@if(Auth::user()->hasPermissionTo(63))
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
<form action = "{{url('editmegatests/'.$users[0]->megatest_id)}}" method = "post">
    {{ method_field('post') }}
    {{ csrf_field() }}

  
    <center> <h1> {{__('title.edit_megatest')}} </h1> </center>     
        <div >   
        <b><label style="color:red">{{__('title.megatest_name_new')}} </label>   </b>
            <input type="text"  name="test_name" value = '{{$users[0]->test_name}}' required> 

        <b><label >{{__('title.report_name_megatest')}} </label>   </b>
            <input type="text"  name="report_name" value = '{{$users[0]->report_name}}'> 
            </div>
            <div >
            <input type="checkbox"  name="active"  value="1" {{ $users[0]->active==1 ? "checked":"" }}> 
            <b><label>{{__('title.active_megatest_new')}} </label></b> 

            <input type="checkbox"  name="outlab"value="1" {{ $users[0]->outlab==1 ? "checked":"" }}>
            <b><label>{{__('title.outlab_megatest_new')}}</label>  </b> 

            <b><label>{{__('title.outlabid_megatest')}}  </label> </b>  
            <select name="outlab_id">
            <option value="" ></option>
                @foreach($OutLabs as $outlab)
                <option value="{{$outlab->outlab_id}}" {{ $users[0]->outlab_id==$outlab->outlab_id? "selected" :""}}>{{$outlab->out_lab}}</option>
                @endforeach
            </select> 

            </div>
            <div >
            <b><label>{{__('title.report_type_megatest')}}</label>  </b> 
            <input type="text"  name="report_type" value = '{{$users[0]->report_type}}'>
            </div>
            <div >
            <b><label >{{__('title.test_comment_megatest')}}</label>  </b> 
            <div>
            <textarea style="font-weight:bold;font-size:13px;width:40%;line-height:20px;" name="test_comment" >{{$users[0]->test_comment}}</textarea>
            </div>
</div>

        
            <button type="submit" class="Save"> <b>{{__('title.save_btn')}}</button></b>     
        </div>   
    </form>     
</body>     
</html>  