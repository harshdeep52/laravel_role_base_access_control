@extends("layout/main")
@section("content")

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <!-- <h1 class="mt-4">User List</h1> -->
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active">UserInfo</li>
            </ol>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    UserIfno
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-condensed">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Addrees</th>
                                <th>User Status</th>
                                <th>User Role</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$users->id}}</td>
                                <td>{{$users->name}}</td>
                                <td>{{$users->email}}</td>
                                <td>{{$users->mobile}}</td>
                                <td>{{$users->address}}</td>
                                <td>
                                    @if($users->user_status == 0)
                                    {{ "Active"}}
                                    @endif
                                    @if($users->user_status == 1)
                                    {{"Deleted"}}
                                    @endif
                                </td>
                                <td>{{$users->user_roles}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    @endsection