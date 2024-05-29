<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    @if(session()->get('user_role') == "admin")
                    <a class="nav-link" href="/admin/addUser">
                        <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                        Add Users
                    </a>
                    <a class="nav-link" href="/admin/usersList">
                        <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                        User List
                    </a>
                    @endif
                    @if(session()->get('user_role') == "user")
                    <a class="nav-link" href="/user/userDashboard">
                        <div class="sb-nav-link-icon"><i class="fas fa-table"></i>User Dashboard</div>

                    </a>
                    @endif
                </div>
            </div>
            <div class="sb-sidenav-footer">
                <div class="small">Logged in as:</div>
                {{session()->get('name');}}
            </div>
        </nav>
    </div>