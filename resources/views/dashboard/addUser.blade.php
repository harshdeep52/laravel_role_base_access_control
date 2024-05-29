@extends("layout/main")
@section("content")

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <Br>
            <!-- <h1 class="mt-4">Add User</h1> -->
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active">Add User</li>
            </ol>


            <div class="card mb-12">
                <div class="card-header">
                    <i class="fas fa-user me-1"></i>
                    user add
                </div>
                <div class="card-body">
                    <div class="row">
                        @if(session('message'))
                        <div class="alert alert-success">
                            {{session('message')}}
                        </div>
                        @endif
                    </div>

                    <form action="/admin/addNewUser" id="usersForm" method="post">
                        @csrf
                        <div class="form-group col-md-8">
                            <label>Name</label>
                            <input type="text" class="form-control input-sm" name="name" id="name" value="{{old('name')}}" required />
                            @if ($errors->has('email'))
                            <p class="alert-danger">{{ $errors->first('name') }}</p>
                            @endif
                        </div>

                        <div class="form-group col-md-8">
                            <label>Email</label>
                            <input type="email" class="form-control input-sm" name="email" id="email" value="{{old('email')}}" required />
                            @if ($errors->has('email'))
                            <p class="alert-danger">{{ $errors->first('email') }}</p>
                            @endif
                        </div>

                        <div class="form-group col-md-8">
                            <label>password</label>
                            <input type="password" class="form-control input-sm" name="password" id="password" value="{{old('password')}}" required />
                            @if ($errors->has('password'))
                            <p class="alert-danger">{{ $errors->first('password') }}</p>
                            @endif
                        </div>

                        <div class="form-group col-md-8">
                            <label>mobile</label>
                            <input type="number" class="form-control input-sm" name="mobile" id="mobile" value="{{old('mobile')}}" required />
                            @if ($errors->has('mobile'))
                            <p class="alert-danger">{{ $errors->first('mobile') }}</p>
                            @endif
                        </div>

                        <div class="form-group col-md-8">
                            <label>Address</label>
                            <textarea class="form-control" name="address" id="address" value="{{old('address')}}" required>{{old('address')}}</textarea>
                            @if ($errors->has('address'))
                            <p class="alert-danger">{{ $errors->first('address') }}</p>
                            @endif
                        </div>

                        <div class="form-group col-md-8">
                            <label>userRole</label>
                            <select class="form-control" name="user_role" id="user_role" value="{{old('address')}}" required >
                                <option value="">Select Roles</option>
                                @foreach(userROles() as $key => $value)
                                <option value="{{ $key; }}">{{$value; }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('user_role'))
                            <p class="alert-danger">{{ $errors->first('user_role') }}</p>
                            @endif
                        </div>
                        <Br>
                        <div class="form-group">
                            <button type="submit" class="btn btn-sm btn-primary" id="addUser">add new user</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    @endsection