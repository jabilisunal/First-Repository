@extends('admin::layouts.auth')
@section('content')
    @push('breadcrumb-buttons')
        <div class="page-title d-flex">
            <h4>
                <a class="text-black-50" href="{{route('content.menu.index')}}"> Menuyular</a>
            </h4>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
        @can('content:menu-create')
        <div class="header-elements d-none">
            <a href="{{route('content.menu.create')}}" type="button" class="btn bg-teal-400 btn-labeled btn-labeled-left">
                <b><i class="icon-plus3"></i></b> Menyu əlavə et
            </a>
        </div>
        @endcan
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

    @can('content:menu-index')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="table-responsive">
                    <table class="table datatable-button-html5-columns">
                        <thead>
                            <tr>
                                <th>#</th>
                                <td>Ana Menyu</td>
                                <td>Slug</td>
                                <td>Adı</td>
                                <td>Status</td>
                                <td>Tarix</td>
                                <th>Hərəkətlər</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($menus as $key => $value)
                            <tr>
                                <td>{{$key + 1}}</td>
                                <td>{{$value->parent->title ?? ''}}</td>
                                <td>{{$value->slug}}</td>
                                <td>{{$value->title}}</td>
                                <td>
                                    @if($value->status === 1)
                                        <span class="badge bg-success">Aktiv</span>
                                    @else
                                        <span class="badge bg-danger">Deaktiv</span>
                                    @endif
                                </td>
                                <td>{{$value->created_at}}</td>
                                <td>
                                    <div class="list-icons">
                                        @can('content:menu-show')
                                            <a target="_blank" href="{{route('content.menu.show', [$value->id])}}" class="list-icons-item"><i class="icon-eye"></i></a>
                                        @endcan
                                        @can('content:menu-edit')
                                            <a href="{{route('content.menu.edit', [$value->id])}}" class="list-icons-item"><i class="icon-pencil7"></i></a>
                                        @endcan
                                        @can('content:menu-destroy')
                                            <form action="{{ route('content.menu.destroy', [$value->id]) }}" method="post">
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
    @endcan
@endsection
