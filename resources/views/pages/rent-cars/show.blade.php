@extends('layouts.app')
@section('content')
    @push('common-banner')
        @include('components.common-banner', [
            'title' => $rent->title,
            'model' => '\App\Models\RentCar',
            'image' => '/storage/public/media/'.$rent->cover_image->path
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
                                <h2>{{$rent->title}}</h2>
                                @if($rent->address)
                                    <h5><i class="fas fa-map-marker-alt"></i> {{$rent->address?->name}}</h5>
                                @endif
                            </div>
                            <div class="tour_details_top_heading_right">
                                <h4></h4>
                            </div>
                        </div>
                        <div class="tour_details_img_wrapper">
                            <div class="slider-for">
                                @foreach($rent->additional_images as $key => $image)
                                    <div>
                                        <img src="/storage/public/media/{{$image->path}}" style="width: 930px; height: 450px; object-fit: contain" alt="{{$rent->title}} {{$key + 1}}">
                                    </div>
                                @endforeach
                            </div>
                            <div class="slider-nav">
                                @foreach($rent->additional_images as $key => $image)
                                    <div>
                                        <img src="/storage/public/media/{{$image->path}}" style="width: 145px; height: 130px; object-fit: contain" alt="{{$rent->title}} {{$key + 1}}">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="tour_details_boxed">
                            <h3 class="heading_theme">{{__('description')}}</h3>
                            <div class="tour_details_boxed_inner">
                                {!! $rent->description !!}
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
                                    <h4>{{$rent->daily_price}} {{__('currency')}}<sub> / {{__('per_day')}}</sub></h4>
                                </div>
                                <div class="tour_package_bar_price">
                                    <h4>{{$rent->weekly_price}} {{__('currency')}}<sub> / {{__('per_week')}}</sub></h4>
                                </div>
                                <div class="tour_package_bar_price">
                                    <h4>{{$rent->monthly_price}} {{__('currency')}}<sub> / {{__('per_month')}}</sub></h4>
                                </div>
                            </div>
                            <div class="tour_select_offer_bar_bottom">
                                <button class="btn btn_theme btn_md w-100" data-bs-toggle="offcanvas"
                                        data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">{{__('apply')}}</button>
                            </div>
                        </div>
                        <div class="tour_detail_right_sidebar">
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
                                        src="https://maps.google.com/maps?q={{$rent->address->latitude}},{{$rent->address->longitude}}&hl={{$current_language->code}}&z={{$rent->address->zoom}}&amp;output=embed">
                                    </iframe>
                                </div>
                            </div>
                            <div class="tour_details_boxed">
                                <h3 class="heading_theme">{{__('facilities')}}</h3>
                                <div class="tour_details_boxed_inner">
                                    <div class="room_details_facilities">
                                        @foreach($rent->facilities as $facility)
                                            <div class="toru_details_top_bottom_item">
                                                <div class="tour_details_top_bottom_icon">
                                                    <img src="/storage/{{$facility->base_image?->path}}" style="width: 25px; height: 25px; object-fit: contain" alt="{{$facility->name}}">
                                                </div>
                                                <div class="tour_details_top_bottom_text">
                                                    <p>{{$facility->name}}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if($relatedRentCars->count() > 0)
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
                            @foreach($relatedRentCars as $key => $relatedRentCar)
                                <div class="theme_common_box_two img_hover">
                                    <div class="theme_two_box_img">
                                        <img src="/storage/public/media/{{$relatedRentCar->base_image?->path}}" alt="{{$relatedRentCar->title}}">
                                        <p>
                                            <i class="fas fa-map-marker-alt"></i>{{$relatedRentCar->destination?->name}}
                                        </p>
                                    </div>
                                    <div class="theme_two_box_content">
                                        <h4>
                                            <a href="{{route('rent-cars-show', [$current_language->code, $relatedRentCar->slug])}}">{{$relatedRentCar->address?->name}}</a>
                                        </h4>
                                        <h3>{{$relatedRentCar->daily_price}} {{__('currency')}} / {{__('per_day')}}</h3>
                                        <h3>{{$relatedRentCar->weekly_price}} {{__('currency')}} / {{__('per_week')}}</h3>
                                        <h3>{{$relatedRentCar->monthlyprice}} {{__('currency')}} / {{__('per_month')}}</h3>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @include('components.book', ['model_type' => \App\Models\RentCar::class, 'model_id' => $rent->id])

@endsection
