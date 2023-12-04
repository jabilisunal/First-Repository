@extends('admin::layouts.auth')
@section('content')
    @push('breadcrumb-buttons')
        <div class="page-title d-flex">
            <h4>
                <a class="text-black-50" href="{{route('user.position.index')}}"> Pozisiyaya düzəliş et</a>
            </h4>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
        <div class="header-elements d-none">
            <button type="submit" form="submit-form" class="btn bg-teal-400 btn-labeled btn-labeled-left">
                <b><i class="icon-hand"></i></b> Yadda saxla
            </button>
        </div>
    @endpush
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('user.position.update', [$position->id])}}" method="post" enctype="multipart/form-data" id="submit-form">
                <div class="card border-top-0 border-right-1 border-bottom-1 border-left-1" style="border-radius: 0; border-color: #ddd;">
                    <div class="card-body">
                        <fieldset class="mb-3">
                            @csrf
                            {{ method_field('PATCH') }}

                            <div class="form-group row">
                                <label for="parent_id" class="col-form-label col-lg-2 font-weight-semibold @if($errors->has('parent_id')) text-danger @endif">
                                    Ana Pozisiya
                                </label>
                                <div class="col-lg-10">
                                    <div class="form-group-feedback form-group-feedback-right">
                                        <select id="parent_id" class="select-search @if($errors->has('parent_id')) border-danger @endif" name="parent_id">
                                            <option value="" @if($position->parent_id === null) selected @endif>Seçilməyib</option>
                                            @foreach($positions as $value)
                                                <option value="{{$value->id}}" @if($value->id === $position->parent_id) selected @endif>{{$value->position_name}}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('parent_id'))
                                            <div class="form-control-feedback text-danger">
                                                <i class="icon-cancel-circle2"></i>
                                            </div>
                                        @endif
                                    </div>
                                    @if($errors->has('parent_id'))
                                        <span class="form-text text-danger">{{$errors->first('parent_id')}}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="position_name" class="col-form-label col-lg-2 font-weight-semibold @if($errors->has('position_name')) text-danger @endif">
                                    Pozisiya adı
                                </label>
                                <div class="col-lg-10">
                                    <div class="form-group-feedback form-group-feedback-right">
                                        <input id="position_name" name="position_name" type="text"
                                               value="{{$position->position_name}}"
                                               class="form-control @if($errors->has('position_name')) border-danger @endif">
                                        @if($errors->has('position_name'))
                                            <div class="form-control-feedback text-danger">
                                                <i class="icon-cancel-circle2"></i>
                                            </div>
                                        @endif
                                    </div>
                                    @if($errors->has('position_name'))
                                        <span class="form-text text-danger">{{$errors->first('position_name')}}</span>
                                    @endif
                                </div>
                            </div>

                        </fieldset>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
