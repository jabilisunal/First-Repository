@extends('layouts.app')
@section('content')

    @push('common-banner')
        @include('components.common-banner')
    @endpush

    <section id="news_main_arae" class="section_padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="section_heading_center">
                        <h2>{{__('news_title')}}</h2>
                    </div>
                </div>
            </div>
            @if($popularPost)
            <div class="row">
                <div class="col-lg-7">
                    <div class="news_area_top_left">
                        <a href="{{route('news-show', [$current_language->code, $popularPost->slug])}}">
                            <img src="/storage/{{$popularPost->base_image?->path}}" alt="{{$popularPost->title}}">
                        </a>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="news_area_top_right">
                        <h2>
                            <a href="{{route('news-show', [$current_language->code, $popularPost->slug])}}">
                                {{$popularPost->title}}
                            </a>
                        </h2>
                        <p>{{shortenText(cleanBody($popularPost->description), 400)}}</p>
                        <a href="{{route('news-show', [$current_language->code, $popularPost->slug])}}">
                            {{__('read_full_article')}} <i class="fas fa-arrow-right"></i>
                        </a>
                        <div class="news_author_area">
                            <div class="news_author_area_name p-0">
                                <p>
                                    <a href="{{route('news-show', [$current_language->code, $popularPost->slug])}}">
                                        {{\Carbon\Carbon::parse($popularPost->created_at)->format('d M Y')}}
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if($posts->count() > 0)
            <div class="new_main_news_box">
                <div class="row">
                    @foreach($posts as $post)
                    <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                        <div class="news_item_boxed">
                            <div class="news_item_img">
                                <a href="{{route('news-show', [$current_language->code, $post->slug])}}">
                                    <img src="/storage/{{$post->base_image?->path}}" alt="{{$post->title}}">
                                </a>
                            </div>
                            <div class="news_item_content">
                                <h3>
                                    <a href="{{route('news-show', [$current_language->code, $post->slug])}}">
                                        {{$post->title}}
                                    </a>
                                </h3>
                                <p>{{shortenText(cleanBody($post->description))}}</p>
                            </div>
                            <div class="news_author_area">
                                <div class="news_author_area_name p-0">
                                    <p>
                                        <a href="{{route('news-show', [$current_language->code, $post->slug])}}">
                                            {{\Carbon\Carbon::parse($post->created_at)->format('d M Y')}}
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        {{$posts->links()}}
                    </div>
                </div>
            </div>
            @endif
        </div>
    </section>
@endsection
