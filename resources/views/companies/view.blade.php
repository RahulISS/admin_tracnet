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
                            <li class="breadcrumb-item"><a href="{{route('companylist')}}">Companies Details</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">View Companies</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <br>
            <!--end breadcrumb-->

        <div class="row">
            <div class="col-xl-11 mx-auto">
                <div class="d-sm-flex align-items-center">
                    <h6 class="mb-0 text-uppercase">Company Details</h6>
                    <a href="{{route('companylist')}}" class="btn btn-primary ms-auto"><i class="bx bx-chevron-left"></i>Back</a>
                </div>
                <hr/>
                
            <div class="card border-top border-0 border-4 border-info">
                <div class="card-body">
                    <div class="border p-4 rounded">
                            <div class="row mb-3">
                                <label for="inputEnterYourName" class="col-sm-3 col-form-label">Name</label>
                                <div class="col-sm-9">
                                    <span>{{ $companies->name }}</span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputPhoneNo2" class="col-sm-3 col-form-label">Location</label>
                                <div class="col-sm-9">
                                <span>{{ $companies->location->location_name }}</span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEmailAddress2" class="col-sm-3 col-form-label">Linked Projects</label>
                                <div class="col-sm-9">
                                @foreach ($companies->projects as $value)
                                    <ul>
                                        <li> {{ $value->name }}</li>
                                    </ul>
                                @endforeach 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection

