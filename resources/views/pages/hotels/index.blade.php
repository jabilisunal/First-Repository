@extends('layouts.app')
@section('content')
    @push('common-banner')
        @include('components.common-banner')
    @endpush

    <section id="explore_area" class="section_padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <form action="{{route('hotels-all', [$current_language->code])}}" method="GET">
                        <div class="left_side_search_area">
                            <div class="left_side_search_boxed">
                                <div class="left_side_search_heading">
                                    <h5>{{__('search_by_name')}}</h5>
                                </div>
                                <div class="name_search_form">
                                    <input type="text" class="form-control" value="{{$title}}" name="title" placeholder="{{__('search_input_placeholder')}}">
                                    <i class="fas fa-search"></i>
                                </div>
                            </div>
                            <div class="left_side_search_boxed">
                                <div class="left_side_search_heading">
                                    <h5>{{__('filter_by_price')}} ({{__('currency')}})</h5>
                                </div>
                                <div class="filter-price">
                                    <div id="price-slider-2"></div>
                                    <input type="hidden" value="{{$min_price ?? 0}}" name="min_price" id="min_price">
                                    <input type="hidden" value="{{$max_price ?? 750}}" name="max_price" id="max_price">
                                </div>
                            </div>
                            <div class="left_side_search_boxed">
                                <div class="left_side_search_heading">
                                    <h5>{{__('facilities')}}</h5>
                                </div>
                                <div class="tour_search_type">
                                    @foreach($facilities as $facility)
                                        <div class="form-check">
                                            <input class="form-check-input"
                                                   type="checkbox"
                                                   name="facilities[]"
                                                   value="{{$facility->id}}"
                                                   id="flexCheckDefault_{{$facility->id}}"
                                                   @if(in_array((int) $facility->id, $facilitiesArray)) checked="checked" @endif
                                            >
                                            <label class="form-check-label" for="lexCheckDefault_{{$facility->id}}">
                                                <span class="area_flex_one">
                                                    <span>{{$facility->name}}</span>
                                                </span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="left_side_search_boxed">
                                <button type="submit" class="apply" type="button">{{__('apply')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="cruise_search_result_wrapper">
                                @foreach($places as $place)
                                    <div class="cruise_search_item">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="cruise_item_img">
                                                    <img src="/storage/public/media/{{$place->base_image->path}}" alt="{{$place->title}}">
                                                </div>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="cruise_item_inner_content">
                                                    <div class="cruise_content_top_wrapper">
                                                        <div class="cruise_content_top_left">
                                                            <ul>
                                                                <li>{{$place->destination?->name}}</li>
                                                            </ul>
                                                            <h4>{{$place->title}}</h4>
                                                            <p><i class="fas fa-map-marker-alt"></i> {{$place->address?->name}}, {{$place->destination?->name}}</p>
                                                        </div>
                                                        <div class="cruise_content_top_right">
                                                            <h5>{{$place->rating}} / 5 {{getRatingStatus($place->rating)}}</h5>
                                                            <h4>({{$place->reviews->count()}} {{__('reviews')}})</h4>
                                                        </div>
                                                    </div>
                                                    <div class="cruise_content_middel_wrapper">
                                                        <div class="cruise_content_middel_left">
                                                            <p>{{shortenText(cleanBody($place->description), 70)}}</p>
                                                        </div>
                                                        <div class="cruise_content_middel_right">
                                                            <h3>{{$place->price}} {{__('currency')}}</h3>
                                                        </div>
                                                    </div>
                                                    <div class="cruise_content_bottom_wrapper">
                                                        <div class="cruise_content_bottom_left">
                                                            <ul>
                                                                @foreach($place->facilities as $facility)
                                                                    <li class="mb-2">{{$facility->name}}</li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                        <div class="cruise_content_bottom_right">
                                                            <a href="{{route('hotels-show', [$current_language->code, $place->slug])}}" class="btn btn_theme btn_md">{{__('view_details')}}</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="load_more_flight">
                                {{$places->links('vendor.pagination.bootstrap-4', ['title' => $title, 'min_price' => $min_price, 'max_price' => $max_price, 'facilities' => $facilitiesArray, 'page' => $page])}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('footer')
        <script>
            if (typeof noUiSlider === 'object') {
                let priceSlider = document.getElementById('price-slider-2');

                noUiSlider.create(priceSlider, {
                    start: [{{(int) $min_price}}, {{(int) $max_price}}],
                    connect: true,
                    step: 1,
                    margin: 200,
                    range: {
                        'min': 0,
                        'max': 1000
                    },
                    tooltips: true,
                    format: wNumb({
                        decimals: 0
                    })
                }).on('change', function (data) {
                    let minInput = document.getElementById('min_price');
                    let maxInput = document.getElementById('max_price');

                    minInput.value = data[0];
                    maxInput.value = data[1];
                });
            }
        </script>
    @endpush
@endsection
