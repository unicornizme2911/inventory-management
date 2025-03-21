<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark"> <!--begin::Sidebar Brand-->
    <div class="sidebar-brand"> <!--begin::Brand Link-->
        <a href="{{ url('/' . Auth::user()->getUser_Type() . '/dashboard') }}" class="brand-link">
            <img src="{{asset('dist/assets/img/AdminLTELogo.png')}}" alt="POS Logo" class="brand-image opacity-75 shadow">
            <span class="brand-text fw-light">POS</span>
        </a>
    </div> <!--end::Sidebar Brand--> <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2"> <!--begin::Sidebar Menu-->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                <li class="nav-item"> <a href="{{ url('/' . Auth::user()->getUser_Type() . '/dashboard') }}" class="nav-link">
                    <i class="nav-icon bi bi-app-indicator"></i>
                        <p> Dashboard </p>
                    </a>
                </li>
                <li class="nav-header">MASTER</li>
                @if(Auth::user()->isAdmin())
                <li class="nav-item"> <a href="/admin/employee" class="nav-link">
                    <i class="nav-icon bi bi-person-fill"></i>
                        <p> Employee </p>
                    </a>
                </li>
                <li class="nav-item"> <a href="/admin/category" class="nav-link">
                    <i class="nav-icon bi bi-box-fill"></i>
                        <p> Category </p>
                    </a>
                </li>
                <li class="nav-item"> <a href="/admin/product" class="nav-link">
                    <i class="nav-icon bi bi-box-fill"></i>
                        <p> Product </p>
                    </a>
                </li>
                @endif
                <li class="nav-item"> <a href="{{ url('/' . Auth::user()->getUser_Type() . '/customer') }}" class="nav-link">
                    <i class="nav-icon bi bi-table"></i>
                        <p> Customer </p>
                    </a>
                </li>
                <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-box-seam-fill"></i>
                        <p>
                            Widgets
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"> <a href="./widgets/small-box.html" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Small Box</p>
                            </a> </li>
                        <li class="nav-item"> <a href="./widgets/info-box.html" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>info Box</p>
                            </a> </li>
                        <li class="nav-item"> <a href="./widgets/cards.html" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Cards</p>
                            </a> </li>
                    </ul>
                </li>
            </ul> <!--end::Sidebar Menu-->
        </nav>
    </div> <!--end::Sidebar Wrapper-->
</aside> <!--end::Sidebar--> <!--begin::App Main-->
