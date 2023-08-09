@extends('layouts.default')
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Projects</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('adminDashboard')}}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Projects List</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <div class="btn-group">
                        <a href="{{route('addproject')}}" class="btn btn-primary"><i class="bx bx-plus-alt"></i>Add Project</a>
                    </div>
                </div>
            </div>
            <br>
            <!--end breadcrumb-->
            <div class="row">
                <div class="col-xl-11 mx-auto">
                    <h6 class="mb-0 text-uppercase">Projects List</h6>
                    <hr/>
                    <div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table id="tablefilter" class="table table-striped table-bordered" style="width:100%">
								<thead>
									<tr>
										<th>S.No.</th>
										<th>Project</th>
										<th>Company</th>
                                        <th>Project Type</th>
                                        <th>Portal Count</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
                                    @php $count=1; @endphp
                                    @foreach($projects as $key => $row)
									<tr>
										<td>{{$count++}}</td>
										<td>{{$row->name}}</td>
										<td>{{@$row->company->name}}</td>
                                        <td>{{@$row->portal_type->name}}</td>
                                        <td><a href="javascript:void(0);" id="portel_count_{{$key}}" data-id="{{$row->id}}" onclick='potal_data("{{$row->id}}")'>{{@$row->portal->count()}}</a></td>
										<td>
                                            <a href="{{route('project.view',$row->id)}}" class="btn btn-success"><i class="fadeIn animated bx bx-list-ul"></i></a>
                                            <a href="{{route('editproject',$row->id)}}" class="btn btn-info"><i class="bx bx-edit-alt"></i></a>
                                            <a href="{{route('delete.project',$row->id)}}" class="btn btn-danger delete"><i class="bx bx-trash-alt"></i></a>
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

    <!-- Modal -->
    <div class="modal fade" id="portel_count" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Potals</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    
@endsection
@section('scripts')
    <script>
        function potal_data(data) {
            $.ajax({
                url : "{{route('getPortal')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "project_id": data
                },
                type : 'POST',
                success : function(result){
                    $("#portel_count").modal('show');
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
@stop

