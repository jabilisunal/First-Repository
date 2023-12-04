@extends('admin::layouts.auth')
@section('content')
    @push('breadcrumb-buttons')
        <div class="page-title d-flex">
            <h4>
                <a class="text-black-50" href="{{route('user.permission.index')}}"> İcazələr</a>
            </h4>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
        <div class="header-elements d-none">
            @can('permission:manage')
                <button type="button" class="btn bg-teal-400 btn-labeled btn-labeled-left create-permission">
                    <b><i class="icon-plus3"></i></b> İcazə əlavə et
                </button>
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
    <style type="text/css">
        .card-body .font-weight-semibold, .list-group-item{ text-transform: capitalize; }
    </style>

    <div class="row">
        <div class="col-md-12">
            <div class="card p-3">
                <ul class="list-group list-group-horizontal-sm py-sm-0">
                    @foreach($guardNames as $guardName)
                        <li class="list-group-item @if(request()->input('guard_name') === $guardName->name) active @endif">
                            <a style="color: #000;" href="{{route('user.permission.index', ['guard_name' => $guardName->name])}}">{{$guardName->name}}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="table-responsive">
                    <table class="table datatable-button-html5-columns">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Ad</th>
                                <th>Açıqlama</th>
                                <th>Əlavə edilmə tarixi</th>
                                {{--<th>Hərəkətlər</th>--}}
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($permissions as $key => $permission)
                            <tr>
                                <td>{{$permission->id}}</td>
                                <td>{{$permission->name}}</td>
                                <td>{{$permission->description}}</td>
                                <td>{{$permission->created_at}}</td>
{{--                                <td>--}}
{{--                                    <div class="list-icons">--}}
{{--                                        @can('permission:manage')--}}
{{--                                            <form action="{{ route('user.permission.destroy', [$permission->id]) }}" method="post">--}}
{{--                                                @csrf--}}
{{--                                                {{ method_field('DELETE') }}--}}
{{--                                                <input type="hidden" name="guard_name" value="{{request()->input('guard_name')}}">--}}
{{--                                                <button type="submit" class="list-icons-item m-0 p-0 border-0"><i class="icon-trash"></i></button>--}}
{{--                                            </form>--}}
{{--                                        @endcan--}}
{{--                                    </div>--}}
{{--                                </td>--}}
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @can('permission:manage')
        <div class="bootbox modal fade bootbox-alert" id="addPermissionModal" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Yeni icazə</h5>
                        <button type="button" class="bootbox-close-button close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="bootbox-body">
                            <form action="{{route('user.permission.store')}}" method="post" id="add-form">
                                @csrf
                                <div class="form-group row">
                                    <label for="guard_name" class="col-form-label col-lg-12 font-weight-semibold"> İcazə tipi </label>
                                    <div class="col-lg-12">
                                        <div class="form-group-feedback form-group-feedback-right">
                                            <select name="guard_name" id="guard_name" class="select-search">
                                                @foreach($guardNames as $guardName)
                                                <option value="{{$guardName->name}}" @if(request()->input('guard_name') === $guardName->name) selected="selected" @endif>{{$guardName->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="name" class="col-form-label col-lg-12 font-weight-semibold"> İcazə adı </label>
                                    <div class="col-lg-12">
                                        <div class="form-group-feedback form-group-feedback-right">
                                            <input type="text" class="form-control" name="name" id="name" placeholder="group:permission"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="description" class="col-form-label col-lg-12 font-weight-semibold"> Açıqlama </label>
                                    <div class="col-lg-12">
                                        <div class="form-group-feedback form-group-feedback-right">
                                            <textarea type="text" class="form-control" rows="5" name="description" id="description"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" form="add-form" class="btn bg-teal-400 btn-labeled btn-labeled-left save-btn">
                            <b><i class="icon-hand"></i></b> Yadda saxla
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endcan

    <script type="text/javascript">
        $(document).ready(function (){
            $(document).on('click', '.create-permission', function (){
                $('#addPermissionModal').modal('show');
            });
        });
    </script>
@endsection
