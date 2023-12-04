@extends('admin::layouts.auth')
@section('content')
    @push('breadcrumb-buttons')
        <div class="page-title d-flex">
            <h4>
                <a class="text-black-50" href="{{route('user.role.index')}}"> Rol əlavə et</a>
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
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body mt-3">
                        <form action="{{route('user.role.store')}}" method="post" id="submit-form">
                            <fieldset class="mb-3">
                                @csrf
                                <div class="form-group row">
                                    <label for="name" class="col-form-label col-lg-2 font-weight-semibold @if($errors->has('name')) text-danger @endif">
                                        Rol adı
                                    </label>
                                    <div class="col-lg-10">
                                        <div class="form-group-feedback form-group-feedback-right">
                                            <input id="name" name="name" type="text" value="{{old('name')}}" class="form-control @if($errors->has('name')) border-danger @endif">
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
                                                    <option value="{{$permission->name}}">{{$permission->name}}</option>
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
    @endcan
@endsection
