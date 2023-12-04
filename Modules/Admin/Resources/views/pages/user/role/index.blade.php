@extends('admin::layouts.auth')
@section('content')
    @push('breadcrumb-buttons')
        <div class="page-title d-flex">
            <h4>
                <a class="text-black-50" href="{{route('user.role.index')}}"> Rollar</a>
            </h4>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
        <div class="header-elements d-none">
            <a href="{{route('user.role.create')}}" type="button" class="btn bg-teal-400 btn-labeled btn-labeled-left">
                <b><i class="icon-plus3"></i></b> Rol əlavə et
            </a>
        </div>
    @endpush

    @if (session('message'))
        <section id="errors" class="pb-2">
            <div class="row">
                <div class="col-md-12">
                    <div class="alert m-0 alert-{{session('type')}}">
                        {{ session('message') }}
                    </div>
                </div>
            </div>
        </section>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="table-responsive">
                    <table class="table datatable-button-html5-columns">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Rol adı</th>
                            <th>Əlavə edilmə tarixi</th>
                            <th>Hərəkətlər</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($roles as $key => $value)
                            <tr>
                                <td>{{$value->id}}</td>
                                <td>{{$value->name}}</td>
                                <td>{{$value->created_at}}</td>
                                <td>
                                    <div class="list-icons">

                                        @can('permission:manage')
                                            <a href="{{route('user.role.edit', [$value->id])}}" class="list-icons-item"><i class="icon-pencil7"></i></a>
                                        @endcan

                                        @can('permission:manage')
                                            <form action="{{ route('user.role.destroy', [$value->id]) }}" method="post">
                                                @csrf
                                                {{ method_field('DELETE') }}
                                                <button type="submit" class="list-icons-item m-0 p-0 border-0"><i class="icon-trash"></i></button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
