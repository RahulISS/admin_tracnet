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
                            <li class="breadcrumb-item"><a href="{{route('projectlist')}}">Project List</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">@if (isset($projects)) Edit @else Add @endif Project</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <br>
            <!--end breadcrumb-->
           
            <div class="row">
                <div class="col-xl-11 mx-auto">
                    <div class="d-sm-flex align-items-center">
                        <h6 class="mb-0 text-uppercase">@if (isset($projects)) Edit @else Add @endif Project</h6>
                        <a href="{{route('projectlist')}}" class="btn btn-primary ms-auto"><i class="bx bx-chevron-left"></i>Back</a>
                    </div>
                    <hr/>
                    <div class="card border-top border-0 border-4 border-primary">
                        <div class="card-body p-5">
                            @if (isset($projects))
                            <form class="row g-3" action="{{route('update.project',$projects->id)}}" method="post">
                            @else
                            <form class="row g-3" action="{{route('create.project')}}" method="post">
                            @endif

                            @csrf
                                <div class="col-md-12">
                                    <label for="inputState" class="form-label">Companies</label>
                                    <select id="company_id" name="company_id" class="form-select" required>
                                        <option value='' disabled selected>Choose...</option>
                                        @foreach($Companieslist as $row)
                                        
                                        <option value="{{$row->id}}" @if (isset($projects)){{ $projects->company_id==$row->_id?"selected":''}}@endif>{{$row->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label for="inputname" class="form-label">Project Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $projects->name ?? '') }}" required>
                                </div>
                                <div class="col-md-12">
                                    <label for="inputState" class="form-label">Project Types</label>
                                    <select id="portalType" name="portalTypes" class="form-select" required>
                                        <option value='' disabled selected>Choose...</option>
                                        @foreach($portalTypelist as $row)
                                        <option value="{{$row->id}}" @if (isset($projects)){{ $projects->portal_Types_id==$row->_id?"selected":''}}@endif>{{$row->name}}</option>
                                        @endforeach
                                    </select>
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

