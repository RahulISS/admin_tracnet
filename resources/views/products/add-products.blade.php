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
                            <li class="breadcrumb-item"><a href="{{route('productlist')}}">Product List</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">@if (isset($product)) Edit @else Add @endif Product</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <br>
            <!--end breadcrumb-->
           
            <div class="row">
                <div class="col-xl-11 mx-auto">
                    <div class="d-sm-flex align-items-center">
                        <h6 class="mb-0 text-uppercase">@if (isset($product)) Edit @else Add @endif Product</h6>
                        <a href="{{route('productlist')}}" class="btn btn-primary ms-auto"><i class="bx bx-chevron-left"></i>Back</a>
                    </div>                    
                    <hr/>
                    <div class="card border-top border-0 border-4 border-primary">
                        <div class="card-body p-5">
                            @if (isset($product))
                            <form class="row g-3" action="{{route('update.product',$product->id)}}" method="post">
                            @else
                            <form class="row g-3" action="{{route('create.product')}}" method="post">
                            @endif

                            @csrf                            
                                <div class="col-md-6">
                                    <label for="inputname" class="form-label">Serial Id</label>
                                    <input type="text" class="form-control" id="serial_id" name="serial_id" value="{{ old('serial_id', $product->serial_id ?? '') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="inputState" class="form-label">Product Model</label>
                                    <select id="productModel_id" name="productModel_id" class="form-select" required>
                                        <option value='' disabled selected>Choose...</option>
                                        @foreach($productModels as $row)
                                        <option value="{{$row->id}}" @if (isset($product)){{ $product->productModel_id==$row->_id?"selected":''}}@endif>{{$row->modelId}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="inputname" class="form-label">Project</label>
                                    <select id="project" name="project" class="form-select" required>
                                        <option value='' disabled selected>Choose...</option>
                                        @foreach($projects as $row)
                                        <option value="{{$row->id}}" >{{$row->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="inputname" class="form-label">Portal</label>
                                    <select id="portal_id" name="portal_id" class="form-select" required>
                                        <option value='' disabled selected>Choose...</option>
                                    </select>
                                   
                                </div>
                                <div class="col-md-6">
                                    <label for="inputname" class="form-label">Status</label>
                                    <select id="status" name="status" class="form-select" required>
                                        <option value="1" @if (isset($product)){{ $product->status==1?"selected":''}}@endif>Active</option>
                                        <option value="0" @if (isset($product)){{ $product->status==0?"selected":''}}@endif>Disable</option>
                                    </select>
                                </div> 
                                <div class="col-md-6">
                                    <label class="form-label">Start Date</label>
									<input class="result form-control" type="text" id="start_date" name="start_date" value="{{ old('start_date', $product->start_date ?? '') }}" placeholder="Date Picker...">
                                </div>
                                @if (isset($product))
                                <div class="col-md-6">
                                    <label class="form-label">End Date</label>
									<input class="result form-control" type="text" id="end_date" name="end_date" value="{{ old('end_date', $product->end_date ?? '') }}" placeholder="Date Picker...">
                                </div>                           
                                @endif                            
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
                    result.forEach(function(item) {
                        $('#portal_id').append($('<option>', {
                            value: item._id,
                            text: item.name
                        }));
                    });
                   
                }
            });
        });
        
    </script>
  
	<script>
		$(function () {
			$('#start_date').bootstrapMaterialDatePicker({
				time: false,
			});
            $('#end_date').bootstrapMaterialDatePicker({
				time: false,
			});
		});
	</script>
@stop

