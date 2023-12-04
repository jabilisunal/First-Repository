<!-- Page header -->
@inject('request', 'Illuminate\Http\Request')
<div class="page-header page-header-light">
    <div class="page-header-content header-elements-md-inline">
        @stack('breadcrumb-buttons')
    </div>
    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
        <div class="d-flex">
            <div class="breadcrumb">
                <a href="{{route('admin.dashboard')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                @php($parts = explode('/', request()->path()))
                @foreach(array_splice($parts,0,3) as $path)
                    @if(!is_numeric($path))
                        <span class="breadcrumb-item active">{{ucfirst($path)}}</span>
                    @endif
                @endforeach
            </div>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>

        <div class="header-elements d-none">
            <div class="breadcrumb justify-content-center">

            </div>
        </div>
    </div>
</div>
<!-- /page header -->
