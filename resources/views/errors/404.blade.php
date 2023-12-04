@extends('layouts.app')
@section('content')
    @push('common-banner')
        @include('components.common-banner', ['error' => true])
    @endpush
    <section id="error_main" class="section_padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-12 col-sm-12 col-12">
                    <div class="error_content text-center">
                        <img src="{{asset('storefront/assets/img/common/error.png')}}" alt="img">
                        <h2>{{__('not_found')}}</h2>
                        <a href="{{route('home', [$current_language->code])}}" class="btn btn_theme btn_md">{{__('back_to_home')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
