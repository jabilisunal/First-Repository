@extends('admin::layouts.auth')
@section('content')
    @push('breadcrumb-buttons')
        <div class="page-title d-flex">
            <h4>
                <a class="text-black-50" href="{{route('user.user.index')}}"> İstifadəçi əlavə et</a>
            </h4>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
        <div class="header-elements d-none">
            @can('user:user-create')
                <button type="submit" form="submit-form" class="btn bg-teal-400 btn-labeled btn-labeled-left">
                    <b><i class="icon-hand"></i></b> Yadda saxla
                </button>
            @endcan
        </div>
    @endpush

    @can('user:user-store')

        <div class="row">
            <div class="col-md-12">
                <form autocomplete="off" action="{{route('user.user.store')}}" method="post" id="submit-form" enctype="multipart/form-data">
                    <ul class="nav nav-tabs nav-tabs-highlight mb-0">
                        <li class="nav-item"><a href="#general" class="nav-link active" data-toggle="tab">Ümumi məlumatlar</a></li>
                        <li class="nav-item"><a href="#permissions" class="nav-link" data-toggle="tab">İcazələr</a></li>
                    </ul>
                    <div class="card border-top-0 border-right-1 border-bottom-1 border-left-1" style="border-radius: 0; border-color: #ddd;">
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="general">
                                    <fieldset class="mb-3">
                                        @csrf
                                        <div class="form-group row">
                                            <label for="name" class="col-form-label col-lg-2 font-weight-semibold @if($errors->has('name')) text-danger @endif">
                                                Ad
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
                                            <label for="surname" class="col-form-label col-lg-2 font-weight-semibold @if($errors->has('surname')) text-danger @endif">
                                                Soyad
                                            </label>
                                            <div class="col-lg-10">
                                                <div class="form-group-feedback form-group-feedback-right">
                                                    <input id="surname" name="surname" type="text" value="{{old('surname')}}" class="form-control @if($errors->has('surname')) border-danger @endif">
                                                    @if($errors->has('surname'))
                                                        <div class="form-control-feedback text-danger">
                                                            <i class="icon-cancel-circle2"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                @if($errors->has('surname'))
                                                    <span class="form-text text-danger">{{$errors->first('surname')}}</span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="email" class="col-form-label col-lg-2 font-weight-semibold @if($errors->has('email')) text-danger @endif">
                                                Email
                                            </label>
                                            <div class="col-lg-10">
                                                <div class="form-group-feedback form-group-feedback-right">
                                                    <input id="email" name="email" type="text" value="{{old('email')}}" class="form-control @if($errors->has('email')) border-danger @endif">
                                                    @if($errors->has('email'))
                                                        <div class="form-control-feedback text-danger">
                                                            <i class="icon-cancel-circle2"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                @if($errors->has('email'))
                                                    <span class="form-text text-danger">{{$errors->first('email')}}</span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="password" class="col-form-label col-lg-2 font-weight-semibold @if($errors->has('password')) text-danger @endif">
                                                Şifrə
                                            </label>
                                            <div class="col-lg-10">
                                                <div class="form-group-feedback form-group-feedback-right">
                                                    <input id="password" name="password" type="password" autocomplete="new-password" class="form-control @if($errors->has('password')) border-danger @endif">
                                                    @if($errors->has('password'))
                                                        <div class="form-control-feedback text-danger">
                                                            <i class="icon-cancel-circle2"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                @if($errors->has('password'))
                                                    <span class="form-text text-danger">{{$errors->first('password')}}</span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="role" class="col-form-label col-lg-2 font-weight-semibold @if($errors->has('role')) text-danger @endif">
                                                Rollar
                                            </label>
                                            <div class="col-lg-10">
                                                <div class="form-group-feedback form-group-feedback-right">
                                                    <select id="role" class="select-search @if($errors->has('role')) border-danger @endif" name="role">
                                                        <option value="0" selected>Seçilməyib</option>
                                                        @foreach($roles as $role)
                                                            <option value="{{$role->name}}">{{$role->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @if($errors->has('role'))
                                                        <div class="form-control-feedback text-danger">
                                                            <i class="icon-cancel-circle2"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                @if($errors->has('role'))
                                                    <span class="form-text text-danger">{{$errors->first('role')}}</span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="position_id" class="col-form-label col-lg-2 font-weight-semibold @if($errors->has('position_id')) text-danger @endif">
                                                Position
                                            </label>
                                            <div class="col-lg-10">
                                                <div class="form-group-feedback form-group-feedback-right">
                                                    <select id="position_id" class="select-search @if($errors->has('position_id')) border-danger @endif" name="position_id">
                                                        <option value="0" @if(old('position_id') === 0) selected @endif>Seçilməyib</option>
                                                        @foreach($positions as $position)
                                                            <option value="{{$position->id}}" @if($position->id === old('position_id')) selected @endif>{{$position->position_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @if($errors->has('position_id'))
                                                        <div class="form-control-feedback text-danger">
                                                            <i class="icon-cancel-circle2"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                @if($errors->has('position_id'))
                                                    <span class="form-text text-danger">{{$errors->first('position_id')}}</span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="office_id" class="col-form-label col-lg-2 font-weight-semibold @if($errors->has('office_id')) text-danger @endif">
                                                Office
                                            </label>
                                            <div class="col-lg-10">
                                                <div class="form-group-feedback form-group-feedback-right">
                                                    <select id="office_id" class="select-search @if($errors->has('office_id')) border-danger @endif" name="office_id">
                                                        <option value="0" @if(old('office_id') === 0) selected @endif>Seçilməyib</option>
                                                        @foreach($offices as $office)
                                                            <option value="{{$office->id}}" @if($office->id === old('office_id')) selected @endif>{{$office->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @if($errors->has('office_id'))
                                                        <div class="form-control-feedback text-danger">
                                                            <i class="icon-cancel-circle2"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                @if($errors->has('office_id'))
                                                    <span class="form-text text-danger">{{$errors->first('office_id')}}</span>
                                                @endif
                                            </div>
                                        </div>

                                    </fieldset>
                                </div>
                                <div class="tab-pane fade p-0" id="permissions">
                                    <div class="tab-content">
                                        <fieldset class="mb-3">
                                            @foreach($permissions as $permission)
                                                <div class="form-group row" style="border-bottom: 1px solid #eee;">
                                                    <label for="status" class="col-form-label col-lg-8 col-6 font-weight-semibold">
                                                    {{$permission->description}}
                                                </label>
                                                <div class="col-lg-4 col-6 d-flex justify-content-end align-items-center">
                                                    <div class="form-group-feedback form-group-feedback-right">
                                                        <div class="form-check form-check-switchery">
                                                            <label class="form-check-label">
                                                                <input type="checkbox" id="status" class="form-check-input-switchery" name="permissions[]" value="{{$permission->id}}" data-fouc>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endcan
@endsection
