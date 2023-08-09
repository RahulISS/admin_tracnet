@extends('layouts.default')
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Sensors</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('adminDashboard')}}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{route('sensorlist')}}">Sensor List</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">@if (isset($sensor)) Edit @else Add @endif Sensor</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <br>
            <!--end breadcrumb-->
           
            <div class="row">
                <div class="col-xl-11 mx-auto">
                    <div class="d-sm-flex align-items-center">
                        <h6 class="mb-0 text-uppercase">@if (isset($sensor)) Edit @else Add @endif Sensor</h6>
                        <a href="{{route('sensorlist')}}" class="btn btn-primary ms-auto"><i class="bx bx-chevron-left"></i>Back</a>
                    </div>                    
                    <hr/>
                    <div class="card border-top border-0 border-4 border-primary">
                        <div class="card-body p-5">
                            @if (isset($sensor))
                            <form class="row g-3" action="{{route('update.sensor',$sensor->id)}}" method="post">
                            @else
                            <form class="row g-3" action="{{route('create.sensor')}}" method="post">
                            @endif

                            @csrf                            
                                <div class="col-md-6">
                                    <label for="inputname" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $sensor->name ?? '') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="inputname" class="form-label">Type</label>
                                    <input type="text" class="form-control" id="type" name="type" value="{{ old('sensor', $sensor->type ?? '') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="inputname" class="form-label">Kind</label>
                                    <input type="text" class="form-control" id="kind" name="kind" value="{{ old('sensor', $sensor->kind ?? '') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="inputState" class="form-label">Unit</label>
                                    <select id="unit" name="unit" class="form-select" required>
                                        <option value='' disabled selected>Choose...</option>
                                        @foreach($units as $row)
                                        <option value="{{$row->id}}" @if (isset($sensor)){{ $sensor->unit_id==$row->_id?"selected":''}}@endif>{{$row->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="inputname" class="form-label">Decimal Places</label>
                                    <input type="text" class="form-control" id="decimalPlaces" name="decimalPlaces" value="{{ old('sensor', $sensor->decimalPlaces ?? '') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="inputname" class="form-label">hisFunc</label>
                                    <input type="text" class="form-control" id="hisFunc" name="hisFunc" value="{{ old('sensor', $sensor->hisFunc ?? '') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="inputname" class="form-label">Project</label>
                                    <select id="project" name="project" class="form-select" required>
                                        <option value='' disabled selected>Choose...</option>
                                        @foreach($projects as $row)
                                        <option value="{{$row->id}}">{{$row->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="inputname" class="form-label">Portal</label>
                                    <select id="multiple_portal" name="multiple_portal[]" data-placeholder="Choose anything"  multiple="multiple"  class="multiple-select" required>
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
                    $('#multiple_portal').empty();            
                    result.forEach(function(item) {
                        $('#multiple_portal').append($('<option>', {
                            value: item._id,
                            text: item.name
                        }));
                    });
                   
                }
            });
        });
        
    </script>
@stop

