@extends('admin::layouts.auth')
@section('content')
    @push('breadcrumb-buttons')
        <div class="page-title d-flex">
            <h4>
                <a class="text-black-50" href="{{route('content.partner.index')}}"> Partnyora düzəliş et</a>
            </h4>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
        <div class="header-elements d-none">
            @can('content:partner-edit')
                <button type="submit" form="submit-form" class="btn bg-teal-400 btn-labeled btn-labeled-left">
                    <b><i class="icon-pencil"></i></b> Yadda saxla
                </button>
            @endcan
        </div>
    @endpush

    @can('content:partner-update')
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body mt-3">
                        <form action="{{route('content.partner.update', [$partner->id])}}" enctype="multipart/form-data"  method="post" id="submit-form">
                            <fieldset class="mb-3">
                                @csrf
                                {{ method_field('PATCH') }}

                                <div class="form-group row">
                                    <label for="url" class="col-form-label col-lg-2 font-weight-semibold @if($errors->has('url')) text-danger @endif">
                                        Url
                                    </label>
                                    <div class="col-lg-10">
                                        <div class="form-group-feedback form-group-feedback-right">
                                            <input id="url" name="url" value="{{old('url') ?? $partner->url}}" type="url" class="form-control @if($errors->has('url')) border-danger @endif">
                                            @if($errors->has('url'))
                                                <div class="form-control-feedback text-danger">
                                                    <i class="icon-cancel-circle2"></i>
                                                </div>
                                            @endif
                                        </div>
                                        @if($errors->has('url'))
                                            <span class="form-text text-danger">{{$errors->first('url')}}</span>
                                        @endif
                                    </div>
                                </div>

                                @if(isset($partner->base_image))
                                <div class="form-group row">
                                    <div class="col-form-label col-lg-2 font-weight-semibold"></div>
                                    <div class="col-lg-10">
                                        <div class="form-group-feedback form-group-feedback-right">
                                            <img style="width: 200px; height: 100px; object-fit: contain;" src="/storage/{{$partner->base_image->path}}" alt="Image Preview">
                                        </div>
                                    </div>
                                </div>
                                @endif

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
                                        Sort
                                    </label>
                                    <div class="col-lg-10">
                                        <div class="form-group-feedback form-group-feedback-right">
                                            <input id="sort" name="sort" value="{{old('sort') ?? $partner->sort}}" type="number" class="form-control @if($errors->has('sort')) border-danger @endif">
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
                                                    <input type="checkbox" id="status" class="form-check-input-switchery" @if($partner->status === 1) checked="checked" @endif name="status" value="1"  data-fouc>
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
    @endcan
@endsection
