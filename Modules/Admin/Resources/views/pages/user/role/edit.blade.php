@extends('admin::layouts.auth')
@section('content')
    @push('breadcrumb-buttons')
        <div class="page-title d-flex">
            <h4>
                <a class="text-black-50" href="{{route('user.role.index')}}"> Rola düzəliş et</a>
            </h4>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
        <div class="header-elements d-none">
            @can('permission:manage')
                <button type="submit" form="submit-form" class="btn bg-teal-400 btn-labeled btn-labeled-left">
                    <b><i class="icon-hand"></i></b> Yadda saxla
                </button>
            @endcan
        </div>
    @endpush
    @can('permission:manage')
        <style type="text/css">
            .card-body .font-weight-semibold, .list-group-item{ text-transform: capitalize; }
        </style>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <ul class="nav nav-tabs nav-tabs-highlight nav-justified mb-0">
                        <li class="nav-item"><a href="#general" class="nav-link active" data-toggle="tab">General</a></li>
                    </ul>

                    <div class="tab-content card card-body border-top-0 rounded-0 rounded-bottom mb-0">
                        <div class="tab-pane fade show active" id="general">
                            <form action="{{route('user.role.update', [$role->id])}}" method="post" id="submit-form">
                                <fieldset class="mb-3">
                                    @csrf
                                    {{ method_field('PATCH') }}
                                    <div class="form-group row">
                                        <label for="name" class="col-form-label col-lg-2 font-weight-semibold @if($errors->has('name')) text-danger @endif">
                                            Rol adı
                                        </label>
                                        <div class="col-lg-10">
                                            <div class="form-group-feedback form-group-feedback-right">
                                                <input id="name" name="name" type="text" value="{{old('name') ?? $role->name}}" class="form-control @if($errors->has('name')) border-danger @endif">
                                                @if($errors->has('name'))
                                                    <div class="form-control-feedback text-danger">
                                                        <i class="icon-cancel-circle2"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            @if($errors->has('name'))
                                                <span class="form-text text-danger">{{$errors->first('name')}}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="role" class="col-form-label col-lg-2 font-weight-semibold @if($errors->has('permission')) text-danger @endif">
                                            İcazələr
                                        </label>
                                        <div class="col-lg-10">
                                            <div class="form-group-feedback form-group-feedback-right">
                                                <select id="role" class="select-search @if($errors->has('permission')) border-danger @endif" multiple name="permissions[]">
                                                    @foreach($permissions as $permission)
                                                        <option @if(in_array($permission->id, $role->permissions->pluck('id')->toArray(), true)) selected @endif value="{{$permission->name}}">{{$permission->name}}</option>
                                                    @endforeach
                                                </select>
                                                @if($errors->has('permission'))
                                                    <div class="form-control-feedback text-danger">
                                                        <i class="icon-cancel-circle2"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            @if($errors->has('permission'))
                                                <span class="form-text text-danger">{{$errors->first('role')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function () {
                $(document).on('change', '#permission', function (){
                    let name = $(this).data('name');
                    let token = $('meta[name="csrf-token"]').attr('content');
                    let status = 0;
                    let role_id = '{{$role->id}}';
                    if ($(this).is(':checked')) {
                        status = 1;
                    }
                    $.ajax({
                        type: "POST",
                        url: "{{route('user.role.update-permission')}}",
                        data: { role_id: role_id, permission: name, status: status,  _token: token },
                        error: function (error){
                            Swal({
                                title: "Error !",
                                text: error.responseJSON.message,
                                type: "error",
                                buttonsStyling: false,
                                confirmButtonClass: "btn btn-primary",
                            });
                        }
                    })
                });
            });
        </script>
    @endcan
@endsection
