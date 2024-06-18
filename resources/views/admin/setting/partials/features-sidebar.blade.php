 <div class="email__sidebar bg-style">
    <div class="sidebar__item">
        <ul class="sidebar__mail__nav">

            <li>
                <a class="list-item {{ @$subFeatureActiveClass }}" href="{{ route('admin.setting.cookie-settings') }}">
                    <img src="{{ asset('admin/images/heroicon/outline/cog.svg') }}" alt="icon">
                    <span>{{ __('Cookie Settings') }}</span>
                </a>
            </li>

            <li>
                <a class="list-item {{ @$subFaqActiveClass }}" href="{{ route('admin.setting.faq.settings') }}">
                    <img src="{{ asset('admin/images/heroicon/outline/cog.svg') }}" alt="icon">
                    <span>{{ __('FAQ Settings') }}</span>
                </a>
            </li>

        </ul>
    </div>
</div>
