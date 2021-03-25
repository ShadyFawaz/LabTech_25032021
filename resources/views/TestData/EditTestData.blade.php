<!DOCTYPE html>   
<html>   
<head>    
<title> LabTech Software (Edit Test)</title>  
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
    
</style>  
@if(isset(Auth::user()->login_name))
  @else
  <script>window.location = "{{url('/')}}";</script>
  @endif

@if(isset(Auth::user()->login_name))   
@if(Auth::user()->hasPermissionTo(59))
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
<form action = "{{url('edittestdata/'.$users[0]->test_id)}}" method = "post">
    {{ method_field('post') }}
    {{ csrf_field() }}
    
    <center> <h1 > {{__('title.edit_testdata')}} </h1> </center>   
   
<input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
<div >   
        <b><label style="color:red;">{{__('title.test_shortcut_edit')}} </label>   </b>
        <input type = 'string' name = 'abbrev' value = '{{$users[0]->abbrev}}'/> </td>            
            
            <b><label style="color:red;">{{__('title.testdata_reportname_edit')}} </label></b>   
            <input type = 'string' name = 'report_name' value = '{{$users[0]->report_name}}'/> </td>          
            
            <b><label style="color:red;">{{__('title.testdata_group_edit')}}  </label> </b>  
            <select name="group">
                    @foreach($Groups as $group)
                    <option value="{{$group->group_id}}" {{ $users[0]->test_group==$group->group_id? "selected" :""}}>{{$group->group_name}}</option>
                    @endforeach
            </select> 
            </div>


            <div >
            <b> <label style="color:blue;"> {{__('title.testdata_unit_edit')}} </label>  </b> 
            <select name="unit">
            <option value=""></option>
                    @foreach($ResultsUnits as $resultunit)
                    <option value="{{$resultunit->resultunit_id}}" {{ $users[0]->unit==$resultunit->resultunit_id? "selected" :""}}>{{$resultunit->result_unit}}</option>
                    @endforeach
            </select>  
            


            <b><label style="color:blue;">{{__('title.testdata_culturelink_edit')}} </label> </b>  
            <select name="culture_link">
            <option value=""></option>
                    @foreach($Culturelink as $culturelink)
                    <option value="{{$culturelink->culturelink_id}}" {{ $users[0]->culture_link==$culturelink->culturelink_id? "selected" :""}}>{{$culturelink->culture_name}}</option>
                    @endforeach
            </select> 
            </div>


            <div >
            <b><label style="color:red;">{{__('title.testdata_sampletype_edit')}}  </label></b>   
            <select name="sample_type">
                    @foreach($SampleType as $sampletype)
                    <option value="{{$sampletype->sampletype_id}}" {{ $users[0]->sample_type==$sampletype->sampletype_id? "selected" :""}}>{{$sampletype->sample_type}}</option>
                    @endforeach
            </select> 
            

            <b> <label style="color:red;">{{__('title.testdata_samplecondition_edit')}} </label> </b>  
            <select name="sample_condition">
                    @foreach($SampleCondition as $samplecondition)
                    <option value="{{$samplecondition->samplecondition_id}}" {{ $users[0]->sample_condition==$samplecondition->samplecondition_id? "selected" :""}}>{{$samplecondition->sample_condition}}</option>
                    @endforeach
            </select>
             

            <b><label style="color:red;">{{__('title.testdata_labunit_edit')}}  </label> </b>  
            <select name="lab_unit">
                        @foreach($LabUnit as $labunit)
                        <option value="{{$labunit->labunit_id}}" {{ $users[0]->lab_unit==$labunit->labunit_id? "selected" :""}}>{{$labunit->lab_unit}}</option>
                        @endforeach
            </select> 
            </div>


            <div >
            <b><label style="color:blue;">{{__('title.testdata_profile_edit')}}  </label>  </b> 
            <input type = 'string' name = 'profile' value = '{{$users[0]->profile}}'/>            


            <b><label style="color:blue;">{{__('title.testdata_testheader_edit')}} </label> </b>  
            <input type = 'string' name = 'test_header' value = '{{$users[0]->test_header}}'/>            </div>

            <div >
            <b><label style="color:blue;">{{__('title.testdata_testorder_edit')}} </label>  </b> 
            <input type = 'integer' name = 'test_order' value = '{{$users[0]->test_order}}'/>            </div>

        

            <div >
            <b><label>{{__('title.testdata_defaultvalue_edit')}}  </label> </b>  
            <input type = 'string' name = 'default_value' value = '{{$users[0]->default_value}}'/>            </div>

            <div >
            <b><label style="color:red;"> {{__('title.testdata_assaytime_edit')}} </label> </b>  
            <input type = 'integer' name = 'assay_time' value = '{{$users[0]->assay_time}}'/>            </div>


            <div >
            <input  type="checkbox" value="1" name="active"  {{ $users[0]->active==1 ? "checked":"" }} >
            <b><label> {{__('title.testdata_active_edit')}}  </label> </b>  

            <input  type="checkbox" value="1" name="out_lab"  {{ $users[0]->out_lab==1 ? "checked":"" }} >
            <b><label> {{__('title.outlab_testdata')}}  </label> </b>  
            
            <b><label>{{__('title.outlabid_testdata')}}  </label> </b>  
            <select name="outlab_id">
            <option value="" ></option>
                        @foreach($OutLabs as $outlab)
                        <option value="{{$outlab->outlab_id}}" {{ $users[0]->outlab_id==$outlab->outlab_id? "selected" :""}}>{{$outlab->out_lab}}</option>
                        @endforeach
            </select> 
            
            </div>

            
            <div >
            <input type="checkbox" value="1" name="calculated" {{ $users[0]->calculated==1 ? "checked":"" }} >
            <b><label>{{__('title.testdata_calculated_edit')}}  </label> </b>  
            </div>

            <div >
            <b><label>  {{__('title.testdata_testequation_edit')}}  </label> </b>  
            </div>
            <textarea name = 'test_equation' value = '{{$users[0]->test_equation}}'></textarea>
           </div>
        </div> 
         
<div>
<input type = 'submit' value = "{{__('title.update_testdata_btn')}}" />
<input type="button" value="cancel" onclick="history.back()"/>
</td>
</tr>
</table>
</form>
<!-- <script>
    function back(){
        return redirect('testdataback');
    }
    </script>   -->
<script type="text/javascript" src="{{asset('JS/jquery-3.5.1.min.js')}}"></script> 
<script>
    $(':checkbox[readonly]').click(function(){
        return false;
    });
</script>
</body>
</html>  