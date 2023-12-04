@extends('layouts.app')
@section('content')
    @push('common-banner')
        @include('components.common-banner', [
            'title' => $restaurant->title,
            'model' => '\App\Models\Place',
            'image' => '/storage/public/media/'.$restaurant->cover_image->path
        ])
    @endpush

    <section id="tour_details_main" class="section_padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    @if(session()->get('show'))
                        <div class="alert alert-{{session()->get('type')}}">
                            {{session()->get('message')}}
                        </div>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <div class="tour_details_leftside_wrapper">
                        <div class="tour_details_heading_wrapper">
                            <div class="tour_details_top_heading">
                                <h2>{{$restaurant->title}}</h2>
                                @if($restaurant->address)
                                    <h5><i class="fas fa-map-marker-alt"></i> {{$restaurant->address?->name}}</h5>
                                @endif
                            </div>
                            <div class="tour_details_top_heading_right">
                                <h4></h4>
                            </div>
                            <div class="tour_details_top_heading_right">
                                <h4>{{getRatingStatus($restaurant->rating)}}</h4>
                                <h6>{{$restaurant->rating}}/5</h6>
                                <p>({{$restaurant->reviews->count()}} {{__('reviews')}})</p>
                            </div>
                        </div>
                        <div class="tour_details_img_wrapper">
                            <div class="slider-for">
                                @foreach($restaurant->additional_images as $key => $image)
                                    <div>
                                        <img src="/storage/public/media/{{$image->path}}"
                                             style="width: 930px; height: 450px; object-fit: contain"
                                             alt="{{$restaurant->title}} {{$key + 1}}">
                                    </div>
                                @endforeach
                            </div>
                            <div class="slider-nav">
                                @foreach($restaurant->additional_images as $key => $image)
                                    <div>
                                        <img src="/storage/public/media/{{$image->path}}"
                                             style="width: 145px; height: 130px; object-fit: contain"
                                             alt="{{$restaurant->title}} {{$key + 1}}">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="tour_details_boxed">
                            <h3 class="heading_theme">{{__('description')}}</h3>
                            <div class="tour_details_boxed_inner">
                                {!! $restaurant->description !!}
                            </div>
                        </div>
                        <div class="tour_details_boxed">
                            <h3 class="heading_theme">{{__('facilities')}}</h3>
                            <div class="tour_details_boxed_inner">
                                <div class="room_details_facilities">
                                    @foreach($restaurant->facilities as $facility)
                                        <div class="toru_details_top_bottom_item">
                                            <div class="tour_details_top_bottom_icon">
                                                <img src="/storage/{{$facility->base_image?->path}}"
                                                     style="width: 25px; height: 25px; object-fit: contain"
                                                     alt="{{$facility->name}}">
                                            </div>
                                            <div class="tour_details_top_bottom_text">
                                                <p>{{$facility->name}}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="tour_details_boxed">
                            <h3 class="heading_theme">{{__('location')}}</h3>
                            <div class="map_area">
                                <iframe
                                    width="896"
                                    height="306"
                                    frameborder="0"
                                    scrolling="no"
                                    marginheight="0"
                                    marginwidth="0"
                                    src="https://maps.google.com/maps?q={{$restaurant->address->latitude}},{{$restaurant->address->longitude}}&hl={{$current_language->code}}&z={{$restaurant->address->zoom}}&amp;output=embed">
                                </iframe>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="tour_details_right_sidebar_wrapper">
                        <div class="tour_detail_right_sidebar">
                            <div class="tour_details_right_boxed" style="border-bottom-left-radius: 0; border-bottom-right-radius: 0">
                                <div class="tour_details_right_box_heading">
                                    <h3>{{__('price')}}</h3>
                                </div>
                                <div class="tour_package_bar_price">
                                    <h6>
                                        <del>{{$restaurant->price}} {{__('currency')}}</del>
                                    </h6>
                                    <h3>{{$restaurant->price}} {{__('currency')}}<sub> / {{__('per_person')}}</sub></h3>
                                </div>

                            </div>
                            <div class="tour_select_offer_bar_bottom">
                                <button class="btn btn_theme btn_md w-100" data-bs-toggle="offcanvas"
                                        data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">{{__('apply')}}</button>
                            </div>

                        </div>
                        <div class="tour_detail_right_sidebar">
                            <div class="tour_details_right_boxed">
                                <div class="tour_details_right_box_heading">
                                    <h3>{{__('why_choose_us')}}</h3>
                                </div>

                                <div class="tour_package_details_bar_list first_child_padding_none">
                                    <p>{!! $restaurant->why_choose_us !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="write_your_review_wrapper">
                        <h3 class="heading_theme">{{__('write_your_review')}}</h3>
                        <div class="write_review_inner_boxed">
                            <form action="{{route('storeReview', [$current_language->code])}}" method="post"
                                  id="news_comment_form">
                                @csrf
                                <div class="row">
                                    <input type="hidden" value="5" name="rating">
                                    <input type="hidden" value="{{$restaurant->id}}" name="model_id">
                                    <input type="hidden" value="{{\App\Models\Place::class}}" name="model_type">
                                    <div class="col-lg-6">
                                        <div class="form-froup">
                                            <input type="text"
                                                   class="form-control bg_input @if($errors->has('full_name')) border-danger @endif"
                                                   value="{{old('full_name')}}" name="full_name"
                                                   placeholder="{{__('full_name_placeholder')}}">
                                            @if($errors->has('full_name'))
                                                <span
                                                    class="form-text text-danger">{{$errors->first('full_name')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-froup">
                                            <input type="text"
                                                   class="form-control bg_input @if($errors->has('email')) border-danger @endif"
                                                   name="email" value="{{old('email')}}"
                                                   placeholder="{{__('email_placeholder')}}">
                                            @if($errors->has('email'))
                                                <span class="form-text text-danger">{{$errors->first('email')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-froup">
                                            <div class="rating">
                                                <i class="fa fa-star" data-rate="1"></i>
                                                <i class="fa fa-star" data-rate="2"></i>
                                                <i class="fa fa-star" data-rate="3"></i>
                                                <i class="fa fa-star" data-rate="4"></i>
                                                <i class="fa fa-star" data-rate="5"></i>
                                                <input type="hidden" id="rating-count" name="rating" value="0">
                                            </div>
                                            @if($errors->has('rating'))
                                                <span class="form-text text-danger">{{$errors->first('rating')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-froup">
                                            <textarea rows="6" placeholder="{{__('message_placeholder')}}"
                                                      name="message"
                                                      class="form-control bg_input @if($errors->has('message')) border-danger @endif">{{old('message')}}</textarea>
                                            @if($errors->has('message'))
                                                <span class="form-text text-danger">{{$errors->first('message')}}</span>
                                            @endif
                                        </div>
                                        <div class="comment_form_submit">
                                            <button type="submit"
                                                    class="btn btn_theme btn_md">{{__('post_comment')}}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="all_review_wrapper">
                        <h3 class="heading_theme">{{__('all_review')}}</h3>
                    </div>
                </div>
                @foreach($restaurant->reviews as $review)
                    <div class="col-lg-4 col-md-6">
                        <div class="all_review_box">
                            <div class="all_review_date_area">
                                <div class="all_review_date">
                                    <h5>{{\Carbon\Carbon::parse($review->created_at)->format('d M, Y')}}</h5>
                                </div>
                                <div class="all_review_star">
                                    <div class="review_star_all">
                                        @for($i = 1; $i <= $review->rating; $i++)
                                            <i class="fas fa-star"></i>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <div class="all_review_text">
                                <img src="{{asset('storefront/assets/img/user.png')}}" alt="img">
                                <h4>{{$review->full_name}}</h4>
                                <p>{{$review->message}}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    @if($relatedRestaurants->count() > 0)
        <section id="related_tour_packages" class="section_padding_bottom">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="section_heading_center">
                            <h2>{{__('related_hotels')}}</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="promotional_tour_slider owl-theme owl-carousel dot_style">
                            @foreach($relatedRestaurants as $key => $relatedRestaurant)
                                <div class="theme_common_box_two img_hover">
                                    <div class="theme_two_box_img">
                                        <img src="/storage/public/media/{{$relatedRestaurant->base_image?->path}}" alt="{{$relatedRestaurant->title}}">
                                        <p>
                                            <i class="fas fa-map-marker-alt"></i>{{$relatedRestaurant->destination?->name}}
                                        </p>
                                    </div>
                                    <div class="theme_two_box_content">
                                        <h4>
                                            <a href="{{route('hotels-show', [$current_language->code, $relatedRestaurant->slug])}}">{{$relatedRestaurant->address?->name}}</a>
                                        </h4>
                                        <p>
                                            <span class="review_rating">{{$relatedRestaurant->rating}} / 5 {{getRatingStatus($relatedRestaurant->rating)}}</span>
                                            <span class="review_count">({{$relatedRestaurant->reviews->count()}} {{__('reviews')}})</span>
                                        </p>
                                        @if($relatedRestaurant->price > 0)
                                        <h3>{{$relatedRestaurant->price}} {{__('currency')}}</h3>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @include('components.book', ['model_type' => \App\Models\Place::class, 'model_id' => $restaurant->id])
@endsection
