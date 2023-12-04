@extends('admin::layouts.auth')
@section('content')
    @push('breadcrumb-buttons')
        <div class="page-title d-flex">
            <h4>
                <a class="text-black-50" href="{{route('localization.language.index')}}"> Dillər</a>
            </h4>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
        @can('localization:language-create')
        <div class="header-elements d-none">
            <a href="{{route('localization.language.create')}}" type="button" class="btn bg-teal-400 btn-labeled btn-labeled-left">
                <b><i class="icon-plus3"></i></b> Dil əlavə et
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

    @can('localization:language-index')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="table-responsive">
                    <table class="table datatable-button-html5-columns">
                        <thead>
                            <tr>
                                <th>#</th>
                                <td>Adı</td>
                                <td>Qısa adı</td>
                                <td>Kodu</td>
                                <td>Status</td>
                                <td>Tarix</td>
                                <th>Hərəkətlər</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($languages as $key => $value)
                            <tr>
                                <td>{{$key + 1}}</td>
                                <td>{{$value->name}}</td>
                                <td>{{$value->short_name}}</td>
                                <td>{{$value->code}}</td>
                                <td>
                                    @if($value->status === 1)
                                        <div class="badge-success text-center w-50">Aktiv</div>
                                    @else
                                        <div class="badge-danger text-center w-50">Deaktiv</div>
                                    @endif
                                </td>
                                <td>{{$value->created_at}}</td>
                                <td>
                                    <div class="list-icons">
                                        @can('localization:language-show')
                                            <!--<a target="_blank" href="{{route('localization.language.show', [$value->id])}}" class="list-icons-item"><i class="icon-eye"></i></a>-->
                                        @endcan
                                        @can('localization:language-edit')
                                            <a href="{{route('localization.language.edit', [$value->id])}}" class="list-icons-item"><i class="icon-pencil7"></i></a>
                                        @endcan
                                        @can('localization:language-destroy')
                                            <form action="{{ route('localization.language.destroy', [$value->id]) }}" method="post">
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
