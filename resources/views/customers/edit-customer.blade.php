@extends('layouts.default')
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Users</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('adminDashboard')}}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{route('customerlist')}}">Users List</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">@if (isset($customer)) Edit @else Add @endif User</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <br>
            <!--end breadcrumb-->
           
            <div class="row">
                <div class="col-xl-11 mx-auto ">
                    <div class="d-sm-flex align-items-center">
                        <h6 class="mb-0 text-uppercase">@if (isset($customer)) Edit @else Add @endif User</h6>
                        <a href="{{route('customerlist')}}" class="btn btn-primary ms-auto"><i class="bx bx-chevron-left"></i>Back</a>
                    </div>
                    <hr/>
                    <div class="card border-top border-0 border-4 border-primary">
                        <div class="card-body p-5">
                            @if (isset($customer))
                            <form class="row g-3" action="{{route('update.customer',$customer->id)}}" method="post">
                            @else
                            <form class="row g-3" action="{{route('create.customer')}}" method="post">
                            @endif

                            @csrf
                                <div class="col-md-6">
                                    <label for="inputname" class="form-label">First name</label>
                                    <input type="text" class="form-control" id="firstname" name="firstname" value="{{ old('firstname', $customer->firstname ?? '') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="inputname" class="form-label">Last name</label>
                                    <input type="text" class="form-control" id="lastname" name="lastname" value="{{ old('lastname', $customer->lastname ?? '') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="inputname" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" value="{{ old('username', $customer->username ?? '') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="inputemail" class="form-label">Email (optional)</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $customer->email ?? '') }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="inputname" class="form-label">SMS No. (optional)</label>
                                    <input type="text" class="form-control" id="smsnumber" name="smsnumber" value="{{ old('smsnumber', $customer->smsnumber ?? '') }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="inputname" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" value="{{ old('password', $customer->password ?? '') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="inputname" class="form-label">Status</label>
                                    <select id="status" name="status" class="form-select" required>
                                        <option value="1" @if (isset($customer)){{ $customer->status==1?"selected":''}}@endif>Active</option>
                                        <option value="0" @if (isset($customer)){{ $customer->status==0?"selected":''}}@endif>Disable</option>
                                    </select>
                                </div>
                                
                                <div class="row col-md-12">
                                <h6 class="mt-4 text-uppercase">Assign Roles</h6>
                                <hr/>
                                <div class="containrow">
                                    @foreach($customer->userpermission as $key => $row)
                                    <div class="row col-md-12 mt-3 mb-3">
                                        <div class="col-md-3">
                                            <label for="inputname" class="form-label">Project</label>
                                            <select id="project{{$key}}" name="project[]" class="form-select" required>
                                                <option value='' disabled selected>Choose...</option>
                                                @foreach($projects as $proj)
                                                <option value="{{$proj->id}}" @if (isset($row)){{ $row->project_id==$proj->_id?"selected":''}}@endif >{{$proj->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="inputname" class="form-label">Portal</label>
                                            <select id="multiple_portal{{$key}}" name="multiple_portal[]" data-placeholder="Choose anything" class="multiple-select" required>                                                
                                            </select>                                    
                                        </div>
                                        <div class="col-md-3">
                                            <label for="inputname" class="form-label">Roles</label>
                                            <select id="multiple_role{{$key}}" name="multiple_role[]" data-placeholder="Choose anything" class="multiple-select">
                                            </select>                                    
                                        </div>
                                        @if($key==0)
                                        <div class="col-md-3 mt-3 text-end"><a href="javascript:void(0)" class="btn btn-primary add_form_field px-2 mt-3">+ Add</a></div>
                                        @else
                                        <div class="col-md-3 mt-3 text-end"><button type="submit" class="btn btn-danger deleterow px-2 mt-3"><i class="bx bx-trash-alt"></i></button></div></div>
                                        @endif
                                    </div>
                                    
                                    @endforeach
                                </div>


                                </div>                             
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary px-5 mt-3">Submit</button>
                                </div>
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
    </script>
    @endif
    <script>
        
         $(document).ready(function() {
            
            var max_fields = 6;
            var wrapper = $(".containrow");
            var add_button = $(".add_form_field");
            
            var x = {{count($customer->userpermission)}}-1;
          
            for (let index = 0; index <= x; index++) {
               
                getPortal(index);
                                       
                getRole(index);
                
            }
            $(add_button).click(function(e) {
           
                e.preventDefault();
                if (x < max_fields) {
                    x++;
                    $(wrapper).append(
                        '<div class="row col-md-12 mt-3 mb-3 multirow">'+
                        '<div class="col-md-3 mb-3">'+
                                '<label for="inputname" class="form-label">Project</label>'+
                                '<select id="project'+x+'" name="project[]" class="form-select" >'+
                                    '<option value="" disabled selected>Choose...</option>'+
                                '</select>'+
                            '</div>'+
                            '<div class="col-md-3">'+
                                '<label for="inputname" class="form-label">Portal</label>'+
                                '<select id="multiple_portal'+x+'" name="multiple_portal[]" data-placeholder="Choose anything" class="multiple-select" >'+
                                    '<option value="" disabled selected>Choose...</option>'+
                                '</select>'+
                            '</div>'+
                            '<div class="col-md-3">'+
                                '<label for="inputname" class="form-label">Roles</label>'+
                                '<select id="multiple_role'+x+'" name="multiple_role[]" data-placeholder="Choose anything" class="multiple-select" >'+
                                    '<option value="" disabled selected>Choose...</option>'+
                                '</select>'+
                            '</div>'+
                            
                            '<div class="col-md-3 mt-3 text-end"><button type="submit" class="btn btn-danger deleterow px-2 mt-3"><i class="bx bx-trash-alt"></i></button></div></div>'
                    );
                    // getuseprotal(x);
                    $('.multiple-select').select2({
                        theme: 'bootstrap4',
                        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
                        placeholder: $(this).data('placeholder'),
                        allowClear: Boolean($(this).data('allow-clear')),
                    });
                    
                    $("#project"+x).on('change', function(){
                        getPortal(x);
                    });

                    $("#multiple_portal"+x).on('change', function(){
                        getRole(x);
                    });                   

                    getProject(x);

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
                    
                    $(this).parents(".multirow").remove();
                
                    x--;  return true;
                 })
            });
        
        function getProject(pr=''){
            $.ajax({
                url : "{{route('getProject')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                type : 'GET',
                success : function(result){
                        
                    result.forEach(function(item) {
                        $("#project"+pr).append($('<option>', {
                            value: item._id,
                            text: item.name
                        }));
                    });
                
                }
            });

        }

        function getPortal(pr=''){
            // getuseprotal();            
            var proj_id = $('#project'+pr).val();
            $.ajax({
                url : "{{route('getPortal')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "project_id": proj_id
                },
                type : 'POST',
                success : function(result){
                    $('#multiple_portal'+pr).empty();
                    $('#multiple_role'+pr).empty();
                    $("#multiple_portal"+pr).empty().append("<option disabled='disabled' SELECTED>Choose...</option>");         
                    result.forEach(function(item) {
                        $('#multiple_portal'+pr).append($('<option '+roleselected+' value="'+item._id+'">'+item.name+'</option>'));
                    });
                }
            });
        }

        function getRole(pr=''){
            // getuseprotal();
            var proj_id = $('#project'+pr).val();            
            var portal_id = $('#multiple_portal'+pr).val();
            var roleid = 0;
            $.ajax({
                url : "{{route('getRole')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "portal_id": portal_id,
                    "project_id": proj_id
                },
                type : 'POST',
                success : function(result){
                    // console.log("check the array data",result.data);
                    $('#multiple_role'+pr).empty();
                    $("#multiple_role"+pr).empty().append("<option disabled='disabled' SELECTED>Choose...</option>");   
                    var results = result.data;         
                    results.forEach(function(item) {
                        var roleselected = (roleid == item._id)?'selected':'';
                        $('#multiple_role'+pr).append($('<option '+roleselected+' value="'+item._id+'">'+item.name+'</option>'));                      
                        
                    });
                   
                }
            });
        }

        
    </script>
@stop

