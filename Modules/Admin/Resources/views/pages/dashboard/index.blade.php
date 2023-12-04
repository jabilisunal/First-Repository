@extends('admin::layouts.auth')
@section('content')

    @push('breadcrumb-buttons')
        <div class="page-title d-flex">
            <h4>
                <a class="text-black-50" href="{{route('admin.dashboard')}}"> İdarə paneli</a>
            </h4>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
    @endpush

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection