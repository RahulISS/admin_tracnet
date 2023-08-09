@extends('layouts.default')
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Modules</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('adminDashboard')}}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Modules List</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <div class="btn-group">
                        <a href="{{route('addmodule')}}" class="btn btn-primary"><i class="bx bx-plus-alt"></i>Add Module</a>
                    </div>
                    <div class="btn-group">
                        <a href="{{route('addsubmodule')}}" class="btn btn-primary"><i class="bx bx-plus-alt"></i>Add Sub Module</a>
                    </div>
                </div>
            </div>
            <br>
            <!--end breadcrumb-->
            <div class="row">
                <div class="col-xl-11 mx-auto">
                    <h6 class="mb-0 text-uppercase">Modules List</h6>
                    <hr/>
                    <div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table id="tablefilter" class="table table-striped table-bordered yajra-datatable" style="width:100%">
								<thead>
									<tr>
										<th>S.No.</th>
										<th>Module Name</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
                                </tbody>
							</table>
						</div>
					</div>
				</div>
                </div>
            </div>
  
        </div>
    </div>
    
@endsection

@section('scripts')
<script type="text/javascript">
        $(function () {
            var table = $('.yajra-datatable').DataTable({
                processing: true,
                serverSide: true,
                bDestroy: true,
                ajax: "{{route('moduleajaxdata')}}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {
                        data: 'action', 
                        name: 'action', 
                        orderable: true, 
                        searchable: true
                    },
                ]
            });
            
        });
</script>
@stop