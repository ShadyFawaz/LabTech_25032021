<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {
  font-family: serif;
  /* background-color: lightblue; */

  background-color: RGB(228,226,133);
}

.navbar {
  padding: 0px 0px;
  font-size: 14px;
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




<div class="navbar">
  <a href="{{url('home')}}">                 {{__('title.home_page')}}</a>
  <a href="{{url('patientreg')}}">           {{__('title.patient_reg_list')}}</a>
  <div class="dropdown">
    <button class="dropbtn">                 {{__('title.reg_menus')}}
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
    <a href="{{url('newpatientreg')}}">           {{__('title.newpatientreg')}}</a>
    <a href="{{url('newpatientregprofile')}}">    {{__('title.newpatientregprofile')}}</a>
    </div>
    </div>

  <a href="#news">                           {{__('title.bulk_registration')}}</a>


  <div class="dropdown">
    <button class="dropbtn">                 {{__('title.system_setup')}}
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
    @can('Edit Verified Results')
    <a href="{{url('antibiotics')}}">           {{__('title.antibiotics')}}</a>
    @endcan
    <a href="{{url('country')}}">               {{__('title.country_mainmenu')}}</a>
    <a href="{{url('culturelink')}}">           {{__('title.culture_link')}}</a>
    <a href="{{url('deletepatientsearch')}}">   {{__('title.deletepatient_mainmenu')}}</a>
    <a href="{{url('diagnosis')}}">             {{__('title.diagnosis')}}</a>
    <a href="{{url('doctor')}}">                {{__('title.doctors')}}</a>
    <a href="{{url('groups')}}">                {{__('title.groups')}}</a>
    <a href="{{url('labunit')}}">               {{__('title.lab_units')}}</a>
    <a href="{{url('organism')}}">              {{__('title.organisms_mainmenu')}}</a>
    <a href="{{url('outlabs')}}">               {{__('title.out_labs_mainmenu')}}</a>
    <a href="{{url('patientcondition')}}">      {{__('title.patient_condition_mainmenu')}}</a>
    <a href="{{url('viewpatientdata')}}">       {{__('title.patient_data_mainmenu')}}</a>
    <a href="{{url('resultsunits')}}">          {{__('title.results_units_mainmenu')}}</a>
    <a href="{{url('sampletype')}}">            {{__('title.sample_type_mainmenu')}}</a>
    <a href="{{url('samplecondition')}}">       {{__('title.sample_condition_mainmenu')}}</a>  
    <a href="{{url('users')}}">                 {{__('title.users')}}</a>  
    <a href="{{url('megatests')}}">             {{__('title.mega_tests')}}</a>
    <a href="{{url('grouptests')}}">            {{__('title.group_tests')}}</a>
    <a href="{{url('testdata')}}">              {{__('title.test_data')}}</a> 
    <a href="{{url('profiles')}}">              {{__('title.test_profile')}}</a>  
    <a href="{{url('titles')}}">                {{__('title.titles_mainmenu')}}</a>
  
    </div>
    </div>
    <div class="dropdown">
    <button class="dropbtn">{{__('title.financial')}}
      <i class="fa fa-caret-down"></i>
      </button>
      <div class="dropdown-content">
      <a href="{{url('invoice')}}">          {{__('title.invoice')}}</a>
      <a href="{{url('pricelists')}}">       {{__('title.price_lists')}}</a>
      <a href="{{url('rankpricelists')}}">   {{__('title.price_lists_reg')}}</a>


    </div>
    </div>

    <div class="dropdown">
    <button class="dropbtn">                   {{__('title.system_tools')}}
      <i class="fa fa-caret-down"></i>
      </button>
      <div class="dropdown-content">
      <a href="#news">                         {{__('title.reg_tracking')}}</a>


    </div>
    </div>

    <div class="dropdown">
    <button class="dropbtn">                 {{__('title.results_mainmenu')}}
      <i class="fa fa-caret-down"></i>
      </button>
      <div class="dropdown-content">
      <a href="{{url('searchresultsbyday')}}">     {{__('title.resultsbyday_mainmenu')}}</a>
     

    </div>


    



  </div>
  @if (app()->getLocale() == 'en')
  <a href="{{url('change-language/ar')}}" style="float:right">عربى</a> 
  @else
  <a href="{{url('change-language/en')}}" style="float:right">English</a> 
@endif
</div>
</head>
</html>