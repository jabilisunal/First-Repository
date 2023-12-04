<!-- Main sidebar -->
<div class="sidebar sidebar-dark sidebar-main sidebar-expand-md">

    <!-- Sidebar mobile toggler -->
    <div class="sidebar-mobile-toggler text-center">
        <a href="#" class="sidebar-mobile-main-toggle">
            <i class="icon-arrow-left8"></i>
        </a>
        Naviqasiya
        <a href="#" class="sidebar-mobile-expand">
            <i class="icon-screen-full"></i>
            <i class="icon-screen-normal"></i>
        </a>
    </div>
    <!-- /sidebar mobile toggler -->


    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- Main navigation -->
        <div class="card card-sidebar-mobile">
            <ul class="nav nav-sidebar" data-nav-type="accordion">
                <!-- Main -->
                <!--<li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Main</div> <i class="icon-menu" title="Main"></i></li>-->

                @can('dashboard:index')
                    <li class="nav-item">
                        <a href="{{route('admin.dashboard')}}" class="{{ (request()->is('admin')) ? 'active nav-link' : 'nav-link' }}">
                            <i class="icon-home4"></i>
                            <span>İdarə paneli</span>
                        </a>
                    </li>
                @endcan

                @can('user:user-index')
                    <li class="nav-item nav-item-submenu {{ (request()->is('admin/user*')) ? 'nav-item-expanded nav-item-open' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="icon-users"></i> <span>İstifadəçilər</span>
                        </a>
                        <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                            @can('user:user-index')
                                <li class="nav-item">
                                    <a href="{{route('user.user.index')}}" class="{{ (request()->is('admin/user/user*')) ? 'nav-link active' : 'nav-link' }}">
                                        <i class="icon-user"></i>
                                        <span>İstifadəçilər</span>
                                    </a>
                                </li>
                            @endcan
                            @can('permission:manage')
                                <li class="nav-item">
                                    <a href="{{route('user.role.index')}}" class="{{ (request()->is('admin/user/role*')) ? 'nav-link active' : 'nav-link' }}">
                                        <i class="icon-cog"></i>
                                        <span>Rollar</span>
                                    </a>
                                </li>
                            @endcan
                            @can('permission:manage')
                                <li class="nav-item">
                                    <a href="{{route('user.permission.index', ['guard_name' => 'admin'])}}" class="{{ (request()->is('admin/user/permission*')) ? 'nav-link active' : 'nav-link' }}">
                                        <i class="icon-lock"></i>
                                        <span>İcazələr</span>
                                    </a>
                                </li>
                            @endcan
                            @can('user:position-index')
                                <li class="nav-item">
                                    <a href="{{route('user.position.index')}}" class="{{ (request()->is('admin/user/position*')) ? 'nav-link active' : 'nav-link' }}">
                                        <i class="icon-move"></i>
                                        <span>Pozisiyalar</span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                @can('ecommerce:ecommerce-index')
                    <li class="nav-item nav-item-submenu {{ (request()->is('admin/ecommerce*')) ? 'nav-item-expanded nav-item-open' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="icon-stack3"></i> <span>E-Kommersiya</span>
                        </a>
                        <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                            @can('ecommerce:brand-index')
                                <li class="nav-item">
                                    <a href="{{route('ecommerce.brand.index')}}" class="{{ (request()->is('admin/ecommerce/brand*')) ? 'nav-link active' : 'nav-link' }}">
                                        <i class="icon-price-tags2"></i>
                                        <span>Brendlər</span>
                                    </a>
                                </li>
                            @endcan

                            @can('ecommerce:category-index')
                                <li class="nav-item">
                                    <a href="{{route('ecommerce.category.index')}}" class="{{ (request()->is('admin/ecommerce/category*')) ? 'nav-link active' : 'nav-link' }}">
                                        <i class="icon-cabinet"></i>
                                        <span>Kateqoriyalar</span>
                                    </a>
                                </li>
                            @endcan

                            @can('ecommerce:tags-index')
                                <li class="nav-item">
                                    <a href="{{route('ecommerce.tags.index')}}" class="{{ (request()->is('admin/ecommerce/tags*')) ? 'nav-link active' : 'nav-link' }}">
                                        <i class="icon-price-tag"></i>
                                        <span>Etiketlər</span>
                                    </a>
                                </li>
                            @endcan

                            @can('ecommerce:region-groups-index')
                                <li class="nav-item">
                                    <a href="{{route('ecommerce.region-groups.index')}}" class="{{ (request()->is('admin/ecommerce/region-groups*')) ? 'nav-link active' : 'nav-link' }}">
                                        <i class="icon-direction"></i>
                                        <span>Rayon Qurupları</span>
                                    </a>
                                </li>
                            @endcan

                            @can('ecommerce:destinations-index')
                                <li class="nav-item">
                                    <a href="{{route('ecommerce.destinations.index')}}" class="{{ (request()->is('admin/ecommerce/destinations*')) ? 'nav-link active' : 'nav-link' }}">
                                        <i class="icon-direction"></i>
                                        <span>Rayonlar</span>
                                    </a>
                                </li>
                            @endcan

                            @can('ecommerce:facilities-index')
                                <li class="nav-item">
                                    <a href="{{route('ecommerce.facilities.index')}}" class="{{ (request()->is('admin/ecommerce/facilities*')) ? 'nav-link active' : 'nav-link' }}">
                                        <i class="icon-feed"></i>
                                        <span>Xüsusiyətlər</span>
                                    </a>
                                </li>
                            @endcan

                            @can('ecommerce:places-index')
                                <li class="nav-item">
                                    <a href="{{route('ecommerce.places.index')}}" class="{{ (request()->is('admin/ecommerce/places*')) ? 'nav-link active' : 'nav-link' }}">
                                        <i class="icon-earth"></i>
                                        <span>Yerlər</span>
                                    </a>
                                </li>
                            @endcan

                            @can('ecommerce:tours-index')
                                <li class="nav-item">
                                    <a href="{{route('ecommerce.tours.index')}}" class="{{ (request()->is('admin/ecommerce/tours*')) ? 'nav-link active' : 'nav-link' }}">
                                        <i class="icon-reset"></i>
                                        <span>Turlar</span>
                                    </a>
                                </li>
                            @endcan

                            @can('ecommerce:rents-index')
                                <li class="nav-item">
                                    <a href="{{route('ecommerce.rents.index')}}" class="{{ (request()->is('admin/ecommerce/rents*')) ? 'nav-link active' : 'nav-link' }}">
                                        <i class="icon-car2"></i>
                                        <span>Rent Carlar</span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                @can('warehouse:warehouse-index')
                    <li class="nav-item nav-item-submenu {{ (request()->is('admin/warehouse*')) ? 'nav-item-expanded nav-item-open' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="icon-shuffle"></i> <span>Anbar</span>
                        </a>
                        <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                            @can('warehouse:offices-index')
                                <li class="nav-item">
                                    <a href="{{route('warehouse.offices.index')}}" class="{{ (request()->is('admin/warehouse/offices*')) ? 'nav-link active' : 'nav-link' }}">
                                        <i class="icon-office"></i>
                                        <span>Offislər</span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                @can('content:content-index')
                    <li class="nav-item nav-item-submenu {{ (request()->is('admin/content*')) ? 'nav-item-expanded nav-item-open' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="icon-pie-chart4"></i> <span>Məzmun</span>
                        </a>
                        <ul class="nav nav-group-sub" data-submenu-title="Layouts">

                            @can('content:banner-type-index')
                                <li class="nav-item">
                                    <a href="{{route('content.banner-type.index')}}" class="{{ (request()->is('admin/content/banner-type*')) ? 'nav-link active' : 'nav-link' }}">
                                        <i class="icon-quill4"></i>
                                        <span>Banner tipləri</span>
                                    </a>
                                </li>
                            @endcan

                            @can('content:banner-index')
                                <li class="nav-item">
                                    <a href="{{route('content.banner.index')}}" class="{{ (request()->is('admin/content/banner/*')) ? 'nav-link active' : 'nav-link' }}">
                                        <i class="icon-stack3"></i>
                                        <span>Bannerlər</span>
                                    </a>
                                </li>
                            @endcan

                            @can('content:menu-type-index')
                                <li class="nav-item">
                                    <a href="{{route('content.menu-type.index')}}" class="{{ (request()->is('admin/content/menu-type*')) ? 'nav-link active' : 'nav-link' }}">
                                        <i class="icon-books"></i>
                                        <span>Menyu tipləri</span>
                                    </a>
                                </li>
                            @endcan

                            @can('content:menu-index')
                                <li class="nav-item">
                                    <a href="{{route('content.menu.index')}}" class="{{ (request()->is('admin/content/menu/*')) ? 'nav-link active' : 'nav-link' }}">
                                        <i class="icon-tree5"></i>
                                        <span>Menyular</span>
                                    </a>
                                </li>
                            @endcan

                            @can('content:partner-index')
                                <li class="nav-item">
                                    <a href="{{route('content.partner.index')}}" class="{{ (request()->is('admin/content/partner*')) ? 'nav-link active' : 'nav-link' }}">
                                        <i class="icon-rocket"></i>
                                        <span>Partnyorlar</span>
                                    </a>
                                </li>
                            @endcan

                            @can('content:pages-index')
                                <li class="nav-item">
                                    <a href="{{route('content.pages.index')}}" class="{{ (request()->is('admin/content/pages*')) ? 'nav-link active' : 'nav-link' }}">
                                        <i class="icon-book2"></i>
                                        <span>Səhifələr</span>
                                    </a>
                                </li>
                            @endcan

                            @can('content:post-index')
                                <li class="nav-item">
                                    <a href="{{route('content.posts.index')}}" class="{{ (request()->is('admin/content/posts*')) ? 'nav-link active' : 'nav-link' }}">
                                        <i class="icon-blog"></i>
                                        <span>Bloglar</span>
                                    </a>
                                </li>
                            @endcan

                            @can('content:features-index')
                                <li class="nav-item">
                                    <a href="{{route('content.features.index')}}" class="{{ (request()->is('admin/content/features*')) ? 'nav-link active' : 'nav-link' }}">
                                        <i class="icon-paint-format"></i>
                                        <span>Xüsusiyyətlər</span>
                                    </a>
                                </li>
                            @endcan

                            @can('content:faqs-index')
                                <li class="nav-item">
                                    <a href="{{route('content.faqs.index')}}" class="{{ (request()->is('admin/content/faqs*')) ? 'nav-link active' : 'nav-link' }}">
                                        <i class="icon-question4"></i>
                                        <span>FAQ</span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                @can('localization:localization-index')
                    <li class="nav-item nav-item-submenu {{ (request()->is('admin/localization*')) ? 'nav-item-expanded nav-item-open' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="icon-sphere"></i> <span>Lokalizasiya</span>
                        </a>
                        <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                            @can('localization:language-index')
                                <li class="nav-item">
                                    <a href="{{route('localization.language.index')}}" class="{{ (request()->is('admin/localization/language*')) ? 'nav-link active' : 'nav-link' }}">
                                        <i class="icon-flag3"></i>
                                        <span>Dillər</span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan


                @can('filemanager:filemanager-index')
                    <li class="nav-item">
                        <a href="{{route('filemanager.filemanager.index')}}" class="{{ (request()->is('admin/filemanager/*')) ? 'active nav-link' : 'nav-link' }}">
                            <i class="icon-folder-open"></i>
                            <span>Fayl Manager</span>
                        </a>
                    </li>
                @endcan

                @can('settings:settings-index')
                <li class="nav-item">
                    <a href="{{route('settings.general.index')}}" class="{{ (request()->is('admin/settings/general*')) ? 'active nav-link' : 'nav-link' }}">
                        <i class="icon-cog"></i>
                        <span>Tənzimləmələr</span>
                    </a>
                </li>
                @endcan

            </ul>
        </div>
        <!-- /main navigation -->
    </div>
    <!-- /sidebar content -->
</div>
<!-- /main sidebar -->
