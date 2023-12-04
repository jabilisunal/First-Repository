@extends('admin::layouts.auth')
@section('content')
    @push('breadcrumb-buttons')
        <div class="page-title d-flex">
            <h4>
                <a class="text-black-50" href="{{route('content.features.index')}}"> Xüsusiyyət düzəliş et</a>
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
            <form action="{{route('content.features.update', [$feature->id])}}" method="post" enctype="multipart/form-data" id="submit-form">
                <ul class="nav nav-tabs nav-tabs-highlight mb-0">
                    <li class="nav-item"><a href="#general" class="nav-link active" data-toggle="tab">Ümumi məlumatlar</a></li>
                    <li class="nav-item"><a href="#translation" class="nav-link" data-toggle="tab">Tərcümələr</a></li>
                </ul>
                <div class="card border-top-0 border-right-1 border-bottom-1 border-left-1" style="border-radius: 0; border-color: #ddd;">
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="general">
                                <fieldset class="mb-3">
                                    @csrf
                                    {{ method_field('PATCH') }}

                                    <div class="form-group row">
                                        <label for="sort" class="col-form-label col-lg-2 font-weight-semibold @if($errors->has('sort')) text-danger @endif">
                                            Öncəlik sırası
                                        </label>
                                        <div class="col-lg-10">
                                            <div class="form-group-feedback form-group-feedback-right">
                                                <input id="sort" name="sort" type="number"
                                                       value="{{$feature->sort}}"
                                                       class="form-control @if($errors->has('sort')) border-danger @endif">
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

                                    @if(isset($feature->base_image))
                                        <div class="form-group row">
                                            <div class="col-form-label col-lg-2 font-weight-semibold"></div>
                                            <div class="col-lg-10">
                                                <div class="form-group-feedback form-group-feedback-right">
                                                    <img style="width: 200px; height: 100px; object-fit: contain;" src="/storage/{{$feature->base_image->path}}" alt="Image Preview">
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
                                        <label for="status" class="col-form-label col-lg-2 font-weight-semibold">
                                            Status:
                                        </label>
                                        <div class="col-lg-10">
                                            <div class="form-group-feedback form-group-feedback-right">
                                                <div class="form-check form-check-switchery">
                                                    <label class="form-check-label">
                                                        <input type="checkbox" id="status" class="form-check-input-switchery" @if($feature->status === 1) checked="checked" @endif name="status" data-fouc>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </fieldset>
                            </div>
                            <div class="tab-pane fade p-0" id="translation">
                                <ul class="nav nav-tabs nav-tabs-highlight mb-0">
                                    @foreach($languages as $key => $language)
                                        <li class="nav-item"><a href="#{{$language->short_name}}" class="nav-link @if($key === 0) active @endif" data-toggle="tab">{{$language->name}}</a></li>
                                    @endforeach
                                </ul>
                                <div class="tab-content">
                                    @foreach($languages as $key => $language)
                                        <div class="tab-pane fade @if($key === 0) show active @endif" id="{{$language->short_name}}">
                                            <fieldset class="mb-3 p-3">

                                                <div class="form-group row">
                                                    <label for="title_{{$language->code}}" class="col-form-label col-lg-2 font-weight-semibold @if($errors->has('title')) text-danger @endif">
                                                        Başlıq
                                                    </label>
                                                    <div class="col-lg-10">
                                                        <div class="form-group-feedback form-group-feedback-right">
                                                            <input name="title[{{$language->code}}]" id="title_{{$language->code}}"  type="text"
                                                                   value="{{(old('title')[$language->code] ?? null) ?? ($translations[$language->code]['title'] ?? '')}}"
                                                                   class="form-control @if($errors->has('title')) border-danger @endif">
                                                            @if($errors->has('title'))
                                                                <div class="form-control-feedback text-danger">
                                                                    <i class="icon-cancel-circle2"></i>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        @if($errors->has('title'))
                                                            <span class="form-text text-danger">{{$errors->first('title')}}</span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="description_{{$language->code}}" class="col-form-label col-lg-2 font-weight-semibold @if($errors->has('description')) text-danger @endif">
                                                        Açıqlama
                                                    </label>
                                                    <div class="col-lg-10">
                                                        <div class="form-group-feedback form-group-feedback-right">
                                                            <textarea name="description[{{$language->code}}]" id="description_{{$language->code}}" cols="30" rows="10" class="form-control ckeditor @if($errors->has('description')) border-danger @endif">{!! (old('description')[$language->code] ?? null) ?? ($translations[$language->code]['description'] ?? '') !!}</textarea>
                                                            @if($errors->has('description'))
                                                                <div class="form-control-feedback text-danger">
                                                                    <i class="icon-cancel-circle2"></i>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        @if($errors->has('description'))
                                                            <span class="form-text text-danger">{{$errors->first('description')}}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
