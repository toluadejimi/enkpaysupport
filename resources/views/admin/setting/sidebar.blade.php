<div class="email__sidebar bg-style">
    <div class="sidebar__item">
        <ul class="sidebar__mail__nav">
            <h2>{{__('Application Setting')}}</h2>

            <li>
                <a href="{{ route('admin.setting.application-settings') }}" class="list-item {{ @$subApplicationSettingActiveClass }}">
                    <img src="{{ asset('admin/images/heroicon/outline/cog.svg') }}" alt="icon">
                    <span>{{__('Application Setting')}}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.setting.currencies.index') }}" class="list-item {{ @$subCurrencyActiveClass }}">
                    <img src="{{ asset('admin/images/heroicon/outline/cog.svg') }}" alt="icon">
                    <span>{{ __('Currency ') }}</span>
                </a>
            </li>
            <li>
                <a class="list-item {{ @$subStorageSettingActiveClass }}" href="{{ route('admin.setting.storage.index') }}">
                    <img src="{{ asset('admin/images/heroicon/outline/cog.svg') }}" alt="icon">
                    <span>{{ __('Storage Setting') }}</span>
                </a>
            </li>
            <li>
                <a class="list-item {{ @$subSocialLoginSettingActiveClass }}" href="{{ route('admin.setting.social-login') }}">
                    <img src="{{ asset('admin/images/heroicon/outline/cog.svg') }}" alt="icon">
                    <span>{{ __('Social Login') }}</span>
                </a>
            </li>
            <li>
                <a class="list-item {{ @$subGoogleRecaptchaSettingActiveClass }}" href="{{ route('admin.setting.google-recaptcha') }}">
                    <img src="{{ asset('admin/images/heroicon/outline/cog.svg') }}" alt="icon">
                    <span>{{ __('Google Recaptcha') }}</span>
                </a>
            </li>
            <li>
                <a class="list-item {{ @$subColorSettingActiveClass }}" href="{{ route('admin.setting.color-settings') }}">
                    <img src="{{ asset('admin/images/heroicon/outline/cog.svg') }}" alt="icon">
                    <span>{{ __('Color Setting') }}</span>
                </a>
            </li>

        </ul>
    </div>
    @canany(['payment_gateway','paypal','stripe','razorpay','instamojo','mollie','paystack','sslcommerz','bank_payment','wallet_payment'])
        <div class="sidebar__item">
            <ul class="sidebar__mail__nav">
                <h2>{{ __('Payment Gateway') }}</h2>
                @can('paypal')
                    <li>
                        <a href="{{ route('admin.gateway.paypal') }}" class="list-item {{ @$subNavPaypalActiveClass }}">
                            <img src="{{ asset('admin/images/heroicon/outline/cog.svg') }}" alt="icon">
                            <span>{{ __('Paypal') }}</span>
                        </a>
                    </li>
                @endcan
                @can('stripe')
                    <li>
                        <a href="{{ route('admin.gateway.stripe') }}" class="list-item {{ @$subNavStripeActiveClass }}">
                            <img src="{{ asset('admin/images/heroicon/outline/cog.svg') }}" alt="icon">
                            <span>{{ __('Stripe') }}</span>
                        </a>
                    </li>
                @endcan
                @can('razorpay')
                    <li>
                        <a href="{{ route('admin.gateway.razorpay') }}" class="list-item {{ @$subNavRazorpayActiveClass }}">
                            <img src="{{ asset('admin/images/heroicon/outline/cog.svg') }}" alt="icon">
                            <span>{{ __('Razorpay') }}</span>
                        </a>
                    </li>
                @endcan
                @can('instamojo')
                    <li>
                        <a href="{{ route('admin.gateway.instamojo') }}" class="list-item {{ @$subNavInstamojoActiveClass }}">
                            <img src="{{ asset('admin/images/heroicon/outline/cog.svg') }}" alt="icon">
                            <span>{{ __('Instamojo') }}</span>
                        </a>
                    </li>
                @endcan
                @can('mollie')
                    <li>
                        <a href="{{ route('admin.gateway.mollie') }}" class="list-item {{ @$subNavMollieActiveClass }}">
                            <img src="{{ asset('admin/images/heroicon/outline/cog.svg') }}" alt="icon">
                            <span>{{ __('Mollie') }}</span>
                        </a>
                    </li>
                @endcan
                @can('paystack')
                    <li>
                        <a href="{{ route('admin.gateway.paystack') }}" class="list-item {{ @$subNavPaystackActiveClass }}">
                            <img src="{{ asset('admin/images/heroicon/outline/cog.svg') }}" alt="icon">
                            <span>{{ __('Paystack') }}</span>
                        </a>
                    </li>
                @endcan
                @can('sslcommerz')
                    <li>
                        <a href="{{ route('admin.gateway.sslcommerz') }}" class="list-item {{ @$subNavSSLCOMMERZActiveClass }}">
                            <img src="{{ asset('admin/images/heroicon/outline/cog.svg') }}" alt="icon">
                            <span>{{ __('SSLCOMMERZ') }}</span>
                        </a>
                    </li>
                @endcan
                @can('bank_payment')
                    <li>
                        <a href="{{ route('admin.gateway.bank') }}" class="list-item {{ @$subNavBankActiveClass }}">
                            <img src="{{ asset('admin/images/heroicon/outline/cog.svg') }}" alt="icon">
                            <span>{{ __('Bank Payment') }}</span>
                        </a>
                    </li>
                @endcan
                @can('wallet_payment')
                    <li>
                        <a href="{{ route('admin.gateway.wallet') }}" class="list-item {{ @$subNavWalletActiveClass }}">
                            <img src="{{ asset('admin/images/heroicon/outline/cog.svg') }}" alt="icon">
                            <span>{{ __('Wallet Payment') }}</span>
                        </a>
                    </li>
                @endcan
            </ul>
        </div>
    @endcanany
    <div class="sidebar__item">
        <ul class="sidebar__mail__nav">
            <h2>{{ __('Mail Configuration') }}</h2>

            <li>
                <a href="{{ route('admin.setting.mail-configuration') }}" class="list-item {{ @$subMailConfigSettingsActiveClass }}">
                    <img src="{{ asset('admin/images/heroicon/outline/cog.svg') }}" alt="icon">
                    <span>{{ __('Mail Configuration') }}</span>
                </a>
            </li>

        </ul>
    </div>
    <div class="sidebar__item">
        <ul class="sidebar__mail__nav">
            <h2>{{__('Location Setting')}}</h2>

            <li>
                <a href="{{ route('admin.setting.location.country.index') }}" class="list-item {{ @$subCountryActiveClass }}">
                    <img src="{{ asset('admin/images/heroicon/outline/cog.svg') }}" alt="icon">
                    <span>{{ __('Country') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.setting.location.state.index') }}" class="list-item {{ @$subStateActiveClass }}">
                    <img src="{{ asset('admin/images/heroicon/outline/cog.svg') }}" alt="icon">
                    <span>{{ __('State') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.setting.location.city.index') }}" class="list-item {{ @$subCityActiveClass }}">
                    <img src="{{ asset('admin/images/heroicon/outline/cog.svg') }}" alt="icon">
                    <span>{{ __('City') }}</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="sidebar__item">
        <ul class="sidebar__mail__nav">
            <h2>{{__('Policy Setting')}}</h2>
            @can('terms_conditions')
                <li>
                    <a href="{{ route('admin.terms-conditions') }}" class="list-item {{ @$subNavTermsConditionsActiveClass }}">
                        <img src="{{ asset('admin/images/heroicon/outline/cog.svg') }}" alt="icon">
                        <span>{{ __('Terms & Conditions') }}</span>
                    </a>
                </li>
            @endcan
            @can('privacy_policy')
                <li>
                    <a href="{{ route('admin.privacy-policy') }}" class="list-item {{ @$subNavPrivacyPolicyActiveClass }}">
                        <img src="{{ asset('admin/images/heroicon/outline/cog.svg') }}" alt="icon">
                        <span>{{ __('Privacy Policy') }}</span>
                    </a>
                </li>
            @endcan
            @can('cookie_policy')
                <li>
                    <a href="{{ route('admin.cookie-policy') }}" class="list-item {{ @$subNavCookiePolicyActiveClass }}">
                        <img src="{{ asset('admin/images/heroicon/outline/cog.svg') }}" alt="icon">
                        <span>{{ __('Cookie Policy') }}</span>
                    </a>
                </li>
            @endcan
        </ul>
    </div>
    <div class="sidebar__item">
        <ul class="sidebar__mail__nav">
            <h2>{{__('FAQ')}}</h2>
            <li>
                <a href="{{ route('admin.setting.faq.index') }}" class="list-item {{ @$subFaqActiveClass }}">
                    <img src="{{ asset('admin/images/heroicon/outline/cog.svg') }}" alt="icon">
                    <span>{{ __('FAQ') }}</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="sidebar__item">
        <ul class="sidebar__mail__nav">
            <h2>{{ __('Maintenance Mode') }}</h2>
            <li>
                <a href="{{ route('admin.setting.maintenance') }}" class="list-item {{ @$subMaintenanceModeActiveClass }}">
                    <img src="{{ asset('admin/images/heroicon/outline/cog.svg') }}" alt="icon">
                    <span>{{ __('Maintenance Mode') }}</span>
                </a>
            </li>

        </ul>
    </div>
</div>
