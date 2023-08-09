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
                            <li class="breadcrumb-item"><a href="{{route('projectlist')}}">Projects Details</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">View Projects</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <br>
            <!--end breadcrumb-->

        <div class="row">
            <div class="col-xl-11 mx-auto">
                <div class="d-sm-flex align-items-center">
                    <h6 class="mb-0 text-uppercase">Project Details</h6>
                    <a href="{{route('projectlist')}}" class="btn btn-primary ms-auto"><i class="bx bx-chevron-left"></i>Back</a>
                </div>
                <hr/>
                
            <div class="card border-top border-0 border-4 border-info">
                <div class="card-body">
                    <div class="border p-4 rounded">
                            <div class="row mb-3">
                                <label for="inputEnterYourName" class="col-sm-3 col-form-label">Name</label>
                                <div class="col-sm-9">
                                    <span>{{ $projects->name }}</span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputPhoneNo2" class="col-sm-3 col-form-label">Type</label>
                                <div class="col-sm-9">
                                <span>{{ $projects->portal_type->name }}</span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputPhoneNo2" class="col-sm-3 col-form-label">Linked Company</label>
                                <div class="col-sm-9">
                                <span>{{ $projects->company->name }}</span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEmailAddress2" class="col-sm-3 col-form-label">Linked Portal</label>
                                <div class="col-sm-9">
                                @foreach ($projects->portal as $value)
                                    <ul>
                                        <li> {{ $value->name }} </li>
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

