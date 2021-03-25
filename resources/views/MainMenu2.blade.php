<html>
<style>
.navbar {background-color: #4FA0D8;}
.parent {z-index: 5000;display: block; width: 10%;position: relative;float: left;line-height: 30px;background-color: #4FA0D8;border-right:#CCC 1px solid;}
.parent a{margin: 10px;color: #FFFFFF;text-decoration: none;}
.parent:hover > ul {background-color: red;display:block;position:absolute;}
.child {display: none;}
.child li {z-index: 5000;background-color: #E4EFF7;line-height: 30px;border-bottom:#CCC 1px solid;border-right:#CCC 1px solid; width:120%;}
.child li a{color: #000000; }
ul{list-style: none; margin: 0;padding: 0px; min-width:10em;}
ul ul ul{z-index: 5000;left: 100%;top: 0;margin-left:1px;}
li:hover {background-color: red;}
.parent li:hover {background-color: blue;}
.expand{font-size:12px;float:right;margin-right:5px;}

body {
  font-family: serif;
  background-color:  RGB(155,155,255);

  /* background-color: lightgrey; */
}

.navbar {
  padding: 0px 0px;
  font-size: 8px;
  font-weight:bold;
  overflow: hidden;
  background-color: #333;
  margin: 0x;
  padding: 0x;
}

.navbar a { 
   font-weight:bold;
  font-size: 14px;
  float: left;
  color: white;
  text-align: center;
  padding: 14px 12px;
  text-decoration: none;
  margin: 0x;
  padding: 0x;
}

.dropdown {
  font-size: 14px;
  font-weight:bold;

  float: left;
  overflow: hidden;
  margin: 0x;
  padding: 0x;
}

.dropdown .dropbtn {
  font-weight:bold;

  font-size: 14px;  
  border: none;
  outline: none;
  color: white;
  padding: 14px 10px;
  background-color: inherit;
  font-family: inherit;
  margin: 0x;
  padding: 0x;
  width: auto;
}

.navbar a:hover, .dropdown:hover .dropbtn {
  background-color: red;
}

.dropdown-content {
  font-size: 14px;
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
  margin: 0x;
}

.dropdown-content a {
  font-size: 12px;
  float: none;
  color: black;
  padding: 8px 8px;
  text-decoration: none;
  display: block;
  text-align: left;
  margin: 0x;
}

.dropdown-content a:hover {
  background-color: blue;
}
.content {
   text-align: center;
   font-family:  Helvetica, sans-serif;
   margin: 5x;
   font-size: 48px;
}

.dropdown:hover .dropdown-content {
  display: block;
}

img {
  border-radius: 8px;
}
</style>
<head>
<ul id="menu">

  <li class="parent" onclick="location.href='{{url('home')}}'" ><a href="{{url('home')}}">{{__('title.home_page')}}</a>
	<li class="parent" onclick="location.href='{{url('patientreg')}}'" ><a href="{{url('patientreg')}}">{{__('title.patient_reg_list')}}</a>

  <li class="parent"><a href="#">{{__('title.reg_menus')}}</a>
	<ul class="child">
		<li class="parent" onclick="location.href='{{url('newpatientreg')}}'" ><a href="{{url('newpatientreg')}}">{{__('title.newpatientreg')}}</a></li>
		<li class="parent" onclick="location.href='{{url('newpatientregprofile')}}'" ><a href="{{url('newpatientregprofile')}}"> {{__('title.newpatientregprofile')}}</a></li>
	</ul>
	</li>

	<li class="parent"><a href="#">{{__('title.system_setup')}}</a>
	<ul class="child">			
		<li class="parent"><a href="#">{{__('title.culture_setup')}}<span class="expand">&raquo;</span></a>
			<ul class="child">
			<li onclick="location.href='{{url('antibiotics')}}'" ><a href="{{url('antibiotics')}}" nowrap>{{__('title.antibiotics')}}</a></li>
			<li onclick="location.href='{{url('organism')}}'" ><a href="{{url('organism')}}" nowrap>{{__('title.organisms_mainmenu')}}</a></li>
      <li onclick="location.href='{{url('culturelink')}}'" ><a href="{{url('culturelink')}}" nowrap>{{__('title.culture_link')}}</a></li>
			</ul>
		</li>

    <li class="parent"><a href="#">{{__('title.test_setup')}}<span class="expand">&raquo;</span></a>
			<ul class="child">
			<li onclick="location.href='{{url('testdata')}}'" ><a href="{{url('testdata')}}" nowrap>{{__('title.test_data')}}</a></li>
			<li onclick="location.href='{{url('grouptests')}}'" ><a href="{{url('grouptests')}}" nowrap>{{__('title.group_tests')}}</a></li>
      <li onclick="location.href='{{url('megatests')}}'" ><a href="{{url('megatests')}}" nowrap>{{__('title.mega_tests')}}</a></li>
      <li onclick="location.href='{{url('profiles')}}'" ><a href="{{url('profiles')}}" nowrap>{{__('title.test_profile')}}</a></li>
			</ul>
		</li>
    <li class="parent"><a href="#">{{__('title.labtolab_setup')}}<span class="expand">&raquo;</span></a>
			<ul class="child">
			<li onclick="location.href='{{url('outlabs')}}'" ><a href="{{url('outlabs')}}" nowrap>{{__('title.out_labs_mainmenu')}}</a></li>
			</ul>
		</li>

      <li class="parent"><a href="#">{{__('title.regmenus_setup')}}<span class="expand">&raquo;</span></a>
			<ul class="child">
			<li onclick="location.href='{{url('doctor')}}'" ><a href="{{url('doctor')}}" nowrap>{{__('title.doctors')}}</a></li>
			<li onclick="location.href='{{url('diagnosis')}}'" ><a href="{{url('diagnosis')}}" nowrap>{{__('title.diagnosis')}}</a></li>
      <li onclick="location.href='{{url('titles')}}'" ><a href="{{url('titles')}}" nowrap>{{__('title.titles_mainmenu')}}</a></li>
      <li onclick="location.href='{{url('patientcondition')}}'" ><a href="{{url('patientcondition')}}" nowrap>{{__('title.patient_condition_mainmenu')}}</a></li>
			</ul>
		</li>

      <li class="parent"><a href="#">{{__('title.general_setup')}}<span class="expand">&raquo;</span></a>
			<ul class="child">
			<li onclick="location.href='{{url('viewpatientdata')}}'" ><a nowrap>{{__('title.patient_data_mainmenu')}}</a></li>
			<li onclick="location.href='{{url('groups')}}'" ><a href="{{url('groups')}}" nowrap>{{__('title.groups')}}</a></li>
      <li onclick="location.href='{{url('resultsunits')}}'" ><a href="{{url('resultsunits')}}" nowrap>{{__('title.results_units_mainmenu')}}</a></li>
      <li onclick="location.href='{{url('labunit')}}'" ><a href="{{url('labunit')}}" nowrap>{{__('title.lab_units')}}</a></li>
      <li onclick="location.href='{{url('sampletype')}}'" ><a href="{{url('sampletype')}}" nowrap>{{__('title.sample_type_mainmenu')}}</a></li>
      <li onclick="location.href='{{url('samplecondition')}}'" ><a href="{{url('samplecondition')}}" nowrap>{{__('title.sample_condition_mainmenu')}}</a></li>
      <li onclick="location.href='{{url('country')}}'" ><a href="{{url('country')}}" nowrap>{{__('title.country_mainmenu')}}</a></li>

      
			</ul>
		</li>
    	</ul>
	</li>
	<li class="parent"><a href="#">{{__('title.financial')}}</a>
	<ul class="child">			
		<li onclick="location.href='{{url('invoice')}}'" ><a href="{{url('invoice')}}"> {{__('title.invoice')}}</a></li></li>
		<li onclick="location.href='{{url('pricelists')}}'" ><a href="{{url('pricelists')}}"> {{__('title.price_lists')}}</a></li>
		<li onclick="location.href='{{url('rankpricelists')}}'" ><a href="{{url('rankpricelists')}}"> {{__('title.price_lists_reg')}}</a></li>
	</ul>
	</li>

  <li class="parent"><a href="#">{{__('title.results_mainmenu')}}</a>
	<ul class="child">			
		<li onclick="location.href='{{url('searchresultsbyday')}}'"><a href="searchresultsbyday"> {{__('title.resultsbyday_mainmenu')}}</a></li></li>
	</ul>
	</li>
	<li class="parent"><a href="#"></a>
	<li class="parent"><a href="#"></a>
	<li class="parent"><a href="#"></a>

@if (app()->getLocale() == 'en')
<li class="parent" style="width:9%" onclick="location.href='{{url('change-language/ar')}}'" style="float:right"><a href="{{url('change-language/ar')}}">عربى</a>
</ul>
</li>

 <!-- <a href="{{url('change-language/ar')}}" style="float:right">عربى</a>  -->
  @else
  <li class="parent" style="width:9%" onclick="location.href='{{url('change-language/en')}}'" style="float:right"><a href="{{url('change-language/en')}}">ُEnglish</a>
  </ul>
  </li>
 <!-- <a href="{{url('change-language/en')}}" style="float:right">English</a>  -->
@endif

</ul>
<br>
<br>
</head>
</html>