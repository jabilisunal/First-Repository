@extends('layouts.app')
@section('content')
    @push('common-banner')
        @include('components.common-banner', [
            'title' => $page->title,
            'model' => '\App\Models\Page'
        ])
    @endpush
    <section id="tour_details_main" class="section_padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="terms_service_content">
                        <div class="terms_item">
                            {!! $page->description !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
