@extends('layouts.default')
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Product Models</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('adminDashboard')}}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{route('productModellist')}}">Product Model List</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">@if (isset($productModel)) Edit @else Add @endif Product Model</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <br>
            <!--end breadcrumb-->
           
            <div class="row">
                <div class="col-xl-11 mx-auto">
                    <div class="d-sm-flex align-items-center">
                        <h6 class="mb-0 text-uppercase">@if (isset($productModel)) Edit @else Add @endif Product Model</h6>
                        <a href="{{route('productModellist')}}" class="btn btn-primary ms-auto"><i class="bx bx-chevron-left"></i>Back</a>
                    </div>
                    
                    <hr/>
                    <div class="card border-top border-0 border-4 border-primary">
                        <div class="card-body p-5">
                            @if (isset($productModel))
                            <form class="row g-3" action="{{route('update.productModel',$productModel->id)}}" method="post">
                            @else
                            <form class="row g-3" action="{{route('create.productModel')}}" method="post">
                            @endif

                            @csrf                            
                                <div class="col-md-6">
                                    <label for="inputname" class="form-label">Model Id</label>
                                    <input type="text" class="form-control" id="modelId" name="modelId" value="{{ old('modelId', $productModel->modelId ?? '') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="inputname" class="form-label">Model Name</label>
                                    <input type="text" class="form-control" id="modelName" name="modelName" value="{{ old('modelName', $productModel->modelName ?? '') }}" required>
                                </div>
                                <div class="col-12">
										<label for="inputDescription" class="form-label">Description</label>
										<textarea class="form-control" id="description" placeholder="Description..." name="description" rows="3">{{ old('description', $productModel->description ?? '') }}</textarea>
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
@stop

