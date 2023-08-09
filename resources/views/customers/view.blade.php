@extends('layouts.default')
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
        <div class="row">
        <div class="d-sm-flex align-items-center">
            <a href="{{route('customerlist')}}" class="btn btn-primary ms-auto"><i class="bx bx-chevron-left"></i>Back</a>
        </div>  
    <div class="col-xl-9 mx-auto">
        <h6 class="mb-0 text-uppercase">customer Details</h6>
        <hr/>
        
        <div class="card border-top border-0 border-4 border-info">
            <div class="card-body">
                <div class="border p-4 rounded">
                    <div class="row mb-3">
                        <label for="inputEnterYourName" class="col-sm-3 col-form-label">First Name</label>
                        <div class="col-sm-9">
                            <span>{{ $customer->firstname }}</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEnterYourName" class="col-sm-3 col-form-label">Last Name</label>
                        <div class="col-sm-9">
                            <span>{{ $customer->lastname }}</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEnterYourName" class="col-sm-3 col-form-label">UserName</label>
                        <div class="col-sm-9">
                            <span>{{ $customer->username }}</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputPhoneNo2" class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                        <span>{{ $customer->email }}</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputPhoneNo2" class="col-sm-3 col-form-label">SMS Number</label>
                        <div class="col-sm-9">
                        <span>{{ $customer->smsnumber }}</span>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label for="inputEmailAddress2" class="col-sm-3 col-form-label">Linked Projects</label>
                        <div class="col-sm-9">
                        @foreach ($customer->userPermission as $value)
                        @foreach($value->projects as $project)
                            <ul>
                                <li> {{ $project->name }} </li>
                            </ul>
                         @endforeach 
                         @endforeach 
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmailAddress2" class="col-sm-3 col-form-label">Linked Portals</label>
                        <div class="col-sm-9">
                        @foreach ($customer->userPermission as $value)
                         @foreach($value->portals as $portal)
                            <ul>
                                <li> {{ $portal->name }} </li>
                            </ul>
                         @endforeach 
                         @endforeach 
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmailAddress2" class="col-sm-3 col-form-label">Linked Role</label>
                        <div class="col-sm-9">
                        @foreach ($customer->userPermission as $value)
                         @foreach($value->roles as $role)
                            <ul>
                                <li> {{ $role->name }} </li>
                            </ul>
                         @endforeach 
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

