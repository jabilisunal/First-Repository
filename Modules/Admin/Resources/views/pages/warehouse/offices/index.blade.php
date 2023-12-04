@extends('admin::layouts.auth')
@section('content')
    @push('breadcrumb-buttons')
        <div class="page-title d-flex">
            <h4>
                <a class="text-black-50" href="{{route('warehouse.offices.index')}}"> Offislər</a>
            </h4>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
        @can('warehouse:offices-create')
            <div class="header-elements d-none">
                <a href="{{route('warehouse.offices.create')}}" type="button" class="btn bg-teal-400 btn-labeled btn-labeled-left">
                    <b><i class="icon-plus3"></i></b> Offis əlavə et
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

    @can('warehouse:offices-index')
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="table-responsive">
                        <table class="table datatable-button-html5-columns">
                            <thead>
                            <tr>
                                <th>#</th>
                                <td>Adı</td>
                                <td>Address</td>
                                <td>Status</td>
                                <td>Tarix</td>
                                <th>Hərəkətlər</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($types as $key => $value)
                                <tr>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$value->name}}</td>
                                    <td>{{$value->address}}</td>
                                    <td>{{$value->status}}</td>
                                    <td>{{$value->created_at}}</td>
                                    <td>
                                        <div class="list-icons">
                                            @can('warehouse:offices-show')
                                                <a target="_blank" href="{{route('warehouse.offices.show', [$value->id])}}" class="list-icons-item"><i class="icon-eye"></i></a>
                                            @endcan
                                            @can('warehouse:offices-edit')
                                                <a href="{{route('warehouse.offices.edit', [$value->id])}}" class="list-icons-item"><i class="icon-pencil7"></i></a>
                                            @endcan
                                            @can('warehouse:offices-destroy')
                                                <form action="{{ route('warehouse.offices.destroy', [$value->id]) }}" method="post">
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
