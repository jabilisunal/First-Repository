@extends('admin::layouts.auth')
@section('content')
    @push('breadcrumb-buttons')
        <div class="page-title d-flex">
            <h4>
                <a class="text-black-50" href="{{route('content.banner-type.index')}}"> Banner tipi əlavə et</a>
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
            <div class="card">
                <div class="card-body mt-3">
                    <form action="{{route('content.banner-type.store')}}" method="post" enctype="multipart/form-data" id="submit-form">
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
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
