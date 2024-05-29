<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Login</title>
    <link href="{{asset('css/styles.css')}}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Login</h3>
                                </div>
                                <div class="card-body">
                                    @if(session('message'))
                                    <p class="text-center text-danger">{{ session("message") }}</p>
                                    @endif
                                    <form id="loginForm" method="post">
                                        @csrf
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="email" name="email" type="email" />
                                            <label for="inputEmail">Email address</label>

                                            <label class="text-danger">
                                                @if($errors->has('email'))
                                                <span class="error">{{ $errors->first('email') }}</span>
                                                @endif
                                            </label>

                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="password" name="password" type="password" />
                                            <label for="inputPassword">Password</label>

                                            <label class="text-danger">
                                                @if ($errors->has('password'))
                                                <span class="error">{{ $errors->first('password') }}</span>
                                                @endif
                                            </label>

                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <button class="btn btn-primary" id="login">Login</l>
                                        </div>
                                        <div class="form-group">
                                            <br>
                                            <div id="errorDiv" style="text-align:center;display:none;">
                                                <div id="errorLogin" class="error-login alert alert-danger"></div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2022</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.bundle.min.js')}}" crossorigin="anonymous"></script>
    <script src="{{asset('js/sweetalert.min.js')}}"></script>
    <script src="{{asset('js/scripts.js')}}"></script>
    <script>
        $(document).ready(function() {
            $("#loginForm").submit(function(e) {
                e.preventDefault();

                var email = $("#email").val();
                var password = $("#password").val();

                if (email == "" || email == null) {
                    swal("error","Please enter a valid email","error");
                    return;
                }
                if (password == "" || password == null) {
                    swal("error","Please enter password","error");
                    return;
                }

                $.ajax({
                    url: "/login",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    type: 'POST',
                    data: {
                        email: email,
                        password: password
                    },
                    success: function(data) {
                        $("#login").html("loading...");
                        $("#errorDiv").css("display", "block");
                        if (data.status) {
                            $("#errorDiv").removeClass("alert-danger").addClass("alert-success p-2 ").html("<div class='refreshLogin'></div><strong>" + data.message + "   <i class='fa fa-check-square'></i></strong>").fadeIn();
                            setTimeout(function() {
                                window.location = data.redirect;
                            }, 3000);
                        } else {
                            $("#login").html("Login");

                            if (typeof(data.message) == "string") {
                                console.log("string ");
                                $("#errorLogin").removeClass("alert-danger").addClass("alert-danger p-2").html("<div class='refreshLogin'></div><strong>" + data.message + "   <i class='fa fa-ban'></i></strong>").fadeIn();
                            } else {
                                var err = '';
                                $.each(data.message, function(key, value) {
                                    err += value + "<Br>";
                                });
                                console.log(err);                             
                                $("#errorDiv").removeClass("alert-danger").addClass("alert-danger p-2").html("<div class='refreshLogin'></div><strong>" + err + "   <i class='fa fa-ban'></i></strong>").fadeIn();
                            }
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>