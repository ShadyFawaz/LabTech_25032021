<head>
<link href="{{asset('CSS/bootstrap v3.1.0.min.css')}}" rel="stylesheet">

<!-- <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css"> -->
<!-- <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script> -->
<!-- <script src="//code.jquery.com/jquery-1.11.1.min.js"></script> -->
<!------ Include the above in your HEAD tag ---------->

<style>
body {
    padding-top: 50px;
    /* background-color:RGB(155,155,255); */
    background-color:antiquewhite;

}
/* To Dropdown navbar dropdown on hover */
.navbar-nav > li:hover > .dropdown-menu {
    display: block;
    background-color:white;

}
.dropdown-submenu {
    position: relative;
}

.dropdown-submenu>.dropdown-menu {
    top: 0;
    left: 100%;
    margin-top: -6px;
    margin-left: -1px;
    -webkit-border-radius: 0 6px 6px 6px;
    -moz-border-radius: 0 6px 6px;
    border-radius: 0 6px 6px 6px;
}

.dropdown-submenu:hover>.dropdown-menu {
    display: block;
}

.dropdown-submenu>a:after {
    display: block;
    content: " ";
    float: right;
    width: 0;
    height: 0;
    border-color: transparent;
    border-style: solid;
    border-width: 5px 0 5px 5px;
    border-left-color: #ccc;
    margin-top: 5px;
    margin-right: -10px;
}

.dropdown-submenu:hover>a:after {
    border-left-color: #fff;
}

.dropdown-submenu.pull-left {
    float: none;
}

.dropdown-submenu.pull-left>.dropdown-menu {
    left: -100%;
    margin-left: 10px;
    -webkit-border-radius: 6px 0 6px 6px;
    -moz-border-radius: 6px 0 6px 6px;
    border-radius: 6px 0 6px 6px;
}
</style>

