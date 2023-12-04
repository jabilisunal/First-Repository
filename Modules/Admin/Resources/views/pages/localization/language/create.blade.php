@extends('admin::layouts.auth')
@section('content')
    @push('breadcrumb-buttons')
        <div class="page-title d-flex">
            <h4>
                <a class="text-black-50" href="{{route('localization.language.index')}}"> Dil əlavə et</a>
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
                    <form action="{{route('localization.language.store')}}" method="post" id="submit-form">
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
                                <label for="short_name" class="col-form-label col-lg-2 font-weight-semibold @if($errors->has('short_name')) text-danger @endif">
                                    Qısa ad
                                </label>
                                <div class="col-lg-10">
                                    <div class="form-group-feedback form-group-feedback-right">
                                        <input id="short_name" name="short_name" value="{{old('short_name')}}" type="text" class="form-control @if($errors->has('short_name')) border-danger @endif">
                                        @if($errors->has('short_name'))
                                            <div class="form-control-feedback text-danger">
                                                <i class="icon-cancel-circle2"></i>
                                            </div>
                                        @endif
                                    </div>
                                    @if($errors->has('short_name'))
                                        <span class="form-text text-danger">{{$errors->first('short_name')}}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="code" class="col-form-label col-lg-2 font-weight-semibold @if($errors->has('code')) text-danger @endif">
                                    Kod
                                </label>
                                <div class="col-lg-10">
                                    <div class="form-group-feedback form-group-feedback-right">
                                        <input id="code" name="code" type="text" value="{{old('code')}}" class="form-control @if($errors->has('code')) border-danger @endif">
                                        @if($errors->has('code'))
                                            <div class="form-control-feedback text-danger">
                                                <i class="icon-cancel-circle2"></i>
                                            </div>
                                        @endif
                                    </div>
                                    @if($errors->has('code'))
                                        <span class="form-text text-danger">{{$errors->first('code')}}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="style" class="col-form-label col-lg-2 font-weight-semibold @if($errors->has('style')) text-danger @endif">
                                    Style
                                </label>
                                <div class="col-lg-10">
                                    <div class="form-group-feedback form-group-feedback-right">
                                        <select id="style" class="select-search @if($errors->has('style')) border-danger @endif" name="style">
                                            @foreach($styles as $style)
                                                <option value="{{$style}}" @if($style === old('style')) selected @endif>{{$style}}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('style'))
                                            <div class="form-control-feedback text-danger">
                                                <i class="icon-cancel-circle2"></i>
                                            </div>
                                        @endif
                                    </div>
                                    @if($errors->has('style'))
                                        <span class="form-text text-danger">{{$errors->first('style')}}</span>
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
