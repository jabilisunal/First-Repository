@extends('admin::layouts.auth')
@section('content')
    @push('breadcrumb-buttons')
        <div class="page-title d-flex">
            <h4>
                <a class="text-black-50" href="{{route('user.user.index')}}"> İstifadəçilər</a>
            </h4>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
        <div class="header-elements d-none">
            @can('user:user-create')
            <a href="{{route('user.user.create')}}" type="button" class="btn bg-teal-400 btn-labeled btn-labeled-left">
                <b><i class="icon-plus3"></i></b> İstifadəçi əlavə et
            </a>
            @endcan
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
                            <th>Fullname</th>
                            <th>Email</th>
                            <th>Created date</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($users->count() > 0)
                            @foreach($users as $key => $value)
                                <tr>
                                    <td>{{$value->id}}</td>
                                    <td>{{$value->name}} {{$value->surname}}</td>
                                    <td>{{$value->email}}</td>
                                    <td>{{$value->created_at}}</td>
                                    <td>
                                        <div class="list-icons">
                                            @can('user:user-show')
                                            {{--<a target="_blank" href="{{route('user.user.show', [$value->id])}}" class="list-icons-item"><i class="icon-eye"></i></a>--}}
                                            @endcan
                                            @can('user:user-edit')
                                                <a href="{{route('user.user.edit', [$value->id])}}" class="list-icons-item"><i class="icon-pencil7"></i></a>
                                            @endcan
                                            @can('user:user-delete')
                                                <form action="{{ route('user.user.destroy', [$value->id]) }}" method="post">
                                                    @csrf
                                                    {{ method_field('DELETE') }}
                                                    <button type="submit" class="list-icons-item m-0 p-0 border-0"><i class="icon-trash"></i></button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr class="text-center">
                                <td colspan="6">Empty !</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            {{$users->links()}}
        </div>
    </div>
@endsection
