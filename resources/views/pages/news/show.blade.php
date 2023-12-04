@extends('layouts.app')
@section('content')

    @push('common-banner')
        @include('components.common-banner', [
            'title' => $post->title,
            'model' => '\App\Models\Post'
        ])
    @endpush

    <section id="news_details_main_arae" class="section_padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="news_detail_wrapper">
                        <div class="news_details_content_area">
                            <img src="/storage/{{$post->base_image?->path}}" alt="{{$post->title}}">
                            <h2>{{$post->title}}</h2>
                            <div>{!! $post->description !!}</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="news_details_rightbar">
                        @if($recentPosts->count() > 0)
                        <div class="news_details_right_item">
                            <h3>{{__('recent_news')}}</h3>
                            @foreach($recentPosts as $recentPost)
                            <div class="recent_news_item">
                                <div class="recent_news_img">
                                    <img src="/storage/{{$recentPost->base_image?->path}}" alt="{{$recentPost->title}}">
                                </div>
                                <div class="recent_news_text">
                                    <h5>
                                        <a href="{{route('news-show', [$current_language->code, $recentPost->slug])}}">
                                            {{$recentPost->title}}
                                        </a>
                                    </h5>
                                    <p>
                                        <a href="{{route('news-show', [$current_language->code, $recentPost->slug])}}">
                                            {{\Carbon\Carbon::parse($recentPost->created_at)->format('d M Y')}}
                                        </a>
                                    </p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                        <div class="news_details_right_item">
                            <h3>{{__('share_causes')}}</h3>
                            <div class="share_icon_area">
                                <div class="sharethis-inline-share-buttons"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('footer')
        <script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=62b2daf8fe3bb900199aabe3&product=inline-share-buttons' async='async'></script>
    @endpush
@endsection
