<!-- Main navbar -->
<div class="navbar navbar-expand-md navbar-dark">
    <div class="navbar-brand" style="padding-top: 0; padding-bottom: 0; display: flex; justify-content: flex-start; align-items: center">
        <!--<a href="{{ route('admin.dashboard') }}" class="d-inline-block" style="color:#fff;font-weight: bold;font-size: 20px; margin: 0; padding: 0">
            mycheckpage.com
        </a>-->
        <a href="{{ route('admin.dashboard') }}" class="d-inline-block" style="color:#fff;font-weight: bold;font-size: 20px; margin: 0; padding: 0">
            <!-- TODO: Logo here -->
        </a>
    </div>

    <div class="d-md-none">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
            <i class="icon-tree5"></i>
        </button>
        <button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
            <i class="icon-paragraph-justify3"></i>
        </button>
    </div>

    <div class="collapse navbar-collapse" id="navbar-mobile">
        <ul class="navbar-nav mr-md-auto">
            <li class="nav-item">
                <a href="#" class="navbar-nav-link sidebar-control sidebar-main-toggle d-none d-md-block">
                    <i class="icon-paragraph-justify3"></i>
                </a>
            </li>
        </ul>

        <ul class="navbar-nav">

            <li class="nav-item dropdown dropdown-user">
                <a href="#" class="navbar-nav-link d-flex align-items-center dropdown-toggle" data-toggle="dropdown">
                    <img src="{{asset('modules/admin/global_assets/images/placeholders/placeholder.jpg')}}" class="rounded-circle mr-2" height="34" alt="">
                    <span>{{ Auth::guard('admin')->user()->name }} {{ Auth::guard('admin')->user()->surname }}</span>
                </a>

                <div class="dropdown-menu dropdown-menu-right">
                    <a href="{{route('user.user.edit', [\Illuminate\Support\Facades\Auth::guard('admin')->user()->id])}}" class="dropdown-item"><i class="icon-cog5"></i> Hesab tənzimləmələri</a>
                    <a href="{{route('admin.logout')}}" class="dropdown-item"><i class="icon-switch2"></i> Çıxış</a>
                </div>
            </li>
        </ul>
    </div>
</div>
<!-- /main navbar -->
