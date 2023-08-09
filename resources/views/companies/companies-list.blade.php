@extends('layouts.default')
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Companies</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('adminDashboard')}}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Companies List</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <div class="btn-group">
                        <a href="{{route('addcompany')}}" class="btn btn-primary"><i class="bx bx-plus-alt"></i>Add Companies</a>
                    </div>
                </div>
            </div>
            <br>
            <!--end breadcrumb-->
            <div class="row">
                <div class="col-xl-11 mx-auto">
                    <h6 class="mb-0 text-uppercase">Companies List</h6>
                    <hr/>
                    <div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table id="tablefilter" class="table table-striped table-bordered yajra-datatable" style="width:100%">
								<thead>
									<tr>
										<th>S.No.</th>
										<th>Companies Name</th>
                                        <th>Location</th>
                                        <th>Projects Count</th>
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
            <!--end row-->
        </div>
    </div>

         

    
@endsection
@section('scripts')
    <script>
        function projectData(data) {
            $.ajax({
                url : "{{ route('company.projects') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "company_id": data
                },
                type : 'GET',
                success : function(result){
                    $("#project_count").modal('show');
                    $('#modal-body').empty(); 
                    result.forEach(function(item) {
                        var modalBody = document.getElementById('modal-body');

                        var paragraph = document.createElement('p');
                        paragraph.textContent = item.name;

                        modalBody.appendChild(paragraph);
                    });
                                      
                }
            });
        };
    </script>


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

@section('scripts')
<script type="text/javascript">
        $(function () {
            var table = $('.yajra-datatable').DataTable({
                processing: true,
                serverSide: true,
                bDestroy: true,
                ajax: "{{route('companylist')}}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'location', name: 'location'},
                    {data: 'project_count', name: 'project_count'},
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

@stop

