@extends('admin::layouts.auth')
@section('content')
    @push('breadcrumb-buttons')
        <div class="page-title d-flex">
            <h4>
                <a class="text-black-50" href="{{route('ecommerce.places.index')}}"> Place düzəliş et</a>
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
            <form action="{{route('ecommerce.places.update', [$place->id])}}" method="post" enctype="multipart/form-data" id="submit-form">
                <ul class="nav nav-tabs nav-tabs-highlight mb-0">
                    <li class="nav-item"><a href="#general" class="nav-link active" data-toggle="tab">Ümumi məlumatlar</a></li>
                    <li class="nav-item"><a href="#address" class="nav-link" data-toggle="tab">Ünvan</a></li>
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
                                        <label for="category_id" class="col-form-label col-lg-2 font-weight-semibold @if($errors->has('category_id')) text-danger @endif">
                                            Kateqoriya
                                        </label>
                                        <div class="col-lg-10">
                                            <div class="form-group-feedback form-group-feedback-right">
                                                <select id="category_id" class="select-search @if($errors->has('category_id')) border-danger @endif" name="category_id">
                                                    <option value="" @if(old('category_id') === '') selected @endif>Seçilməyib</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{$category->id}}" @if($category->id === $place->category_id) selected @endif>{{$category->title}}</option>
                                                    @endforeach
                                                </select>
                                                @if($errors->has('category_id'))
                                                    <div class="form-control-feedback text-danger">
                                                        <i class="icon-cancel-circle2"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            @if($errors->has('category_id'))
                                                <span class="form-text text-danger">{{$errors->first('category_id')}}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="region_group_id" class="col-form-label col-lg-2 font-weight-semibold @if($errors->has('region_group_id')) text-danger @endif">
                                            Region Qurupu
                                        </label>
                                        <div class="col-lg-10">
                                            <div class="form-group-feedback form-group-feedback-right">
                                                <select id="region_group_id" class="select-search @if($errors->has('region_group_id')) border-danger @endif" name="region_group_id">
                                                    <option value="" @if(old('region_group_id') === '') selected @endif>Seçilməyib</option>
                                                    @foreach($regionGroups as $regionGroup)
                                                        <option value="{{$regionGroup->id}}" @if($regionGroup->id === $place->region_group_id) selected @endif>{{$regionGroup->name}}</option>
                                                    @endforeach
                                                </select>
                                                @if($errors->has('region_group_id'))
                                                    <div class="form-control-feedback text-danger">
                                                        <i class="icon-cancel-circle2"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            @if($errors->has('region_group_id'))
                                                <span class="form-text text-danger">{{$errors->first('region_group_id')}}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="destination_id" class="col-form-label col-lg-2 font-weight-semibold @if($errors->has('destination_id')) text-danger @endif">
                                            Destination
                                        </label>
                                        <div class="col-lg-10">
                                            <div class="form-group-feedback form-group-feedback-right">
                                                <select id="destination_id" class="select-search @if($errors->has('destination_id')) border-danger @endif" name="destination_id">
                                                    <option value="" @if(old('destination_id') === '') selected @endif>Seçilməyib</option>
                                                    @foreach($destinations as $destination)
                                                        <option value="{{$destination->id}}" @if($destination->id === $place->destination_id) selected @endif>{{$destination->name}}</option>
                                                    @endforeach
                                                </select>
                                                @if($errors->has('destination_id'))
                                                    <div class="form-control-feedback text-danger">
                                                        <i class="icon-cancel-circle2"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            @if($errors->has('destination_id'))
                                                <span class="form-text text-danger">{{$errors->first('destination_id')}}</span>
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
                                                       value="{{$place->slug}}"
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
                                        <label for="booking_url" class="col-form-label col-lg-2 font-weight-semibold @if($errors->has('booking_url')) text-danger @endif">
                                            Booking Url
                                        </label>
                                        <div class="col-lg-10">
                                            <div class="form-group-feedback form-group-feedback-right">
                                                <input id="booking_url" name="booking_url" type="text"
                                                       value="{{$place->booking_url}}"
                                                       class="form-control @if($errors->has('booking_url')) border-danger @endif">
                                                @if($errors->has('booking_url'))
                                                    <div class="form-control-feedback text-danger">
                                                        <i class="icon-cancel-circle2"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            @if($errors->has('booking_url'))
                                                <span class="form-text text-danger">{{$errors->first('booking_url')}}</span>
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
                                                       value="{{$place->sort}}"
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
                                        <label for="price" class="col-form-label col-lg-2 font-weight-semibold @if($errors->has('price')) text-danger @endif">
                                            Qiymət
                                        </label>
                                        <div class="col-lg-10">
                                            <div class="form-group-feedback form-group-feedback-right">
                                                <input id="price" name="price" type="number" value="{{$place->price}}" class="form-control @if($errors->has('price')) border-danger @endif">
                                                @if($errors->has('price'))
                                                    <div class="form-control-feedback text-danger">
                                                        <i class="icon-cancel-circle2"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            @if($errors->has('price'))
                                                <span class="form-text text-danger">{{$errors->first('price')}}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="tags" class="col-form-label col-lg-2 font-weight-semibold @if($errors->has('tags')) text-danger @endif">
                                            Açar sözlər
                                        </label>
                                        <div class="col-lg-10">
                                            <div class="form-group-feedback form-group-feedback-right">
                                                <select id="tags" class="select-search" name="tags[]" multiple>
                                                    @foreach($tags as $tag)
                                                        <option value="{{$tag->id}}" @if(in_array($tag->id, $place->tags->pluck('id')->toArray(), true)) selected @endif>{{$tag->name}}</option>
                                                    @endforeach
                                                </select>
                                                @if($errors->has('tags'))
                                                    <div class="form-control-feedback text-danger">
                                                        <i class="icon-cancel-circle2"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            @if($errors->has('tags'))
                                                <span class="form-text text-danger">{{$errors->first('tags')}}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="facilities" class="col-form-label col-lg-2 font-weight-semibold @if($errors->has('facilities')) text-danger @endif">
                                            Xüsusiyətlər
                                        </label>
                                        <div class="col-lg-10">
                                            <div class="form-group-feedback form-group-feedback-right">
                                                <select id="facilities" class="select-search" name="facilities[]" multiple>
                                                    @foreach($facilities as $facility)
                                                        <option value="{{$facility->id}}" @if(in_array($facility->id, $place->facilities->pluck('id')->toArray(), true)) selected @endif>{{$facility->name}}</option>
                                                    @endforeach
                                                </select>
                                                @if($errors->has('facilities'))
                                                    <div class="form-control-feedback text-danger">
                                                        <i class="icon-cancel-circle2"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            @if($errors->has('facilities'))
                                                <span class="form-text text-danger">{{$errors->first('facilities')}}</span>
                                            @endif
                                        </div>
                                    </div>

                                    @if(isset($place->base_image))
                                        <div class="form-group row">
                                            <div class="col-form-label col-lg-2 font-weight-semibold"></div>
                                            <div class="col-lg-10">
                                                <div class="form-group-feedback form-group-feedback-right">
                                                    <img style="width: 200px; height: 100px; object-fit: contain;" src="/storage/public/media/{{$place->base_image->path}}" alt="Image Preview">
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

                                    @if(isset($place->cover_image))
                                        <div class="form-group row">
                                            <div class="col-form-label col-lg-2 font-weight-semibold"></div>
                                            <div class="col-lg-10">
                                                <div class="form-group-feedback form-group-feedback-right">
                                                    <img style="width: 200px; height: 100px; object-fit: contain;" src="/storage/public/media/{{$place->cover_image->path}}" alt="Image Preview">
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="form-group row">
                                        <label for="cover" class="col-form-label col-lg-2 font-weight-semibold @if($errors->has('image')) text-danger @endif">
                                            Cover Photo
                                        </label>
                                        <div class="col-lg-10">
                                            <div class="form-group-feedback form-group-feedback-right">
                                                <div class="custom-file">
                                                    <input type="file" name="cover" class="custom-file-input @if($errors->has('cover')) border-danger @endif" id="cover">
                                                    <label class="custom-file-label" for="cover">Şəkil seç</label>
                                                </div>
                                                @if($errors->has('cover'))
                                                    <div class="form-control-feedback text-danger">
                                                        <i class="icon-cancel-circle2"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            @if($errors->has('cover'))
                                                <span class="form-text text-danger">{{$errors->first('cover')}}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label font-weight-semibold">Digər şəkillər:</label>
                                        <div class="col-lg-10">
                                            <input type="file" name="images[]" class="file-input" id="file-input-overwrite" multiple="multiple" data-fouc>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="status" class="col-form-label col-lg-2 font-weight-semibold">
                                            Papulyar ?
                                        </label>
                                        <div class="col-lg-10">
                                            <div class="form-group-feedback form-group-feedback-right">
                                                <div class="form-check form-check-switchery">
                                                    <label class="form-check-label">
                                                        <input type="checkbox" id="is_popular" class="form-check-input-switchery" @if((string) $place->is_popular === "1") checked="checked" @endif name="is_popular" data-fouc>
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
                                                        <input type="checkbox" id="status" class="form-check-input-switchery" @if((string) $place->status === "1") checked="checked" @endif name="status" data-fouc>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </fieldset>
                            </div>

                            <div class="tab-pane fade p-0" id="address">

                                <div class="form-group row">
                                    <label for="address_name" class="col-form-label col-lg-2 font-weight-semibold @if($errors->has('address_name')) text-danger @endif">
                                        Ünvan
                                    </label>
                                    <div class="col-lg-10">
                                        <div class="form-group-feedback form-group-feedback-right">
                                            <input id="address_name" name="address_name" type="text"
                                                   value="{{old('address_name') ?? $place->address?->name}}"
                                                   class="form-control @if($errors->has('address_name')) border-danger @endif">
                                            @if($errors->has('address_name'))
                                                <div class="form-control-feedback text-danger">
                                                    <i class="icon-cancel-circle2"></i>
                                                </div>
                                            @endif
                                        </div>
                                        @if($errors->has('address_name'))
                                            <span class="form-text text-danger">{{$errors->first('address_name')}}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="address_latitude" class="col-form-label col-lg-2 font-weight-semibold @if($errors->has('address_latitude')) text-danger @endif">
                                        Latitude
                                    </label>
                                    <div class="col-lg-10">
                                        <div class="form-group-feedback form-group-feedback-right">
                                            <input id="address_latitude" name="address_latitude" type="text"
                                                   value="{{old('address_latitude') ?? $place->address?->latitude}}"
                                                   class="form-control @if($errors->has('address_latitude')) border-danger @endif">
                                            @if($errors->has('address_latitude'))
                                                <div class="form-control-feedback text-danger">
                                                    <i class="icon-cancel-circle2"></i>
                                                </div>
                                            @endif
                                        </div>
                                        @if($errors->has('address_latitude'))
                                            <span class="form-text text-danger">{{$errors->first('address_latitude')}}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="address_longitude" class="col-form-label col-lg-2 font-weight-semibold @if($errors->has('address_longitude')) text-danger @endif">
                                        Longitude
                                    </label>
                                    <div class="col-lg-10">
                                        <div class="form-group-feedback form-group-feedback-right">
                                            <input id="address_longitude" name="address_longitude" type="text"
                                                   value="{{old('address_longitude') ?? $place->address?->longitude}}"
                                                   class="form-control @if($errors->has('address_longitude')) border-danger @endif">
                                            @if($errors->has('address_longitude'))
                                                <div class="form-control-feedback text-danger">
                                                    <i class="icon-cancel-circle2"></i>
                                                </div>
                                            @endif
                                        </div>
                                        @if($errors->has('address_longitude'))
                                            <span class="form-text text-danger">{{$errors->first('address_longitude')}}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="address_zoom" class="col-form-label col-lg-2 font-weight-semibold @if($errors->has('address_zoom')) text-danger @endif">
                                        Zoom
                                    </label>
                                    <div class="col-lg-10">
                                        <div class="form-group-feedback form-group-feedback-right">
                                            <input id="address_zoom" name="address_zoom" type="text"
                                                   value="{{old('address_zoom') ?? $place->address?->zoom}}"
                                                   class="form-control @if($errors->has('address_zoom')) border-danger @endif">
                                            @if($errors->has('address_zoom'))
                                                <div class="form-control-feedback text-danger">
                                                    <i class="icon-cancel-circle2"></i>
                                                </div>
                                            @endif
                                        </div>
                                        @if($errors->has('address_zoom'))
                                            <span class="form-text text-danger">{{$errors->first('address_zoom')}}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="address_status" class="col-form-label col-lg-2 font-weight-semibold">
                                        Address Status:
                                    </label>
                                    <div class="col-lg-10">
                                        <div class="form-group-feedback form-group-feedback-right">
                                            <div class="form-check form-check-switchery">
                                                <label class="form-check-label">
                                                    <input type="checkbox" id="address_status" class="form-check-input-switchery" @if((string) (old('address_status') ?? $place->address?->status) === "1") checked="checked" @endif name="address_status" data-fouc>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

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
                                                            <textarea name="description[{{$language->code}}]" id="description_{{$language->code}}" cols="30" rows="10" class="form-control ckeditor @if($errors->has('description')) border-danger @endif">{{(old('description')[$language->code] ?? null) ?? ($translations[$language->code]['description'] ?? '')}}</textarea>
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
                                                    <label for="why_choose_us_{{$language->code}}" class="col-form-label col-lg-2 font-weight-semibold @if($errors->has('why_choose_us')) text-danger @endif">
                                                        Niyə bizi seçirsiz ?
                                                    </label>
                                                    <div class="col-lg-10">
                                                        <div class="form-group-feedback form-group-feedback-right">
                                                            <textarea name="why_choose_us[{{$language->code}}]" id="why_choose_us_{{$language->code}}" cols="30" rows="10" class="form-control ckeditor @if($errors->has('why_choose_us')) border-danger @endif">{{(old('why_choose_us')[$language->code] ?? null) ?? ($translations[$language->code]['why_choose_us'] ?? '')}}</textarea>
                                                            @if($errors->has('why_choose_us'))
                                                                <div class="form-control-feedback text-danger">
                                                                    <i class="icon-cancel-circle2"></i>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        @if($errors->has('why_choose_us'))
                                                            <span class="form-text text-danger">{{$errors->first('why_choose_us')}}</span>
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
    @push('footer')
        <script>

            let initialPreview = @json($initialPreview, JSON_THROW_ON_ERROR);
            let initialPreviewConfig = @json($initialPreviewConfig, JSON_THROW_ON_ERROR);

            const modalTemplate = '<div class="modal-dialog modal-lg" role="document">\n' +
                '  <div class="modal-content">\n' +
                '    <div class="modal-header align-items-center">\n' +
                '      <h6 class="modal-title">{heading} <small><span class="kv-zoom-title"></span></small></h6>\n' +
                '      <div class="kv-zoom-actions btn-group">{toggleheader}{fullscreen}{borderless}{close}</div>\n' +
                '    </div>\n' +
                '    <div class="modal-body">\n' +
                '      <div class="floating-buttons btn-group"></div>\n' +
                '      <div class="kv-zoom-body file-zoom-content"></div>\n' + '{prev} {next}\n' +
                '    </div>\n' +
                '  </div>\n' +
                '</div>\n';

            // Buttons inside zoom modal
            const previewZoomButtonClasses = {
                toggleheader: 'btn btn-light btn-icon btn-header-toggle btn-sm',
                fullscreen: 'btn btn-light btn-icon btn-sm',
                borderless: 'btn btn-light btn-icon btn-sm',
                close: 'btn btn-light btn-icon btn-sm'
            };

            // Icons inside zoom modal classes
            const previewZoomButtonIcons = {
                prev: '<i class="icon-arrow-left32"></i>',
                next: '<i class="icon-arrow-right32"></i>',
                toggleheader: '<i class="icon-menu-open"></i>',
                fullscreen: '<i class="icon-screen-full"></i>',
                borderless: '<i class="icon-alignment-unalign"></i>',
                close: '<i class="icon-cross2 font-size-base"></i>'
            };

            // File actions
            const fileActionSettings = {
                zoomClass: '',
                zoomIcon: '<i class="icon-zoomin3"></i>',
                dragClass: 'p-2',
                dragIcon: '<i class="icon-three-bars"></i>',
                removeClass: 'd-none',
                indicatorNew: '<i class="icon-file-plus text-success"></i>',
                indicatorSuccess: '<i class="icon-checkmark3 file-icon-large text-success"></i>',
                indicatorError: '<i class="icon-cross2 text-danger"></i>',
                indicatorLoading: '<i class="icon-spinner2 spinner text-muted"></i>'
            };

            $('#file-input-overwrite').fileinput({
                browseLabel: 'Browse',
                browseIcon: '<i class="icon-file-plus mr-2"></i>',
                uploadIcon: '<i class="icon-file-upload2 mr-2"></i>',
                removeIcon: '<i class="icon-cross2 font-size-base mr-2"></i>',
                layoutTemplates: {
                    icon: '<i class="icon-file-check"></i>',
                    modal: modalTemplate
                },
                initialPreview: JSON.parse(initialPreview),
                initialPreviewConfig: JSON.parse(initialPreviewConfig),
                initialPreviewAsData: true,
                overwriteInitial: true,
                previewZoomButtonClasses: previewZoomButtonClasses,
                previewZoomButtonIcons: previewZoomButtonIcons,
                fileActionSettings: fileActionSettings
            });
        </script>
    @endpush
@endsection
