@extends('admin::layouts.auth')
@section('content')
    @push('breadcrumb-buttons')
        <div class="page-title d-flex">
            <h4>
                <a class="text-black-50" href="{{route('content.banner.index')}}"> Banner əlavə et</a>
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
            <form action="{{route('content.banner.store')}}" method="post" enctype="multipart/form-data" id="submit-form">
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

                                    <div class="form-group row">
                                        <label for="banner_type_id" class="col-form-label col-lg-2 font-weight-semibold @if($errors->has('banner_type_id')) text-danger @endif">
                                            Banner tipi
                                        </label>
                                        <div class="col-lg-10">
                                            <div class="form-group-feedback form-group-feedback-right">
                                                <select id="banner_type_id" class="select-search @if($errors->has('banner_type_id')) border-danger @endif" name="type_id">
                                                    <option value="0" @if(old('banner_type_id') === 0) selected @endif>Seçilməyib</option>
                                                    @foreach($bannerTypes as $bannerType)
                                                        <option value="{{$bannerType->id}}" @if($bannerType->id === old('banner_type_id')) selected @endif>{{$bannerType->name}}</option>
                                                    @endforeach
                                                </select>
                                                @if($errors->has('banner_type_id'))
                                                    <div class="form-control-feedback text-danger">
                                                        <i class="icon-cancel-circle2"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            @if($errors->has('banner_type_id'))
                                                <span class="form-text text-danger">{{$errors->first('banner_type_id')}}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="position" class="col-form-label col-lg-2 font-weight-semibold @if($errors->has('position')) text-danger @endif">
                                            Mövqe
                                        </label>
                                        <div class="col-lg-10">
                                            <div class="form-group-feedback form-group-feedback-right">
                                                <select id="position" class="select-search @if($errors->has('position')) border-danger @endif" name="position">
                                                    <option value="0" @if(old('position') === 0) selected @endif>Seçilməyib</option>
                                                    @foreach($positions as $position)
                                                    <option value="{{$position}}" @if($position === old('position')) selected @endif>{{$position}}</option>
                                                    @endforeach
                                                </select>
                                                @if($errors->has('position'))
                                                    <div class="form-control-feedback text-danger">
                                                        <i class="icon-cancel-circle2"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            @if($errors->has('position'))
                                                <span class="form-text text-danger">{{$errors->first('position')}}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="effect" class="col-form-label col-lg-2 font-weight-semibold @if($errors->has('effect')) text-danger @endif">
                                            Effect
                                        </label>
                                        <div class="col-lg-10">
                                            <div class="form-group-feedback form-group-feedback-right">
                                                <select id="effect" class="select-search @if($errors->has('effect')) border-danger @endif" name="effect">
                                                    <option value="0" @if(old('effect') === 0) selected @endif>Seçilməyib</option>
                                                    @foreach(animateList() as $effect)
                                                        <option value="{{$effect}}" @if($effect === old('effect')) selected @endif>{{$effect}}</option>
                                                    @endforeach
                                                </select>
                                                @if($errors->has('effect'))
                                                    <div class="form-control-feedback text-danger">
                                                        <i class="icon-cancel-circle2"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            @if($errors->has('effect'))
                                                <span class="form-text text-danger">{{$errors->first('effect')}}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="duration" class="col-form-label col-lg-2 font-weight-semibold @if($errors->has('duration')) text-danger @endif">
                                            Müddəti
                                        </label>
                                        <div class="col-lg-10">
                                            <div class="form-group-feedback form-group-feedback-right">
                                                <input id="duration" name="duration" type="text"
                                                       value="{{old('duration')}}"
                                                       placeholder="1s"
                                                       class="form-control @if($errors->has('duration')) border-danger @endif">
                                                @if($errors->has('duration'))
                                                    <div class="form-control-feedback text-danger">
                                                        <i class="icon-cancel-circle2"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            @if($errors->has('duration'))
                                                <span class="form-text text-danger">{{$errors->first('duration')}}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="sort" class="col-form-label col-lg-2 font-weight-semibold @if($errors->has('sort')) text-danger @endif">
                                            Öncəlik sırası
                                        </label>
                                        <div class="col-lg-10">
                                            <div class="form-group-feedback form-group-feedback-right">
                                                <input id="sort" name="sort" type="number"
                                                       value="{{old('sort', 0)}}"
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
                                        <label for="additional_image" class="col-form-label col-lg-2 font-weight-semibold @if($errors->has('additional_image')) text-danger @endif">
                                            Şəkil Mobile
                                        </label>
                                        <div class="col-lg-10">
                                            <div class="form-group-feedback form-group-feedback-right">
                                                <div class="custom-file">
                                                    <input type="file" name="additional_image" class="custom-file-input @if($errors->has('additional_image')) border-danger @endif" id="additional_image">
                                                    <label class="custom-file-label" for="additional_image">Şəkil seç</label>
                                                </div>
                                                @if($errors->has('additional_image'))
                                                    <div class="form-control-feedback text-danger">
                                                        <i class="icon-cancel-circle2"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            @if($errors->has('additional_image'))
                                                <span class="form-text text-danger">{{$errors->first('additional_image')}}</span>
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
                                                                   value="{{old('title') ? old('title')[$language->code] : ''}}"
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
                                                            <textarea name="description[{{$language->code}}]" id="description_{{$language->code}}" cols="30" rows="10" class="form-control ckeditor @if($errors->has('description')) border-danger @endif">{{old('description') ? old('description')[$language->code] : ''}}</textarea>
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

                                                <div class="form-group row">
                                                    <label for="button_title_{{$language->code}}" class="col-form-label col-lg-2 font-weight-semibold @if($errors->has('button_title')) text-danger @endif">
                                                        Button Başlığı
                                                    </label>
                                                    <div class="col-lg-10">
                                                        <div class="form-group-feedback form-group-feedback-right">
                                                            <input name="button_title[{{$language->code}}]" id="button_title_{{$language->code}}" type="text"
                                                                   value="{{old('button_title') ? old('button_title')[$language->code] : ''}}"
                                                                   class="form-control @if($errors->has('button_title')) border-danger @endif">
                                                            @if($errors->has('button_title'))
                                                                <div class="form-control-feedback text-danger">
                                                                    <i class="icon-cancel-circle2"></i>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        @if($errors->has('button_title'))
                                                            <span class="form-text text-danger">{{$errors->first('button_title')}}</span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="button_url_{{$language->code}}" class="col-form-label col-lg-2 font-weight-semibold @if($errors->has('button_url')) text-danger @endif">
                                                        Button URL
                                                    </label>
                                                    <div class="col-lg-10">
                                                        <div class="form-group-feedback form-group-feedback-right">
                                                            <input name="button_url[{{$language->code}}]" id="button_url_{{$language->code}}"  type="text"
                                                                   value="{{old('button_url') ? old('button_url')[$language->code] : ''}}"
                                                                   class="form-control @if($errors->has('button_url')) border-danger @endif">
                                                            @if($errors->has('button_url'))
                                                                <div class="form-control-feedback text-danger">
                                                                    <i class="icon-cancel-circle2"></i>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        @if($errors->has('button_url'))
                                                            <span class="form-text text-danger">{{$errors->first('button_url')}}</span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="button_icon_{{$language->code}}" class="col-form-label col-lg-2 font-weight-semibold @if($errors->has('button_icon')) text-danger @endif">
                                                        Button icon
                                                    </label>
                                                    <div class="col-lg-10">
                                                        <div class="form-group-feedback form-group-feedback-right">
                                                            <input name="button_icon[{{$language->code}}]" id="button_icon_{{$language->code}}"  type="text"
                                                                   placeholder="w-icon-long-arrow-right"
                                                                   value="{{old('button_icon') ? old('button_icon')[$language->code] : 'w-icon-long-arrow-right'}}"
                                                                   class="form-control @if($errors->has('button_icon')) border-danger @endif">
                                                            @if($errors->has('button_icon'))
                                                                <div class="form-control-feedback text-danger">
                                                                    <i class="icon-cancel-circle2"></i>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        @if($errors->has('button_icon'))
                                                            <span class="form-text text-danger">{{$errors->first('button_icon')}}</span>
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
