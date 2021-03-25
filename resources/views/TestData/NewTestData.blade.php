<!DOCTYPE html>   
<html>   
<head>  
<title> LabTech Software (New Test) </title>  
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
        font-family:  serif;
        background-color: RGB(70,87,244);   
        width: 8%;  
        color: Black;   
        padding: 5px;   
        border: none;   
        cursor: pointer; 
        font-weight:bold;
  
         }  
  
 input[type=text] {   
        font-family: serif;     
        width: 30%;   
        margin: 3px 0px;  
        padding: 8px 5px;   
        font-weight:bold;

        box-sizing: border-box;   
        text-align: left;
    }  
    textarea {   
        font-family: serif;     
        width: 30%;   
        margin: 3px 0px;  
        padding: 8px 5px;   
        font-weight:bold;

        box-sizing: border-box;   
        text-align: left;
    }  

    input[type=string] {   
        font-family: serif;     
        width: 18%;   
        margin: 0px 0px;  
        padding: 2px 0px;      
        box-sizing: border-box;   
        text-align: left;
        font-weight:bold;

    } 

    input[type=integer] {   
        font-family: serif;     
        width: 18%;   
        margin: 0px 0px;  
        padding: 2px 0px;      
        box-sizing: border-box;   
        text-align: left;
        font-weight:bold;

    } 
    select {   
        font-family: serif;     
        width: 18%;   
        margin: 0px 0px;  
        padding: 2px 0px;      
        box-sizing: border-box;   
        text-align: left;
        font-weight:bold;
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
        font-weight:bold;

    }  
 button:hover {   
        opacity: 0.7;   
    }
    input[type=button] {   
        color:black;   
    }    
    
</style>   
@if(isset(Auth::user()->login_name))
  @else
  <script>window.location = "{{url('/')}}";</script>
  @endif

@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(58))
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
<form onKeydown="return event.key !='Enter'" action = "{{url('newtestdatacreate')}}" method = "post">
    {{ method_field('post') }}
    {{ csrf_field() }}
	<table>
	<tr>     
    <center> <h1 > {{__('title.create_new_test')}} </h1> </center>   
        <div >   
        <b><label style="color:red;">{{__('title.test_shortcut_new')}} </label>   </b>
            <input type="string"  name="abbrev" required> 
            
            
            <b><label style="color:red;">{{__('title.testdata_reportname_new')}} </label></b>   
            <input type="string"  name="report_name" required> 
          


            
            <b><label style="color:red;">{{__('title.testdata_group_new')}}  </label> </b>  
            <select name="group">
            <option value=""></option>
            @foreach($Groups as $group)
               <option value="{{$group->group_id}}">{{$group->group_name}}</option>
            @endforeach
            </select> 
            </div>


            <div >
            <b> <label style="color:blue;"> {{__('title.testdata_unit_new')}} </label>  </b> 
            <select name="unit">
            <option value=""></option>
            @foreach($ResultsUnits as $resultunit)
               <option value="{{$resultunit->resultunit_id}}">{{$resultunit->result_unit}}</option>
            @endforeach
            </select>  
            


            <b><label style="color:blue;">{{__('title.testdata_culturelink_new')}} </label> </b>  
            <select name="culture_link">
            <option value=""></option>
            @foreach($Culturelink as $culturelink)
               <option value="{{$culturelink->culturelink_id}}">{{$culturelink->culture_name}}</option>
            @endforeach
            </select> 
            </div>


            <div>
            <b><label style="color:red;">{{__('title.testdata_sampletype_new')}}  </label></b>   
            <select name="sample_type" required>
            <option value=""></option>
            @foreach($SampleType as $sampletype)
               <option value="{{$sampletype->sampletype_id}}">{{$sampletype->sample_type}}</option>
            @endforeach
            </select> 
            

            <b> <label style="color:red;">{{__('title.testdata_samplecondition_new')}} </label> </b>  
            <select name="sample_condition" required>
            <option value=""></option>
            @foreach($SampleCondition as $samplecondition)
               <option value="{{$samplecondition->samplecondition_id}}">{{$samplecondition->sample_condition}}</option>
            @endforeach
            </select> 
             

            <b><label style="color:red;">{{__('title.testdata_labunit_new')}}  </label> </b>  
            <select name="lab_unit" required>
            <option value=""></option>
            @foreach($LabUnit as $labunit)
               <option value="{{$labunit->labunit_id}}">{{$labunit->lab_unit}}</option>
            @endforeach
            </select> 
            </div>


            <div >
            <b><label style="color:blue;">{{__('title.testdata_profile_new')}}  </label>  </b> 
            <input type="string"  name="profile" >
        

            <b><label style="color:blue;">{{__('title.testdata_testheader_new')}} </label> </b>  
            <input type="string"  name="test_header" >

           
            </div>
            <b><label style="color:blue;">{{__('title.testdata_testorder_new')}} </label>  </b> 
            <input type="integer"  name="test_order" >
            <div >
         
            </div>


            <div >
            <b><label>{{__('title.testdata_defaultvalue_new')}}  </label> </b>  
            <input type="string"  name="default_value" >
            </div>

            <div >
            <b><label style="color:red;"> {{__('title.testdata_assaytime_new')}} </label> </b>  
            <input type="integer"  name="assay_time" required >
            </div>


            <div >
            <input type="checkbox"  name="active" value="1" >
            <b><label> {{__('title.testdata_active_new')}}  </label> </b>  

            <input type="checkbox"  name="out_lab" value="1" >
            <b><label> {{__('title.outlab_testdata')}}  </label> </b>  

            <b><label>{{__('title.outlabid_testdata')}}  </label> </b>  
            <select name="outlab_id">
            <option value="" ></option>
                        @foreach($OutLabs as $outlab)
                        <option value="{{$outlab->outlab_id}}">{{$outlab->out_lab}}</option>
                        @endforeach
            </select> 

            </div>

            
            <div>
            <input type="checkbox"  name="calculated" value="1"  >
            <b><label>{{__('title.testdata_calculated_new')}}  </label> </b>  
            </div>

            <div >
            <b><label>  {{__('title.testdata_testequation_new')}}  </label> </b>  
            </div>
            <textarea   name="test_equation" > </textarea>
           </div>


            <div>
            <button type="submit" class="NewTest"> <b>{{__('title.new_testdata_btn')}}</button></b>     
            <button type="button" class="cancelbtn"> <b>{{__('title.cancel_btn')}}</button></b>
        </div>   
    </form>     
</body>     
</html>  