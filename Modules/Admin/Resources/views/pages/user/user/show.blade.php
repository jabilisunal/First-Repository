@extends('admin::layouts.auth')
@section('content')
    @push('breadcrumb-buttons')

    @endpush

    @can('user:user-show')

    @endcan
@endsection
