@extends('layouts.default')
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">DMS</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('adminDashboard')}}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{route('customerlist')}}">Device Management System</a>
                            </li>
                            <!-- <li class="breadcrumb-item active" aria-current="page">@if (isset($customer)) Edit @else Add @endif User</li> -->
                        </ol>
                    </nav>
                </div>
            </div>
            <br>
            <!--end breadcrumb-->
           
            <div class="row">
                <div class="col-xl-11 mx-auto ">
                    <div class="d-sm-flex align-items-center">
                        <h6 class="mb-0 text-uppercase">Device Management System</h6>
                        <!-- <h6 class="mb-0 text-uppercase">@if (isset($customer)) Edit @else Add @endif User</h6> -->
                        <a href="#" class="btn btn-primary ms-auto"><i class="bx bx-chevron-left"></i>Back</a>
                    </div>
                    <hr/>
                    <div class="card border-top border-0 border-4 border-primary">
                        <div class="card-body p-5">
                            @if (isset($customer))
                            <form class="row g-3" action="{{route('update.customer',$customer->id)}}" method="post">
                            @else
                            <form class="row g-3" action="{{route('create.customer')}}" method="get">
                            @endif

                            @csrf
                                <div class="col-md-3">
                                    <label for="inputname" class="form-label">Company</label>
                                    <select id="project" name="project" class="form-select" required>
                                        <option value='' disabled selected>Choose...</option>
                                        @foreach($companies as $row)
                                        <option value='{{$row->id}}' >{{$row->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="col-md-3">
                                    <label for="inputname" class="form-label">Project</label>
                                    <select id="project" name="project" class="form-select">
                                        <option value='' disabled selected>Choose...</option>
                                        
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="inputname" class="form-label">Portal</label>
                                    <select id="portal" name="portal" data-placeholder="Choose anything"  multiple="multiple"  class="multiple-select">
                                    </select>                                    
                                </div>
                                <div class="col-md-1"></div>              
                                <div class="col-md-2">
                                    
                                    <button type="submit" class="btn btn-primary px-5 mt-4">Search</button>
                                </div>
                            </form>
                            <div class="mt-5">
                            <table id="tablefilter" class="table table-striped table-bordered" style="width:100%">
								<thead>
									<tr>
										<th>S.No.</th>
										<th>Device</th>
                                        <th>Sensor</th>
                                        <th>Unit</th>
                                        <th>Product</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
                                   
									<tr>
										<td></td>
										<td></td>
                                        <td></td>
                                        <td></td>
                                       
                                       
										<td></td>
										<td>
                                            <a href="#" class="btn btn-success"><i class="fadeIn animated bx bx-list-ul"></i></a>
                                            
                                        </td>
									</tr>
                                   
								</tbody>
							</table>
                            </div>
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
        $('#project').on('change', function(){
            var proj_id = $('#project').val();
            $.ajax({
                url : "{{route('getPortal')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "project_id": proj_id
                },
                type : 'POST',
                success : function(result){
                    $('#multiple_portal').empty();            
                    result.forEach(function(item) {
                        $('#multiple_portal').append($('<option>', {
                            value: item._id,
                            text: item.name
                        }));
                    });
                   
                }
            });
        });
        
    </script>
@stop

