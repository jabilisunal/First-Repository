<!-- Page header -->
@inject('request', 'Illuminate\Http\Request')
@if(!isset($error))
    @inject('route', 'Illuminate\Routing\Route')
@endif
<section id="common_banner"
         @if(isset($image)) style="background-image: url({{$image}}); background-position: center top; background-repeat: no-repeat; background-size: cover" @endif>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="common_bannner_text">
                    @if(isset($title))
                        <h2>{{$title}}</h2>
                    @endif
                    <ul>
                        <li>
                            <a href="{{route('home', [$current_language->code])}}">{{__('home_breadcrumbs_title')}}</a>
                        </li>
                        @if(isset($error))
                            <li>
                                <span><i class="fas fa-circle"></i></span>
                                <a href="#">{{__('404')}}</a>
                            </li>
                        @endif
                        @if(!isset($error))
                            @php($parts = explode('/', request()->path()))
                            @foreach(array_splice($parts,1,4) as $path)
                                @if(!is_numeric($path))
                                    @if(isset($model) && $path === request()->route('slug'))
                                        <li>
                                            <span><i class="fas fa-circle"></i></span>
                                            {{ucfirst($model::where(['slug' => request()->route('slug')])->first()->title)}}
                                        </li>
                                    @else
                                        <li><span><i class="fas fa-circle"></i></span> {{ucfirst(__($path))}}</li>
                                    @endif
                                @endif
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
