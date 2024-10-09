
      <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('website.index') }}">
                <div class="sidebar-brand-icon rotate-n-15">
                    {{-- <i class="fas fa-laugh-wink"></i> --}}
                </div>
                <div class="sidebar-brand-text mx-3">E_learning<sup>2</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="index.html">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">


            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCategories"
                    aria-expanded="true" aria-controls="collapseCategories">
                    <i class="fas fa-fw fa-tags"></i>
                    <span>Categories</span>
                </a>
                <div id="collapseCategories" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="{{ route('admin.categories.index') }}">All Categories</a>
                        <a class="collapse-item" href="{{ route('admin.categories.create') }}">Add New</a>
                        <a class="collapse-item" href="{{ route('admin.catrgories.trash') }}">Trash</a>
                    </div>
                </div>
            </li>

                        <!-- Nav Item - Pages Collapse Menu -->
                        <li class="nav-item">
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsecourses"
                                aria-expanded="true" aria-controls="collapsecourses">
                                <i class="fas fa-fw fa-laptop"></i>
                                <span>Courses</span>
                            </a>
                            <div id="collapsecourses" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                                <div class="bg-white py-2 collapse-inner rounded">
                                    <a class="collapse-item" href="{{ route('admin.courses.index') }}">All Courses</a>
                                    <a class="collapse-item" href="{{ route('admin.courses.create') }}">Add New</a>
                                    <a class="collapse-item" href="{{ route('admin.courses.trash') }}">Trash</a>
                                </div>
                            </div>
                        </li>

                                                <!-- Nav Item - Pages Collapse Menu -->
                        <li class="nav-item">
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsevideos"
                                aria-expanded="true" aria-controls="collapsevideos">
                                <i class="fas fa-fw fa-play"></i>
                                <span>videos</span>
                            </a>
                            <div id="collapsevideos" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                                <div class="bg-white py-2 collapse-inner rounded">
                                    <a class="collapse-item" href="{{ route('admin.videos.index') }}">All videos</a>
                                    <a class="collapse-item" href="{{ route('admin.videos.create') }}">Add New</a>
                                    <a class="collapse-item" href="{{ route('admin.videos.trash') }}">Trash</a>
                                </div>
                            </div>
                        </li>

            <!-- Nav Item - Utilities Collapse Menu -->

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->
