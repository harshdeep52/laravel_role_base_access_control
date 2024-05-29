@extends("layout/main")
@section("content")

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <!-- <h1 class="mt-4">User List</h1> -->
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active">User List</li>
            </ol>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Users List
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-condensed" id="allUsersTable">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>User Role</th>
                                <th>User Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>


    <!-- Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="updateusersForm" method="post">
                        @csrf
                        <input type="hidden" id="id" name="id" />
                        <div class="form-group col-md-12">
                            <label>Name</label>
                            <input type="text" class="form-control input-sm" name="name" id="name" />
                            @if ($errors->has('email'))
                            <p class="alert-danger">{{ $errors->first('name') }}</p>
                            @endif
                        </div>

                        <div class="form-group col-md-12">
                            <label>Email</label>
                            <input type="email" class="form-control input-sm" name="email" id="email" />
                            @if ($errors->has('email'))
                            <p class="alert-danger">{{ $errors->first('email') }}</p>
                            @endif
                        </div>

                        <div class="form-group col-md-12">
                            <label>mobile</label>
                            <input type="number" class="form-control input-sm" name="mobile" id="mobile" />
                            @if ($errors->has('mobile'))
                            <p class="alert-danger">{{ $errors->first('mobile') }}</p>
                            @endif
                        </div>

                        <div class="form-group col-md-12">
                            <label>Address</label>
                            <textarea class="form-control" name="address" id="address"></textarea>
                            @if ($errors->has('address'))
                            <p class="alert-danger">{{ $errors->first('address') }}</p>
                            @endif
                        </div>

                        <div class="form-group col-md-12">
                            <label>userRole</label>
                            <select class="form-control" name="user_role" id="user_role">
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
                            <button type="submit" class="btn btn-primary">Update</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">


                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('js/jquery.min.js')}}"></script>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                }
            });

            $("#allUsersTable").dataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('/admin/usersList') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'mobile',
                        name: 'mobile'
                    },
                    {
                        data: 'user_roles',
                        name: 'user_roles'
                    },
                    {
                        data: 'user_status',
                        name: 'user_status',
                        data: function(row, type, val, meta) {
                            if (row.user_status == 1) {
                                return "Deleted";
                            } else {
                                return "Active";
                            }
                        }
                    },

                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    },
                ],
                order: [
                    [0, 'desc']
                ]
            });

            function userStatus(data, type, row) {
                console.log(row);
            }

            $("#updateusersForm").submit(function(e) {
                e.preventDefault();

                $.ajax({
                    type: "POST",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf_token"]').attr('content')
                    },
                    data: $('#updateusersForm').serialize(),
                    url: "/admin/udpateUser",
                    dataType: "JSON",
                    cache: false,
                    success: function(data) {
                        if (data.status) {
                            $('#allUsersTable').DataTable().ajax.reload();
                            swal("Success", data.message, "success");
                            $("#editUserModal").modal("hide");
                        } else {
                            swal("Error", data.message, "error");
                        }
                    }
                });
            });
        });

        function editUser(id) {
            $("#editUserModal").modal("show");
            $.ajax({
                type: "get",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf_token"]').attr('content')
                },
                data: {
                    "id": id
                },
                url: "/admin/getUsersDetails",
                dataType: "JSON",
                cache: false,
                success: function(data) {
                    $("#id").val(data.data[0].id);
                    $("#name").val(data.data[0].name);
                    $("#email").val(data.data[0].email);
                    $("#mobile").val(data.data[0].mobile);
                    $("#address").val(data.data[0].address);
                    $("#user_role").val(data.data[0].user_roles);
                }
            });
        }

        function deleteUser(id) {
            swal({
                    title: "Are you sure ??",
                    text: "Your want to delete this record!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes",
                    closeOnConfirm: false,
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            type: "POST",
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf_token"]').attr('content')
                            },
                            url: "/admin/deteleUser",
                            data: {
                                "id": id
                            },
                            dataType: "JSON",
                            cache: false,
                            success: function(data) {
                                if (data.status) {
                                    $('#allUsersTable').DataTable().ajax.reload();
                                    swal("Success", data.message, "success");
                                    $("#editUserModal").modal("hide");
                                } else {
                                    swal("Error", data.message, "error");
                                }
                            }
                        });
                    } else {
                        swal("Your record is safe!");
                    }
                });

        }
    </script>
    @endsection