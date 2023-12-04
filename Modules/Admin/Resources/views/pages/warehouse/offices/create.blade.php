@extends('admin::layouts.auth')
@section('content')
    @push('breadcrumb-buttons')
        <div class="page-title d-flex">
            <h4>
                <a class="text-black-50" href="{{route('warehouse.offices.index')}}"> Offis əlavə et</a>
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
                    <form action="{{route('warehouse.offices.store')}}" method="post" enctype="multipart/form-data" id="submit-form">
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
                                <label for="address" class="col-form-label col-lg-2 font-weight-semibold @if($errors->has('address')) text-danger @endif">
                                    Address
                                </label>
                                <div class="col-lg-10">
                                    <div class="form-group-feedback form-group-feedback-right">
                                        <input id="address" name="address" type="text" value="{{old('address')}}" class="form-control @if($errors->has('address')) border-danger @endif">
                                        @if($errors->has('address'))
                                            <div class="form-control-feedback text-danger">
                                                <i class="icon-cancel-circle2"></i>
                                            </div>
                                        @endif
                                    </div>
                                    @if($errors->has('address'))
                                        <span class="form-text text-danger">{{$errors->first('address')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="lat" class="col-form-label col-lg-2 font-weight-semibold @if($errors->has('lat')) text-danger @endif">
                                    Lat
                                </label>
                                <div class="col-lg-10">
                                    <div class="form-group-feedback form-group-feedback-right">
                                        <input id="lat" name="lat" type="text" value="{{old('lat')}}" class="form-control @if($errors->has('lat')) border-danger @endif">
                                        @if($errors->has('lat'))
                                            <div class="form-control-feedback text-danger">
                                                <i class="icon-cancel-circle2"></i>
                                            </div>
                                        @endif
                                    </div>
                                    @if($errors->has('lat'))
                                        <span class="form-text text-danger">{{$errors->first('lat')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="lng" class="col-form-label col-lg-2 font-weight-semibold @if($errors->has('lng')) text-danger @endif">
                                    Lng
                                </label>
                                <div class="col-lg-10">
                                    <div class="form-group-feedback form-group-feedback-right">
                                        <input id="lng" name="lng" type="text" value="{{old('lng')}}" class="form-control @if($errors->has('lng')) border-danger @endif">
                                        @if($errors->has('lng'))
                                            <div class="form-control-feedback text-danger">
                                                <i class="icon-cancel-circle2"></i>
                                            </div>
                                        @endif
                                    </div>
                                    @if($errors->has('lng'))
                                        <span class="form-text text-danger">{{$errors->first('lng')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="image" class="col-form-label col-lg-2 font-weight-semibold @if($errors->has('image')) text-danger @endif">
                                    Şəkil
                                </label>
                                <div class="col-lg-10">
                                    <div class="form-group-feedback form-group-feedback-right">
                                        <div class="custom-file">
                                            <input type="file" name="image" class="custom-file-input @if($errors->has('image')) border-danger @endif" id="image">
                                            <label class="custom-file-label" for="image">Şəkil seç</label>
                                        </div>
                                        @if($errors->has('image'))
                                            <div class="form-control-feedback text-danger">
                                                <i class="icon-cancel-circle2"></i>
                                            </div>
                                        @endif
                                    </div>
                                    @if($errors->has('image'))
                                        <span class="form-text text-danger">{{$errors->first('image')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="sort" class="col-form-label col-lg-2 font-weight-semibold @if($errors->has('sort')) text-danger @endif">
                                    Öncəlik sırası
                                </label>
                                <div class="col-lg-10">
                                    <div class="form-group-feedback form-group-feedback-right">
                                        <input id="sort" name="sort" type="number" class="form-control @if($errors->has('sort')) border-danger @endif">
                                        @if($errors->has('sort'))
                                            <div class="form-control-feedback text-danger">
                                                <i class="icon-cancel-circle2"></i>
                                            </div>
                                        @endif
                                    </div>
                                    @if($errors->has('sort'))
                                        <span class="form-text text-danger">{{$errors->first('sort')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="status" class="col-form-label col-lg-2 font-weight-semibold">
                                    Status:
                                </label>
                                <div class="col-lg-10">
                                    <div class="form-group-feedback form-group-feedback-right">
                                        <div class="form-check form-check-switchery">
                                            <label class="form-check-label">
                                                <input type="checkbox" id="status" class="form-check-input-switchery" @if((string) old('status') === "1") checked="checked" @endif name="status" data-fouc>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
