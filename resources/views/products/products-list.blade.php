@extends('layouts.default')
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Products</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('adminDashboard')}}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Products List</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <div class="btn-group">
                        <a href="{{route('addproduct')}}" class="btn btn-primary"><i class="bx bx-plus-alt"></i>Add Products</a>
                    </div>
                </div>
            </div>
            <br>
            <!--end breadcrumb-->
            <div class="row">
                <div class="col-xl-11 mx-auto">
                    <h6 class="mb-0 text-uppercase">Products List</h6>
                    <hr/>
                    <div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table id="tablefilter" class="table table-striped table-bordered" style="width:100%">
								<thead>
									<tr>
										<th>S.No.</th>
										<th>Serial Id</th>
                                        <th>Product Models</th>
                                        <th>Portal</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
                                    @php $count=1; @endphp
                                    @foreach($products as $row)
									<tr>
										<td>{{$count++}}</td>
										<td>{{$row->serial_id}}</td>
										<td>{{@$row->productModel->modelId}}</td>
                                        <td>{{@$row->portal->name}}</td>
										<td>
                                            <a href="{{route('editproduct',$row->id)}}" class="btn btn-info"><i class="bx bx-edit-alt"></i></a>
                                            <a href="{{route('delete.product',$row->id)}}" class="btn btn-danger delete"><i class="bx bx-trash-alt"></i></a>
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