@extends('admin::layouts.auth')
@section('content')
    @push('breadcrumb-buttons')
        <div class="page-title d-flex">
            <h4>
                <a class="text-black-50" href="{{route('content.menu.index')}}"> Menyu əlavə et</a>
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
            <form action="{{route('content.menu.store')}}" method="post" enctype="multipart/form-data" id="submit-form">
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
                                        <label for="menu_type_id" class="col-form-label col-lg-2 font-weight-semibold @if($errors->has('menu_type_id')) text-danger @endif">
                                            Menyu tipi
                                        </label>
                                        <div class="col-lg-10">
                                            <div class="form-group-feedback form-group-feedback-right">
                                                <select id="menu_type_id" class="select-search @if($errors->has('menu_type_id')) border-danger @endif" name="menu_type_id">
                                                    <option value="0" @if(old('menu_type_id') === 0) selected @endif>Seçilməyib</option>
                                                    @foreach($menuTypes as $menuType)
                                                        <option value="{{$menuType->id}}" @if($menuType->id === old('menu_type_id')) selected @endif>{{$menuType->title}}</option>
                                                    @endforeach
                                                </select>
                                                @if($errors->has('menu_type_id'))
                                                    <div class="form-control-feedback text-danger">
                                                        <i class="icon-cancel-circle2"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            @if($errors->has('menu_type_id'))
                                                <span class="form-text text-danger">{{$errors->first('menu_type_id')}}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="parent_id" class="col-form-label col-lg-2 font-weight-semibold @if($errors->has('parent_id')) text-danger @endif">
                                            Ana Menyu
                                        </label>
                                        <div class="col-lg-10">
                                            <div class="form-group-feedback form-group-feedback-right">
                                                <select id="parent_id" class="select-search @if($errors->has('parent_id')) border-danger @endif" name="parent_id">
                                                    <option value="0" @if(old('parent_id') === 0) selected @endif>Seçilməyib</option>
                                                    @foreach($menus as $menu)
                                                        <option value="{{$menu->id}}" @if($menu->id === old('parent_id')) selected @endif>{{$menu->title}}</option>
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
                                        <label for="style" class="col-form-label col-lg-2 font-weight-semibold @if($errors->has('style')) text-danger @endif">
                                            Style
                                        </label>
                                        <div class="col-lg-10">
                                            <div class="form-group-feedback form-group-feedback-right">
                                                <select id="style" class="select-search @if($errors->has('style')) border-danger @endif" name="style">
                                                    <option value="none" @if(old('style') === 'none') selected @endif>None</option>
                                                    <option value="dropdown" @if(old('style') === 'dropdown') selected @endif>Dropdown</option>
                                                    <option value="megaMenu" @if(old('style') === 'megaMenu') selected @endif>Mega menu</option>
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
                                        <label for="slug" class="col-form-label col-lg-2 font-weight-semibold @if($errors->has('slug')) text-danger @endif">
                                            Slug
                                        </label>
                                        <div class="col-lg-10">
                                            <div class="form-group-feedback form-group-feedback-right">
                                                <input id="slug" name="slug" type="text"
                                                       value="{{old('slug')}}"
                                                       class="form-control @if($errors->has('slug')) border-danger @endif">
                                                @if($errors->has('slug'))
                                                    <div class="form-control-feedback text-danger">
                                                        <i class="icon-cancel-circle2"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            @if($errors->has('slug'))
                                                <span class="form-text text-danger">{{$errors->first('slug')}}</span>
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
                                                       value="{{old('sort')}}"
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
                                        <label for="is_new" class="col-form-label col-lg-2 font-weight-semibold">
                                            Yeni ?
                                        </label>
                                        <div class="col-lg-10">
                                            <div class="form-group-feedback form-group-feedback-right">
                                                <div class="form-check form-check-switchery">
                                                    <label class="form-check-label">
                                                        <input type="checkbox" id="is_new" class="form-check-input-switchery" @if((string) old('is_new') === "1") checked="checked" @endif name="is_new" data-fouc>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="target_blank" class="col-form-label col-lg-2 font-weight-semibold">
                                            Target Blank :
                                        </label>
                                        <div class="col-lg-10">
                                            <div class="form-group-feedback form-group-feedback-right">
                                                <div class="form-check form-check-switchery">
                                                    <label class="form-check-label">
                                                        <input type="checkbox" id="target_blank" class="form-check-input-switchery" @if((string) old('target_blank') === "1") checked="checked" @endif name="target_blank" data-fouc>
                                                    </label>
                                                </div>
                                            </div>
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
                                                    <label for="url_{{$language->code}}" class="col-form-label col-lg-2 font-weight-semibold @if($errors->has('url')) text-danger @endif">
                                                        URL
                                                    </label>
                                                    <div class="col-lg-10">
                                                        <div class="form-group-feedback form-group-feedback-right">
                                                            <input name="url[{{$language->code}}]" id="url_{{$language->code}}"  type="text"
                                                                   value="{{old('url') ? old('url')[$language->code] : ''}}"
                                                                   class="form-control @if($errors->has('url')) border-danger @endif">
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
