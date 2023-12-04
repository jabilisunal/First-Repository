@extends('layouts.app')
@section('content')
    @push('common-banner')
        @include('components.common-banner')
    @endpush

    <section id="faqs_main_arae" class="section_padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="section_heading_center">
                        <h2>{{__('faq_title')}}</h2>
                    </div>
                </div>
            </div>
            <div class="faqs_area_top">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="faqs_three_area_wrapper">
                            <div class="faqs_item_wrapper">
                                <div class="faqs_main_item">
                                    <div class="accordion" id="accordionExample">
                                        @foreach($faqs as $key => $faq)
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingOne">
                                                <button class="accordion-button @if($key !== 0) collapsed @endif" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#collapse_{{$faq->id}}"
                                                        aria-expanded="true"
                                                        aria-controls="collapse_{{$faq->id}}">
                                                    {{$faq->title}}
                                                </button>
                                            </h2>
                                            <div id="collapse_{{$faq->id}}"
                                                 class="accordion-collapse collapse @if($key === 0) show @endif"
                                                 aria-labelledby="heading_{{$faq->id}}"
                                                 data-bs-parent="#accordionExample_{{$faq->id}}">
                                                <div class="accordion-body">
                                                    <div class="mb-5 mt-5">
                                                        <img src="/storage/{{$faq->base_image?->path}}" alt="{{$faq->title}}">
                                                    </div>
                                                    <div>
                                                        <p>{!! $faq->description !!}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="faqs_call_area">
                            <img src="{{asset('storefront/assets/img/icon/call.png')}}" alt="img">
                            <h5>{{__('contact_us_text')}}</h5>
                            <h3><a href="tel:{{setting('phone')}}">{{setting('phone')}}</a></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