<div class="navbar navbar-default navbar-fixed-top" role="navigation">
 
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
            </ul>
            <ul class="nav navbar-nav">
                <li class="active"><a href="{{url('home')}}">{{__('title.home_page')}}</a></li>
                @if(Auth::user()->hasPermissionTo(1))
                <li class="active"><a href="{{url('patientreg')}}">{{__('title.patient_reg_list')}}</a></li>
                @endif
                <li>

                @if(Auth::user()->hasPermissionTo(120))
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{__('title.administration')}} <b class="caret"></b></a>
                    @endif
                    <ul class="dropdown-menu multi-level">
                    @if(Auth::user()->hasPermissionTo(122))
                    <li><a href="{{url('roles')}}">{{__('title.roles')}}</a></li>
                    @endif
                    @if(Auth::user()->hasPermissionTo(121))
                    <li><a href="{{url('users')}}">{{__('title.users')}}</a></li>
                    @endif
                        
                    </ul>
                </li>
                <li>


                @if(Auth::user()->hasPermissionTo(2))
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{__('title.reg_menus')}} <b class="caret"></b></a>
                    @endif
                    <ul class="dropdown-menu multi-level">
                    @if(Auth::user()->hasPermissionTo(3))
                        <li><a href="{{url('newpatientreg')}}">{{__('title.newpatientreg')}}</a></li>
                        @endif
                        @if(Auth::user()->hasPermissionTo(4))
                        <li><a href="{{url('newpatientregprofile')}}">{{__('title.newpatientregprofile')}}</a></li>
                        @endif
                    </ul>
                </li>
                <li>

                @if(Auth::user()->hasPermissionTo(5))
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{__('title.system_setup')}}<b class="caret"></b></a>
                    @endif
                    <ul class="dropdown-menu">
                        <li class="dropdown-submenu">
                        @if(Auth::user()->hasPermissionTo(8))
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{__('title.culture_setup')}}</a>
                            @endif
                            <ul class="dropdown-menu">
                            @if(Auth::user()->hasPermissionTo(38))
                                <li><a href="{{url('antibiotics')}}">{{__('title.antibiotics')}}</a></li>
                                @endif
                                @if(Auth::user()->hasPermissionTo(48))
                                <li><a href="{{url('organism')}}">{{__('title.organisms_mainmenu')}}</a></li>
                               @endif
                               @if(Auth::user()->hasPermissionTo(52))
                                <li><a href="{{url('culturelink')}}">{{__('title.culture_link')}}</a></li>
                                @endif
                                </li>
                            </ul>

                            <li class="dropdown-submenu">
                            @if(Auth::user()->hasPermissionTo(56))
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{__('title.test_setup')}}</a>
                            @endif
                            <ul class="dropdown-menu">
                            @if(Auth::user()->hasPermissionTo(57))
                                <li><a href="{{url('testdata')}}">{{__('title.test_data')}}</a></li>
                               @endif
                               @if(Auth::user()->hasPermissionTo(60))
                                <li><a href="{{url('grouptests')}}">{{__('title.group_tests')}}</a></li>
                                @endif
                                @if(Auth::user()->hasPermissionTo(62))
                                <li><a href="{{url('megatests')}}">{{__('title.mega_tests')}}</a></li>
                                @endif
                                @if(Auth::user()->hasPermissionTo(64))
                                <li><a href="{{url('profiles')}}">{{__('title.test_profile')}}</a></li>
                                @endif
                                </li>
                            </ul>

                            <li class="dropdown-submenu">
                            @if(Auth::user()->hasPermissionTo(66))
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{__('title.labtolab_setup')}}</a>
                            @endif
                            <ul class="dropdown-menu">
                            @if(Auth::user()->hasPermissionTo(67))
                                <li><a href="{{url('outlabs')}}">{{__('title.out_labs_mainmenu')}}</a></li>
                            @endif
                                </li>
                            </ul>

                            <li class="dropdown-submenu">
                            @if(Auth::user()->hasPermissionTo(69))
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{__('title.regmenus_setup')}}</a>
                            @endif
                            <ul class="dropdown-menu">
                            @if(Auth::user()->hasPermissionTo(70))
                                <li><a href="{{url('doctor')}}">{{__('title.doctors')}}</a></li>
                                @endif
                                @if(Auth::user()->hasPermissionTo(74))
                                <li><a href="{{url('diagnosis')}}">{{__('title.diagnosis')}}</a></li>
                                @endif
                                @if(Auth::user()->hasPermissionTo(78))
                                <li><a href="{{url('titles')}}">{{__('title.titles_mainmenu')}}</a></li>
                                @endif
                                @if(Auth::user()->hasPermissionTo(82))
                                <li><a href="{{url('patientcondition')}}">{{__('title.patient_condition_mainmenu')}}</a></li>
                                @endif
                                </li>
                            </ul>


                            <li class="dropdown-submenu">
                            @if(Auth::user()->hasPermissionTo(86))
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{__('title.general_setup')}}</a>
                            @endif
                            <ul class="dropdown-menu">
                            @if(Auth::user()->hasPermissionTo(87))
                                <li><a href="{{url('viewpatientdata')}}">{{__('title.patient_data_mainmenu')}}</a></li>
                                @endif
                                @if(Auth::user()->hasPermissionTo(89))
                                <li><a href="{{url('groups')}}">{{__('title.groups')}}</a></li>
                                @endif
                                @if(Auth::user()->hasPermissionTo(92))
                                <li><a href="{{url('resultsunits')}}">{{__('title.results_units_mainmenu')}}</a></li>
                                @endif
                                @if(Auth::user()->hasPermissionTo(95))
                                <li><a href="{{url('labunit')}}">{{__('title.lab_units')}}</a></li>
                                @endif
                                @if(Auth::user()->hasPermissionTo(98))
                                <li><a href="{{url('sampletype')}}">{{__('title.sample_type_mainmenu')}}</a></li>
                                @endif
                                @if(Auth::user()->hasPermissionTo(101))
                                <li><a href="{{url('samplecondition')}}">{{__('title.sample_condition_mainmenu')}}</a></li>
                                @endif
                                @if(Auth::user()->hasPermissionTo(104))
                                <li><a href="{{url('country')}}">{{__('title.country_mainmenu')}}</a></li>
                                @endif
                                </li>
                            </ul>



                        </li>
                    </ul>
                </li>

                <li>
                @if(Auth::user()->hasPermissionTo(6))
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{__('title.tools_menu')}} <b class="caret"></b></a>
                    @endif
                    <ul class="dropdown-menu">
                    @if(Auth::user()->hasPermissionTo(134))
                        <li><a href="{{url('patientregdeleted')}}">{{__('title.deleted_patients')}}</a></li>
                        @endif
                    @if(Auth::user()->hasPermissionTo(151))
                    <li><a href="{{url('regtracking')}}">{{__('title.reg_tracking')}}</a></li>
                    @endif
                
                    </ul>
                </li>


                <li>
                @if(Auth::user()->hasPermissionTo(6))
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{__('title.financial')}} <b class="caret"></b></a>
                    @endif
                    <ul class="dropdown-menu">
                    @if(Auth::user()->hasPermissionTo(134))
                        <li><a href="{{url('invoice')}}">{{__('title.invoice')}}</a></li>
                        @endif
                        <li class="dropdown-submenu">
                        @if(Auth::user()->hasPermissionTo(135))
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{__('title.price_lists')}}</a>
                            @endif
                            <ul class="dropdown-menu">
                            @if(Auth::user()->hasPermissionTo(136))
                                <li><a href="{{url('pricelists')}}">{{__('title.price_lists_main')}}</a></li>
                                @endif
                                @if(Auth::user()->hasPermissionTo(137))
                                <li><a href="{{url('rankpricelists')}}">{{__('title.price_lists_reg')}}</a></li>
                                @endif
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>

                <li>
                @if(Auth::user()->hasPermissionTo(7))
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{__('title.results_mainmenu')}} <b class="caret"></b></a>
                    @endif
                    <ul class="dropdown-menu">
                    @if(Auth::user()->hasPermissionTo(138))
                        <li><a href="{{url('searchresultsbyday')}}">{{__('title.resultsbyday_mainmenu')}}</a></li>
                        @endif
                        </li>
                    </ul>
                </li>
    

            <!-- <li>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Menu 2 <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                        <li class="divider"></li>
                        <li><a href="#">One more separated link</a></li>
                        <li class="dropdown-submenu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown</a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Action</a></li>
                                <li><a href="#">Another action</a></li>
                                <li><a href="#">Something else here</a></li>
                                <li class="divider"></li>
                                <li><a href="#">Separated link</a></li>
                                <li class="divider"></li>
                                <li class="dropdown-submenu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown</a>
                                    <ul class="dropdown-menu">
                                        <li class="dropdown-submenu">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown</a>
                                            <ul class="dropdown-menu">
                                                <li><a href="#">Action</a></li>
                                                <li><a href="#">Another action</a></li>
                                                <li><a href="#">Something else here</a></li>
                                                <li class="divider"></li>
                                                <li><a href="#">Separated link</a></li>
                                                <li class="divider"></li>
                                                <li><a href="#">One more separated link</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li> -->
                @if (app()->getLocale() == 'en')
                <li class="active" style="float:right"><a href="{{url('change-language/ar')}}" >عربى</a></li>
                @else
                <li class="active" style="float:right"><a href="{{url('change-language/en')}}" >ُEnglish</a></li>
                @endif
            </ul>


            </ul>
        </div>
    </div>
</div>


</head>