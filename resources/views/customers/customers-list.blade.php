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
                            <li class="breadcrumb-item active" aria-current="page">Users List</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <div class="btn-group">
                        <a href="{{route('addcustomer')}}" class="btn btn-primary"><i class="bx bx-plus-alt"></i>Add Users</a>
                    </div>
                </div>
            </div>
            <br>
            <!--end breadcrumb-->
            <div class="row">
                <div class="col-xl-11 mx-auto">
                    <h6 class="mb-0 text-uppercase">Users List</h6>
                    <hr/>
                    <div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table id="tablefilter" class="table table-striped table-bordered" style="width:100%">
								<thead>
									<tr>
										<th>S.No.</th>
										<th>First name</th>
                                        <th>Last name</th>
                                        <th>Username</th>
                                        <th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
                                    @php $count=1; @endphp
                                    @foreach($customers as $row)
                                   
									<tr>
										<td>{{$count++}}</td>
										<td>{{$row->firstname}}</td>
                                        <td>{{$row->lastname}}</td>
                                        <td>{{$row->username}}</td>
                                       
                                       
										<td><span class="text-{{($row->status==1)?'primary':'danger'}}">{{($row->status==1)?'Active':'Disable'}}</span></td>
										<td>
                                            <a href="{{route('customer.view',$row->id)}}" class="btn btn-success"><i class="fadeIn animated bx bx-list-ul"></i></a>
                                            <a href="{{route('editcustomer',$row->id)}}" class="btn btn-info"><i class="bx bx-edit-alt"></i></a>
                                            <a href="{{route('delete.customer',$row->id)}}" class="btn btn-danger delete"><i class="bx bx-trash-alt"></i></a>
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

