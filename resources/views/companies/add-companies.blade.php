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
                            <li class="breadcrumb-item"><a href="{{route('companylist')}}">Companies List</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">@if (isset($companies)) Edit @else Add @endif Companies</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <br>
            <!--end breadcrumb-->
           
            <div class="row">
                <div class="col-xl-11 mx-auto">
                    <div class="d-sm-flex align-items-center">
                        <h6 class="mb-0 text-uppercase">@if (isset($companies)) Edit @else Add @endif Companies</h6>
                        <a href="{{route('companylist')}}" class="btn btn-primary ms-auto"><i class="bx bx-chevron-left"></i>Back</a>
                    </div>
                    <hr/>
                    <div class="card border-top border-0 border-4 border-primary">
                        <div class="card-body p-5">
                            @if (isset($companies))
                            <form class="row g-3" action="{{route('update.company',$companies->id)}}" method="post">
                            @else
                            <form class="row g-3" action="{{route('create.company')}}" method="post">
                            @endif

                            @csrf
                                <div class="col-md-6">
                                    <label for="inputname" class="form-label">Company Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $companies->name ?? '') }}" required>
                                </div>                                  
                                <div class="col-md-6">
                                    <label for="inputState" class="form-label">Location</label>
                                    <select id="location" name="location" class="form-select" required>
                                        <option value='' disabled selected>Choose...</option>
                                        @foreach($locationlist as $row)
                                        
                                        <option value="{{$row->id}}" @if (isset($companies)){{ $companies->location_id==$row->_id?"selected":''}}@endif>{{$row->location_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary px-5 mt-3 mr-4">Submit</button>
                                    <button type="button" id='reset-btn' class="btn btn-outline-primary px-5 mt-3">Reset</button>
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
