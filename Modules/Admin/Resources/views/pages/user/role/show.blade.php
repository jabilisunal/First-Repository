@extends('admin::layouts.auth')
@section('content')
    @push('breadcrumb-buttons')
    @endpush

    @can('permission:manage')

    @endcan
@endsection
