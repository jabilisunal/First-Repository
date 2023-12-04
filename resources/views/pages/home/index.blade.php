@extends('layouts.app')
@section('content')

    @if($sliderBanner)
        <section id="home_one_banner" style="background-image: url('/storage/{{$sliderBanner->base_image->path}}');">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-12">
                        <div class="banner_one_text">
                            <h1>{{$sliderBanner->title}}</h1>
                            <div>{!! $sliderBanner->description !!}</div>
                        </div>
                        <div class="social-area">
                            <ul>
                                <li>
                                    <a href="{{setting('snapchat')}}" target="_blank">
                                        <img src="{{asset('storefront/assets/img/social/snapchat.png')}}" alt="snapchat">
                                    </a>
                                </li>
                                <li>
                                    <a href="{{setting('instagram')}}" target="_blank">
                                        <img src="{{asset('storefront/assets/img/social/instagram.png')}}" alt="instagram">
                                    </a>
                                </li>
                                <li>
                                    <a href="{{setting('tiktok')}}" target="_blank">
                                        <img src="{{asset('storefront/assets/img/social/tiktok.png')}}" alt="tiktok">
                                    </a>
                                </li>
                                <li>
                                    <a href="{{setting('facebook')}}" target="_blank">
                                        <img src="{{asset('storefront/assets/img/social/facebook.png')}}" alt="">
                                    </a>
                                </li>
                                <li>
                                    <a href="{{setting('telegram')}}" target="_blank">
                                        <img src="{{asset('storefront/assets/img/social/telegram.png')}}" alt="telegram">
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if($sliderBottomBanners->count() > 0)
    <section id="go_beyond_area" class="section_padding_top">
        <div class="container">
            <div class="row align-items-center">
                @foreach($sliderBottomBanners as $sliderBottomBanner)
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 col-6">
                    <div class="imagination_boxed">
                        <a href="{{$sliderBottomBanner->button_url}}">
                            <img src="/storage/{{$sliderBottomBanner->base_image?->path}}" alt="{{$sliderBottomBanner->title}}">
                        </a>
                        <h3>
                            <a href="{{$sliderBottomBanner->button_url}}">
                                {{$sliderBottomBanner->title}} <span>{{$sliderBottomBanner->button_title}}</span>
                            </a>
                        </h3>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    @if($categories->count() > 0)
    <section id="destinations_area" class="section_padding_top">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="section_heading_center">
                        <h2>{{__('destination_for_you')}}</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <div class="theme_nav_tab">
                        <nav class="theme_nav_tab_item">
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                @foreach($categories as $key => $category)
                                    <button class="nav-link @if($key == 0) active @endif"
                                            id="nav-{{$category->id}}-tab"
                                            data-bs-toggle="tab"
                                            data-bs-target="#nav-{{$category->id}}"
                                            type="button"
                                            role="tab"
                                            aria-controls="nav-{{$category->id}}"
                                            aria-selected="true">
                                        {{$category->title}}
                                    </button>
                                @endforeach
                            </div>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="tab-content" id="nav-tabContent1">
                        @foreach($categories as $key => $category)
                        <div class="tab-pane fade @if($key == 0) show active @endif" id="nav-{{$category->id}}" role="tabpanel" aria-labelledby="nav-{{$category->id}}-tab">
                            <div class="row">
                                @if(isset($categoryRegionGroups[$category->slug]))
                                @foreach($categoryRegionGroups[$category->slug] as $regionGroups)
                                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="tab_destinations_boxed">
                                        <div class="tab_destinations_img">
                                            <a href="{{route($category->slug, [$current_language->code, $regionGroups->slug])}}">
                                                <img src="/storage/{{$regionGroups->base_image?->path}}" style="width: 100px;" alt="img"/>
                                            </a>
                                        </div>
                                        <a href="{{route($category->slug, [$current_language->code, $regionGroups->slug])}}">
                                            <div class="tab_destinations_conntent">
                                                <h3>
                                                    {{$regionGroups->name}}
                                                </h3>
                                                <p>{{$regionGroups->description}}</p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                @endforeach
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

    <section id="explore_area" class="section_padding_top">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="section_heading_left d-flex justify-content-between align-items-center">
                        <h2>{{__('popular_hotels_title')}}</h2>
                        <div class="seeall_link">
                            <a href="{{route('hotels-all', [$current_language->code])}}">
                                {{__('see_all_hotels')}}<i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        @foreach($popularHotels as $popularHotel)
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <div class="theme_common_box_two img_hover">
                                <div class="theme_two_box_img">
                                    <a href="{{route('hotels-show', [$current_language->code, $popularHotel->slug])}}">
                                        <img src="/storage/public/media/{{$popularHotel->base_image->path}}" alt="{{$popularHotel->title}}">
                                    </a>
                                    <p>
                                        <i class="fas fa-map-marker-alt"></i> {{$popularHotel->address?->name ?? $popularHotel->destination?->name}}
                                    </p>
                                </div>
                                <div class="theme_two_box_content">
                                    <h4>
                                        <a href="{{route('hotels-show', [$current_language->code, $popularHotel->slug])}}">
                                            {{$popularHotel->title}}, {{$popularHotel->destination?->name}}
                                        </a>
                                    </h4>
                                    <p>
                                        <span class="review_rating">{{$popularHotel->rating}} / 5 {{getRatingStatus($popularHotel->rating)}}</span>
                                        <span class="review_count">({{$popularHotel->reviews->count()}} {{__('reviews')}})</span>
                                    </p>
                                    <h3>{{$popularHotel->price}} {{__('currency')}}</h3>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="offer_area" class="section_padding_top">
        <div class="container">
            <div class="row">

                @if($specialOfferBanner)
                <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                    <div class="offer_area_box d-none-phone img_animation">
                        <img src="/storage/{{$specialOfferBanner->base_image?->path}}" alt="{{$specialOfferBanner->title}}">
                        <div class="offer_area_content">
                            <h2>{{$specialOfferBanner->title}}</h2>
                            <p>{!! $specialOfferBanner->description !!}</p>
                            <a href="{{$specialOfferBanner->button_url}}" class="btn btn_theme btn_md">{{$specialOfferBanner->button_title}}</a>
                        </div>
                    </div>
                </div>
                @endif

                @if($newsLetterBanner)
                <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                    <div class="offer_area_box img_animation">
                        <img src="/storage/{{$newsLetterBanner->base_image?->path}}" alt="{{$newsLetterBanner->title}}">
                        <div class="offer_area_content">
                            <h2>{{$newsLetterBanner->title}}</h2>
                            <p>{!! $newsLetterBanner->description !!}</p>
                            <a href="{{$newsLetterBanner->button_url}}" class="btn btn_theme btn_md">{{$newsLetterBanner->button_title}}</a>
                        </div>
                    </div>
                </div>
                @endif

                @if($travelTipsBanner)
                    <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                        <div class="offer_area_box img_animation">
                            <img src="/storage/{{$travelTipsBanner->base_image?->path}}" alt="{{$travelTipsBanner->title}}">
                            <div class="offer_area_content">
                                <h2>{{$travelTipsBanner->title}}</h2>
                                <p>{!! $travelTipsBanner->description !!}</p>
                                <a href="{{$travelTipsBanner->button_url}}" class="btn btn_theme btn_md">{{$travelTipsBanner->button_title}}</a>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </section>

    <section id="promotional_tours" class="section_padding_top">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="section_heading_left d-flex justify-content-between align-items-center">
                        <h2>{{__('popular_tours_title')}}</h2>
                        <div class="seeall_link">
                            <a href="{{route('tours-all', [$current_language->code])}}">
                                {{__('see_all_tours')}}<i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        @foreach($popularTours as $popularTour)
                            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                <div class="theme_common_box_two img_hover">
                                    <div class="theme_two_box_img">
                                        <a href="{{route('tours-show', [$current_language->code, $popularTour->slug])}}">
                                            <img src="/storage/public/media/{{$popularTour->base_image->path}}" alt="{{$popularTour->title}}">
                                        </a>
                                        <p>
                                            <i class="fas fa-map-marker-alt"></i> {{$popularTour->address?->name ?? $popularTour->destination?->name}}
                                        </p>
                                    </div>
                                    <div class="theme_two_box_content">
                                        <h4>
                                            <a href="{{route('tours-show', [$current_language->code, $popularTour->slug])}}">
                                                {{$popularTour->title}}, {{$popularTour->destination?->name}}
                                            </a>
                                        </h4>
                                        <p>
                                            <span class="review_rating">{{$popularTour->rating}} / 5 {{getRatingStatus($popularTour->rating)}}</span>
                                            <span class="review_count">({{$popularTour->reviews->count()}} {{__('reviews')}})</span>
                                        </p>
                                        <h3>{{$popularTour->price}} {{__('currency')}}</h3>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="home_news" class="section_padding_top mb-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="section_heading_left d-flex justify-content-between align-items-center">
                        <h2>{{__('last_news_title')}}</h2>
                        <div class="seeall_link">
                            <a href="{{route('news', [$current_language->code])}}">
                                {{__('see_all_article')}}<i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="@if($cuffPost) col-lg-6 @else col-lg-12 @endif">
                    @if($posts->count() > 0)
                    <div class="home_news_left_wrapper">
                        @foreach($posts as $post)
                            <div class="home_news_item">
                                <div class="home_news_img">
                                    <a href="{{route('news-show', [$current_language->code, $post->slug])}}">
                                        <img src="/storage/{{$post->base_image?->path}}" alt="{{$post->title}}">
                                    </a>
                                </div>
                                <div class="home_news_content">
                                    <h3>
                                        <a href="{{route('news-show', [$current_language->code, $post->slug])}}">{{$post->title}}</a>
                                    </h3>
                                    <p>
                                        <a href="{{route('news-show', [$current_language->code, $post->slug])}}">
                                            {{\Carbon\Carbon::parse($post->created_at)->format('d M Y')}}
                                        </a>
                                    </p>
                                </div>
                            </div>
                        @endforeach
                        <div class="home_news_item">
                            <div class="seeall_link">
                                <a href="{{route('news', [$current_language->code])}}">
                                    {{__('see_all_article')}}<i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                @if($cuffPost)
                    <div class="col-lg-6">
                        <div class="home_news_big">
                            <div class="news_home_bigest img_hover">
                                <a href="{{route('news-show', [$current_language->code, $cuffPost->slug])}}">
                                    <img src="/storage/{{$cuffPost->base_image?->path}}" alt="img">
                                </a>
                            </div>
                            <h3>
                                <a href="{{route('news-show', [$current_language->code, $cuffPost->slug])}}">{{$cuffPost->title}}</a>
                            </h3>
                            <p>{{shortenText(cleanBody($cuffPost->description), 400)}}</p>
                            <a href="{{route('news-show', [$current_language->code, $cuffPost->slug])}}">
                                {{__('read_full_article')}}
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    @if($features->count() > 0)
        <section id="about_service_offer" class="section_padding_bottom">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="section_heading_center">
                            <h2>{{__('how_do_we_work_title')}}</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach($features as $feature)
                        <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                            <div class="about_service_boxed">
                                <img src="/storage/{{$feature->base_image?->path}}" alt="img">
                                <h5><a href="#!">{{$feature->title}}</a></h5>
                                {!! $feature->description !!}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if($partners->count() > 0)
        <section id="our_partners" class="section_padding">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="section_heading_center">
                            <h2>{{__('our_partners_title')}}</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="partner_slider_area owl-theme owl-carousel">
                            @foreach($partners as $partner)
                                <div class="partner_logo">
                                    <a href="{{$partner->url}}" target="_blank">
                                        <img src="/storage/{{$partner->base_image->path}}" alt="logo">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

@endsection
