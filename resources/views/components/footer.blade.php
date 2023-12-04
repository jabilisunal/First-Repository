@if(setting('subscribe') == 1)
    <section id="cta_area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <div class="cta_left">
                        <div class="cta_icon">
                            <img src="{{asset('storefront/assets/img/common/email.png')}}" alt="icon">
                        </div>
                        <div class="cta_content">
                            <h4>{{__('subscribe_text')}}</h4>
                            <h2>{{__('subscribe_description')}}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="cat_form">
                        <form id="cta_form_wrappper">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="{{__('email_placeholder')}}">
                                <button class="btn btn_theme btn_md" type="button">{{__('subscribe_button_text')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif

<footer id="footer_area">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="footer_heading_area">
                    <h5>{{__('support')}}</h5>
                </div>
                <div class="footer_first_area">
                    <div class="footer_inquery_area">
                        <h5>{{__('call_center_text')}}</h5>
                        <h3> <a href="tel:{{setting('phone')}}">{{setting('phone')}}</a></h3>
                    </div>
                    <div class="footer_inquery_area">
                        <h5>{{__('mail_to_text')}}</h5>
                        <h3> <a href="mailto:{{setting('email')}}">{{setting('email')}}</a></h3>
                    </div>
                    <div class="footer_inquery_area">
                        <h5>{{__('social_icons_text')}}</h5>
                        <ul class="soical_icon_footer">
                            <li><a href="{{setting('facebook')}}" target="_blank"><i class="fab fa-facebook"></i></a></li>
                            <li><a href="{{setting('twitter')}}" target="_blank"><i class="fab fa-twitter-square"></i></a></li>
                            <li><a href="{{setting('instagram')}}" target="_blank"><i class="fab fa-instagram"></i></a></li>
                            <li><a href="{{setting('linkedin')}}" target="_blank"><i class="fab fa-linkedin"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            @foreach($bottom_menus as $menu)
            <div class="col-lg-2 offset-lg-1 col-md-6 col-sm-6 col-12">
                <div class="footer_heading_area">
                    <h5>{{$menu->title}}</h5>
                </div>
                @if($menu->items->count())
                <div class="footer_link_area">
                    <ul>
                        @foreach($menu->items as $submenu)
                        <li><a href="{{$submenu->url}}" @if($submenu->target_blank === 1) target="_blank" @endif>{{$submenu->title}}</a></li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</footer>
