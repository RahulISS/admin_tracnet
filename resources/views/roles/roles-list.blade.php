@extends('layouts.default')
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Roles</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('adminDashboard')}}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Roles List</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <div class="btn-group">
                        <a href="{{route('addrole')}}" class="btn btn-primary"><i class="bx bx-plus-alt"></i>Add Role</a>
                    </div>
                </div>
            </div>
            <br>
            <!--end breadcrumb-->
            <div class="row">
                <div class="col-xl-11 mx-auto">
                    <h6 class="mb-0 text-uppercase">Roles List</h6>
                    <hr/>
                    <div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table id="tablefilter" class="table table-striped table-bordered" style="width:100%">
								<thead>
									<tr>
										<th>S.No.</th>
										<th>Name</th>
								
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
                                    @php $count=1; @endphp
                                    @foreach($roles as $row)
									<tr>
										<td>{{$count++}}</td>
										<td>{{$row->name}}</td>
										
										<td>
                                            <a href="{{route('editrole',$row->id)}}" title="edit"><i class="fa fa-pencil" ></i></a>&nbsp;
                                            <a href="{{route('delete.role',$row->id)}}" title="delete"><i class="fa fa-trash" style="color:red"></i></a>
                                        </td>
									</tr>
                                    @endforeach
									
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
{{ \Session::forget('error') }}
@stop
