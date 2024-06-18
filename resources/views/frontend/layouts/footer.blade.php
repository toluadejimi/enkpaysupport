<!-- footer area start -->

<footer class="footer-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 ">
                <div class="single-widget">
                    <div class="footer-logo">
                        <a href=""><img src="{{ getFileUrl(getGeneralSettingData(getUserIdByTenant(),'app_footer_logo')) }}"
                                        alt="{{ getGeneralSettingData(getUserIdByTenant(),'app_name') }}"></a>
                    </div>
                    <p>{{strip_tags(getCmsSetting(getUserIdByTenant(),'app_footer_text'))}}</p>
                </div>
            </div>
            <div class="col-lg-2 offset-lg-1 col-md-4">
                <div class="single-widget-menu">
                    <h2>{{__('Quick Links')}}</h2>
                    <ul>
                        <li><a href="{{route('tenant.faqs')}}">{{__('FAQ’s')}}</a></li>
                        @if (isAddonInstalled('DESKSAAS') > 0)
                            <li><a href="{{route('pricing')}}">{{__('pricing plan')}}</a></li>
                        @endif
                        <li><a href="{{route('tenant.contact.us.index')}}">{{__('contact us')}}</a></li>
                        <li><a href="{{route('terms.of.use.index')}}">{{__('Terms Of Condition')}}</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-2 col-md-4">
                <div class="single-widget-menu">
                    <h2>{{__('Useful Links')}}</h2>
                    <ul>
                        <li><a href="{{route('login')}}">{{__('sign in')}}</a></li>
                        <li><a href="{{route('register')}}">{{__('sign up')}}</a></li>
                        <li><a href="{{route('password.request')}}">{{__('forgot password')}}</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-2 col-md-4">
                <div class="single-widget-menu">
                    <h2>{{__('Contact Info')}}</h2>
                    <ul class="social-icon">
                        <li><a href="{{ getCmsSetting(getUserIdByTenant(), 'facebook_url') }}"><img src="{{asset('frontend')}}/assets/images/facebook.png" alt=""> {{ __('facebook') }}</a></li>
                        <li><a href="{{ getCmsSetting(getUserIdByTenant(), 'twitter_url') }}"><img src="{{asset('frontend')}}/assets/images/twitter.png" alt=""> {{ __('twitter') }}</a></li>
                        <li><a href="{{ getCmsSetting(getUserIdByTenant(), 'instagram_url') }}"><img src="{{asset('frontend')}}/assets/images/instagram.png" alt=""> {{ __('instagram') }}</a></li>
                        <li><a href="{{ getCmsSetting(getUserIdByTenant(), 'linkedin_url') }}"><img src="{{asset('frontend')}}/assets/images/linkedin.png" alt=""> {{ __('linkedin') }}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
<div class="copyright">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="copy-right">
                    <p>{{ getGeneralSettingData(getUserIdByTenant(),'app_copyright') }}<a
                            href="{{route('frontend')}}"> {{ getGeneralSettingData(getUserIdByTenant(),'app_developed') }}</a></p>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- footer area end -->
