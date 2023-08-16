@extends('layouts.default')
@section('content')
<style>
        .form-group {
            display: block;
            margin-bottom: 15px;
        }

        .form-group input {
            padding: 0;
            height: initial;
            width: initial;
            margin-bottom: 0;
            display: none;
            cursor: pointer;
        }

        .form-group label {
            position: relative;
            cursor: pointer;
        }

        .form-group label:before {
            content: '';
            /* -webkit-appearance: none; */
            background-color: transparent;
            border: 2px solid #0079bf;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05), inset 0px -15px 10px -12px rgba(0, 0, 0, 0.05);
            padding: 6px;
            display: inline-block;
            position: relative;
            vertical-align: middle;
            cursor: pointer;
            margin-right: 5px;
            left: -20px;
            margin-top: -7px;
        }

        .form-group input:checked+label:after {
            content: '';
            display: block;
            position: absolute;
            top: 2px;
            left: -15px;
            width: 4px;
            height: 8px;
            border: solid #0079bf;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }

        img.folder-img {
            max-width: 15px;
            width: 100%;
            position: absolute;
        }

        .cart-arrow-down img {
            max-width: 15px;
            width: 100%;
            position: absolute;
            left: 1px;
            cursor: pointer;
            margin-top: -1px;
            transition: 0.8s;

        }

        .ul_li_herc {
            list-style-type: none;
            padding: 0px;
            margin: 0px;
            padding: 0px 10px;
            position: relative;
        }
        

        .ul_li_herc li {
            list-style-type: none;
            padding: 0px;
            margin: 0px;
            /* display: flex; */
            padding-left: 30px;
        }
      

        .toggle-block {
            position: relative;
            padding: 0px;
            margin: 0px;
        }

        .toggle-block .cart-arrow-down img {
            position: absolute;
            left: -8px;
            transition: 0.8s;
        }

        .toggle-block-1 {
            position: relative;
            padding: 0px;
            margin: 0px;
            /* padding-left: 50px; */
        }

        .toggle-block-1 .cart-arrow-down img {
            position: absolute;
            left: -9px;
            transition: 0.8s;
        }

        .ul_li_herc li ul {
            display: none;
        } 

        .ul_li_herc .show {
            display: block;
        }

        .twist img {
            transform: rotate(80deg);
        }
        .inner-flex{
            display: flex;

        }
        .block-left{
            width: 30%;
           
        }

        .block-right{
            width: 70%;
            background-color: #fff;
            padding: 10px;  margin-left: 50px;
        }
        .main-container{
            display: block;
            margin: 0px auto;
            width: 100%;
            max-width: 1200px;
        }
    </style>

   
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Permissions</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('adminDashboard')}}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{route('permissionlist')}}">Permission List</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Permission</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <br>
            <!--end breadcrumb-->
           
            <div class="row">
                <div class="col-xl-11 mx-auto">
                    <div class="d-sm-flex align-items-center">
                        <h6 class="mb-0 text-uppercase">@if (isset($permissions)) Edit @else Add @endif Permission</h6>
                        <a href="{{route('permissionlist')}}" class="btn btn-primary ms-auto"><i class="bx bx-chevron-left"></i>Back</a>
                    </div>                    
                    <hr/>
                    <div class="card border-top border-0 border-4 border-primary">
                        <div class="card-body p-5">
                            @if (isset($permissions))
                            <form class="row g-3" action="{{route('update.permission',$permissions->id)}}" method="post">
                            @else
                            <form class="row g-3" action="{{route('create.permission')}}" method="post">
                            @endif

                            @csrf
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="inputname" class="form-label">Project</label>
                                        <select id="projects" name="projects" class="form-select" required>
                                            <option value='' disabled selected>Choose...</option>
                                            @foreach($projectlist as $row)
                                            <option value="{{$row->id}}" @if (isset($permissions)){{ $permissions->project_id==$row->_id?"selected":''}}@endif >{{$row->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <hr>
                                <div class="containrow">
                                    <div class="row col-md-12 mt-3">
                                    
                                        <div class="col-md-3 mb-3">
                                            <label for="inputportal" class="form-label">Portal</label>
                                            <select id="multiple_portal" name="portal" class="form-select multiple_portal" required>
                                                <option value='' disabled>No record found...</option>

                                            </select>
                                        </div>
                                        <div class="col-md-3 mb-3 border-end">
                                            <label for="inputname" class="form-label">Role</label>
                                            <select id="multiple_role" name="role" class="form-select" required>
                                                <option value='' disabled>No record found...</option>
                                            </select>
                                        </div>
                                        <div class="col-md-5 ">
                                        
                                            <div class="block-right">
                                            <label for="inputportal" class="form-label">Modules</label>
                                            <br><br>
                                            <!-- Getting module and submodule array -->
                                           
                                              

                                                @if($permissions->module_permissions)
                                                    @php $moduleIds=json_decode($permissions->module_permissions,true); @endphp
                                                @else
                                                   @php  $moduleIds=[]; @endphp
                                                @endif


                                                @if($permissions->submodule_permissions)
                                                    @php $submoduleIds=json_decode($permissions->submodule_permissions,true);  @endphp
                                                @else
                                                   @php  $submoduleIds=[]; @endphp
                                                @endif

                                                

                                          
                                        
                                                
                                            <ul id="treeview">
                                                
                                                @foreach ($moduleslist as $module)
                                                    
                                                    <li>
                                                        <div class="moduleHeader">
                                                            <input type="checkbox" name="module[]" class="moduleCheckbox parentCheckbox" id="module_{{ $module->id }}" @if(in_array($module->id,$moduleIds)) checked @endif>
                                                            <label class="moduleLabel" for="module_{{ $module->id }}">
                                                                <span class="folderSymbol">&#128193;</span> <!-- Folder Symbol -->
                                                                {{ $module->name }}
                                                            </label>
                                                        </div>
                                                        <ul class="submoduleList"> <!-- Container for submodule list -->
                                                            @foreach ($module->submodules as $submodule)
                                                                <li>
                                                                    <input type="checkbox" name="submodule[]" class="submoduleCheckbox" data-parent="module_{{ $module->id }}" id="submodule_{{ $submodule->id }}" @if(in_array($submodule->id,$submoduleIds)) checked @endif>
                                                                    <label class="submoduleLabel" for="submodule_{{ $submodule->id }}">{{ $submodule->name }}</label>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            </div>
                                            
                                        </div>
                                        <!-- <div class="col-md-1"><a href="javascript:void(0)" class="btn btn-primary add_form_field px-2 mt-3">+ Add</a></div> -->
                                    </div>
                                 
                                </div>
                                <div class="col-12 text-end"><button type="submit" class="btn btn-primary px-4 mt-3">Submit</button></div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
            <!--end row-->
        </div>
    </div>
           
@endsection
@section('scripts')
    
    @if(\Session::get('success'))
    <script>
        $(document).ready(function(){
            Lobibox.notify('success', {
                pauseDelayOnHover: true,
                size: 'mini',
                rounded: true,
                icon: 'bx bx-check-circle',
                delayIndicator: false,
                continueDelayOnInactiveTab: false,
                position: 'top right',
                msg: '{{ \Session::get("success") }}'
            });
        });
    </script>
    @endif
    {{ \Session::forget('success') }}
    @if(\Session::get('error'))
    <script>
        $(document).ready(function(){
            Lobibox.notify('error', {
                pauseDelayOnHover: true,
                size: 'mini',
                rounded: true,
                delayIndicator: false,
                icon: 'bx bx-x-circle',
                continueDelayOnInactiveTab: false,
                position: 'top right',
                msg: '{{ \Session::get("error") }}'
            });
        });
        $('.multiple-select').select2({
            theme: 'bootstrap4',
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            allowClear: Boolean($(this).data('allow-clear')),
        });
    </script>
  
    @endif
    <script>
                     
        $(document).ready(function() {
            getprojportal();
            getrole();
            var max_fields = 6;
            var wrapper = $(".containrow");
            var add_button = $(".add_form_field");

            var x = 0;
            $(add_button).click(function(e) {
                
                if($('#projects').val() == null){ alert('Project is required!'); return false;}
                e.preventDefault();
                if (x < max_fields) {
                    x++;
                  
                        $(wrapper).append(
                            '<div class="row col-md-12 mt-3 multirow"><hr>'+  
                                '<div class="col-md-3 mb-3">'+
                                    '<label for="inputportal" class="form-label">Portal</label>'+
                                    '<select id="multiple_portal'+x+'" name="portal[]" class="form-select multiple_portal" required>'+
                                        '<option value="" disabled>No record found...</option>'+
                                    '</select>'+
                                '</div>'+
                                '<div class="col-md-3 mb-3 border-end">'+
                                    '<label for="inputname" class="form-label">Role</label>'+
                                    '<select id="multiple_role'+x+'" name="role[]" class="form-select" required>'+
                                        '<option value="" disabled selected>Choose...</option>'+
                                    '</select>'+
                                '</div>'+
                                '<div class="col-md-5 ">'+
                                    '<div class="block-right">'+
                                    '<label for="inputportal" class="form-label">Modules</label>'+
                                    '<br><br>'+
                                        '<ul class="ul_li_herc modulelist'+x+'">'+
                                            
                                        '</ul>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-md-1"><button type="submit" class="btn btn-danger deleterow px-2 mt-3"><i class="bx bx-trash-alt"></i></button></div>'+
                            '</div>'
                        ); //add input box                  
                        getprojportal(x);
                        getrole(x);
                   
                    } else {
                        alert('You Reached the limits');
                    }
                
            });

            $(wrapper).on("click", ".deleterow", function(e) {
                e.preventDefault();
                if(!confirm('Are you sure! want to delete?')){
                    e.preventDefault();
                    return false;
                }
                // $(this).parents(".multirow").fadeOut(function() { 
                $(this).parents(".multirow").remove();
                // });
                x--;  return true;
            })

            $(wrapper).on('click','.cart-arrow-down',function (e) {
                e.preventDefault();
                $(this).next().next().slideToggle('show');
            });

            $(wrapper).on('click','.CheckAllbox', function () {
                $('input:checkbox').not(this).prop('checked', this.checked);
            });
        });

        $('#projects').on('change', function(){
            getprojportal();
        });

        function getprojportal(pr=''){
            var proj_id = $('#projects').val();
            var portalid = '{{$permissions->portal_id}}';
           
            $.ajax({
                url : "{{route('getProjectportal')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "proj_id": proj_id
                },
                type : 'POST',
                success : function(result){
                    $('#multiple_portal'+pr).empty();            
                    result.forEach(function(item) {
                        var portalselected = (portalid == item._id)?'selected':'';
                       
                        $('#multiple_portal'+pr).append($('<option '+portalselected+' value="'+item._id+'">'+item.name+'</option>'));
                     
                    });
                   
                }
            });
        }

        function getrole(pr=''){
            var roleid = '{{$permissions->role_id}}';
            $.ajax({
                url : "{{route('getRoleper')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "indexes": (pr=='')?0:pr
                },
                type : 'POST',
                success : function(result){
                    $('#multiple_role'+pr).empty();
                    $('.modulelist'+pr).html(result.module);
                    var roledata = result.role;          
                    roledata.forEach(function(item) {
                        var roleselected = (roleid == item._id)?'selected':'';
                        $('#multiple_role'+pr).append($('<option '+roleselected+' value="'+item._id+'">'+item.name+'</option>'));
                    });
                   
                }
            });
        }

    const parentCheckboxes = document.querySelectorAll('.parentCheckbox');
    const submoduleCheckboxes = document.querySelectorAll('.submoduleCheckbox');

    parentCheckboxes.forEach(parentCheckbox => {
    parentCheckbox.addEventListener('change', function() {
        const isChecked = this.checked;
        const parentCheckboxId = this.id;

        submoduleCheckboxes.forEach(submoduleCheckbox => {
            if (submoduleCheckbox.dataset.parent === parentCheckboxId) {
                submoduleCheckbox.checked = isChecked;
                submoduleCheckbox.disabled = !isChecked; // Enable/disable submodule checkboxes
            }
        });
    });
    });

    $(document).ready(function () {
        // Hide all submodule lists by default
        
        // Toggle submodule list when parent checkbox is clicked
        $('.parentCheckbox').click(function () {
            // $(this).closest('li').find('.submoduleList').toggle();
        });
    });

    
        document.addEventListener("DOMContentLoaded", function() {
    // Get references to the checkboxes
    var moduleCheckboxes = document.querySelectorAll(".moduleCheckbox");
    var submoduleCheckboxes = document.querySelectorAll(".submoduleCheckbox");

    // Add a submit event listener to the form
    var form = document.querySelector("form");
    form.addEventListener("submit", function(event) {
        var selectedModuleIds = [];
        var selectedSubmoduleIds = [];

        // Loop through module checkboxes to get selected module IDs
        moduleCheckboxes.forEach(function(checkbox) {
            if (checkbox.checked) {
                selectedModuleIds.push(checkbox.id.replace("module_", ""));
            }
        });

        // Loop through submodule checkboxes to get selected submodule IDs
        submoduleCheckboxes.forEach(function(checkbox) {
            if (checkbox.checked) {
                selectedSubmoduleIds.push(checkbox.id.replace("submodule_", ""));
            }
        });

        // Add hidden input fields to the form with the selected IDs
        selectedModuleIds.forEach(function(moduleId) {
            var input = document.createElement("input");
            input.type = "hidden";
            input.name = "selectedModuleIds[]";
            input.value = moduleId;
            form.appendChild(input);
        });

        selectedSubmoduleIds.forEach(function(submoduleId) {
            var input = document.createElement("input");
            input.type = "hidden";
            input.name = "selectedSubmoduleIds[]";
            input.value = submoduleId;
            form.appendChild(input);
        });
    });
});
 
    </script>
@stop

