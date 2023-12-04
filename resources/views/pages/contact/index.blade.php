@extends('layouts.app')
@section('content')
    @push('common-banner')
        @include('components.common-banner')
    @endpush

    <section id="contact_main_arae" class="section_padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="section_heading_center">
                        <h2>{{__('contact_title')}}</h2>
                    </div>
                </div>
            </div>
            <div class="contact_main_form_area_two">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="contact_left_top_heading">
                            <h3>{{__('contact_sub_title')}}</h3>
                            <p>{{__('contact_text')}}</p>
                        </div>
                        <div class="contact_form_two">
                            <form action="!#" id="contact_form_content">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control bg_input" placeholder="{{__('first_name_placeholder')}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control bg_input" placeholder="{{__('last_name_placeholder')}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control bg_input" placeholder="{{__('email_placeholder')}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control bg_input" placeholder="{{__('mobile_numbers_placeholder')}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <textarea class="form-control bg_input" rows="5" placeholder="{{__('message_placeholder')}}"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <button type="button" class="btn btn_theme btn_md">{{__('send_message')}}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="contact_two_left_wrapper">
                            <h3>{{__('contact_details')}}</h3>
                            <div class="contact_details_wrapper">
                                <div class="contact_detais_item">
                                    <h4>{{__('help_line')}}</h4>
                                    <h3><a href="tel:{{setting('phone')}}">{{setting('phone')}}</a></h3>
                                </div>
                                <div class="contact_detais_item">
                                    <h4>{{__('support_email')}}</h4>
                                    <h3><a href="mailto:{{setting('email')}}">{{setting('email')}}</a></h3>
                                </div>
                                <div class="contact_detais_item">
                                    <h4>{{__('contact_hours')}}</h4>
                                    <h3>{{setting('contact_hours')}}</h3>
                                </div>
                                <div class="contact_map_area">
                                    <iframe
                                        width="456"
                                        height="206"
                                        frameborder="0"
                                        scrolling="no"
                                        marginheight="0"
                                        marginwidth="0"
                                        src="https://maps.google.com/maps?q={{setting('latitude')}},{{setting('longitude')}}}}&hl={{$current_language->code}}&z={{setting('zoom')}}&amp;output=embed">
                                    </iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
