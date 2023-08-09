<div class="sidebar-wrapper" data-simplebar="true">
        <div class="sidebar-header">
            <div>
                <!-- <img src="assets/images/logo-icon.png" class="logo-icon" alt="logo icon"> -->
            </div>
            <div>
            <img src = "{{ asset('img/FinalLogo.png') }}" style = "width:120px"/>
            </div>
            <div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
            </div>
        </div>
        <!--navigation-->
        <ul class="metismenu" id="menu">
            <li>
                <a href="{{route('adminDashboard')}}">
                    <div class="parent-icon"><i class='bx bx-home-circle'></i>
                    </div>
                    <div class="menu-title">Dashboard</div>
                </a>
            </li>
           
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class='bx bx-user-circle'></i>
                    </div>
                    <div class="menu-title">Configuration</div>
                </a>
                <ul>
                    <li> <a href="{{route('company')}}"><i class="bx bx-right-arrow-alt"></i>Companies</a></li>
                    <li> <a href="{{route('projectlist')}}"><i class="bx bx-right-arrow-alt"></i>Projects</a></li>
                    <li> <a href="{{route('portallist')}}"><i class="bx bx-right-arrow-alt"></i>Portals</a></li>
                    <li> <a href="{{route('modulelist')}}"><i class="bx bx-right-arrow-alt"></i>Modules</a></li>
                    <li> <a href="{{route('unitlist')}}"><i class="bx bx-right-arrow-alt"></i>Units</a></li>
                    <li> <a href="{{route('sensorlist')}}"><i class="bx bx-right-arrow-alt"></i>Sensors</a></li>
                </ul>
			</li>

            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class='bx bx-shield'></i>
                    </div>
                    <div class="menu-title">Security</div>
                </a>
                <ul>
                    <li> <a href="{{route('rolelist')}}"><i class="bx bx-right-arrow-alt"></i>Roles</a></li>
                    <li> <a href="{{route('permissionlist')}}"><i class="bx bx-right-arrow-alt"></i>Permission</a></li>
                </ul>
			</li>   
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class='bx bx-user-circle'></i>
                    </div>
                    <div class="menu-title">Product</div>
                </a>
                <ul>
                    <li> <a href="{{route('productModellist')}}"><i class="bx bx-right-arrow-alt"></i>Product Models</a></li>
                    <li> <a href="{{route('productlist')}}"><i class="bx bx-right-arrow-alt"></i>Product Add</a></li>
                </ul>
			</li>
            <li>
                <a href="{{route('customerlist')}}">
                    <div class="parent-icon"><i class='bx bx-user-plus'></i>
                    </div>
                    <div class="menu-title">Users</div>
                </a>
            </li>
           
            <!-- <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class='bx bx-user-circle'></i>
                    </div>
                    <div class="menu-title">Product</div>
                </a>
                <ul>
                    <li> <a href="{{route('productlist')}}"><i class="bx bx-right-arrow-alt"></i>Product Add</a></li>
                    <li> <a href="{{route('productModellist')}}"><i class="bx bx-right-arrow-alt"></i>Product Models</a></li>
                </ul>
			</li> -->
		    <li>
                <a href="{{route('dms.view')}}">
                    <div class="parent-icon"><i class='bx bx-user-circle'></i>
                    </div>
                    <div class="menu-title">DMS</div>
                </a>
               
			</li>
        </ul>
        <!--end navigation-->
    </div>
