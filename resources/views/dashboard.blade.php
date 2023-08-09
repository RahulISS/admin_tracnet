@extends('layouts.default')
@section('content')
<div class="page-wrapper">
    <div class="page-content">
    <h6 class="mb-0 text-uppercase">Welcome to the Admin Dashboard</h6>
	<hr/>
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
					<div class="col">
						<div class="card radius-10 bg-primary bg-gradient">
						<a href = "{{route('companylist')}}">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-white">Total Comapnies</p>
										<h4 class="my-1 text-white">{{ $companyCount }}</h4>
									</div>
									<div class="widgets-icons bg-white text-dark ms-auto"><i class='bx bx-line-chart-down'></i>
									</div>
								</div>
							</div>
						</a>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 bg-danger bg-gradient">
						<a href = "{{route('projectlist')}}">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-white">Total Projects</p>
										<h4 class="my-1 text-white">{{ $projectCount }}</h4>
									</div>
									<div class="widgets-icons bg-white text-success ms-auto"><i class="bx bxs-wallet"></i>
									</div>
								</div>
							</div>
                        </a>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 bg-warning bg-gradient">
						<a href = "{{route('portallist')}}">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-dark">Total Portals</p>
										<h4 class="text-dark my-1">{{ $portals }}</h4>
									</div>
									<div class="widgets-icons bg-white text-danger ms-auto"><i class="bx bxs-binoculars"></i>
									</div>
								</div>
							</div>
                        </a>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 bg-success bg-gradient">
						<a href = "{{route('customerlist')}}">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-white">Total Users</p>
										<h4 class="my-1 text-white">{{ $users }}</h4>
									</div>
									<div class="widgets-icons bg-white text-dark ms-auto"><i class="bx bxs-group"></i>
									</div>
								</div>
							</div>
                        </a>
						</div>
					</div>
					<!-- <div class="col">
						<div class="card radius-10 bg-success">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-white">Revenue</p>
										<h4 class="my-1 text-white">$4805</h4>
										<p class="mb-0 font-13 text-white"><i class="bx bxs-up-arrow align-middle"></i>$34 from last week</p>
									</div>
									<div class="widgets-icons bg-white text-success ms-auto"><i class="bx bxs-wallet"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 bg-info">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-dark">Total Customers</p>
										<h4 class="my-1 text-dark">8.4K</h4>
										<p class="mb-0 font-13 text-dark"><i class="bx bxs-up-arrow align-middle"></i>$24 from last week</p>
									</div>
									<div class="widgets-icons bg-white text-dark ms-auto"><i class="bx bxs-group"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 bg-danger">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-white">Store Visitors</p>
										<h4 class="my-1 text-white">59K</h4>
										<p class="mb-0 font-13 text-white"><i class="bx bxs-down-arrow align-middle"></i>$34 from last week</p>
									</div>
									<div class="widgets-icons bg-white text-danger ms-auto"><i class="bx bxs-binoculars"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 bg-warning">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-dark">Bounce Rate</p>
										<h4 class="my-1 text-dark">34.46%</h4>
										<p class="mb-0 font-13 text-dark"><i class="bx bxs-down-arrow align-middle"></i>12.2% from last week</p>
									</div>
									<div class="widgets-icons bg-white text-dark ms-auto"><i class='bx bx-line-chart-down'></i>
									</div>
								</div>
							</div>
						</div>
					</div> -->
				</div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    $(function () {
        
        var table = $('#tablefilter').DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            ajax: "",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'mobile', name: 'mobile'},
                {data: 'totalworry', name: 'totalworry'},
                {data: 'incompleteWorry', name: 'incompleteWorry'},
                {data: 'totalhappiness', name: 'totalhappiness'},
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