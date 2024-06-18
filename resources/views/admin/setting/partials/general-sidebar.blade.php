<div class="email__sidebar bg-style">
    <div class="sidebar__item">
        <ul class="sidebar__mail__nav">

            <li>
                <a href="{{ route('admin.setting.application-settings') }}"
                   class="list-item {{ @$subApplicationSettingActiveClass }}">
                    <img src="{{ asset('admin/images/heroicon/outline/cog.svg') }}" alt="icon">
                    <span>{{__('Application Setting')}}</span>
                </a>
            </li>
            <li>
                <a class="list-item {{ @$subColorSettingActiveClass }}"
                   href="{{ route('admin.setting.color-settings') }}">
                    <img src="{{ asset('admin/images/heroicon/outline/cog.svg') }}" alt="icon">
                    <span>{{ __('Theme Setting') }}</span>
                </a>
            </li>
            @if(auth()->user()->role == USER_ROLE_SUPER_ADMIN)
            <li>
                <a class="list-item {{ @$subStorageSettingActiveClass }}"
                   href="{{ route('admin.setting.storage.index') }}">
                    <img src="{{ asset('admin/images/heroicon/outline/cog.svg') }}" alt="icon">
                    <span>{{ __('Storage Setting') }}</span>
                </a>
            </li>
            <li>
                <a class="list-item {{ @$subMaintenanceModeActiveClass }}"
                   href="{{ route('admin.setting.maintenance') }}">
                    <img src="{{ asset('admin/images/heroicon/outline/cog.svg') }}" alt="icon">
                    <span>{{ __('Maintenance Mode') }}</span>
                </a>
            </li>

            <li class="d-none">
                <a class="list-item {{ @$subCustomCssActiveClass    }}"
                   href="{{ route('admin.setting.custom-css') }}">
                    <img src="{{ asset('admin/images/heroicon/outline/cog.svg') }}" alt="icon">
                    <span>{{ __('Custom CSS') }}</span>
                </a>
            </li>
            <div class="sidebar__item">
                <ul class="sidebar__mail__nav">
                    <h2>{{ __('Others Settings') }}</h2>
                    <li>
                        <a href="{{ route('admin.setting.cache-settings') }}" class="list-item {{ @$cacheActiveClass }}">
                            <img src="{{ asset('admin/images/heroicon/outline/cog.svg') }}" alt="icon">
                            <span>{{ __('Cache Settings') }}</span>
                        </a>
                    </li>

                    <li class="d-none">
                        <a href="{{ route('admin.setting.db-settings') }}" class="list-item {{ @$subDatabaseBackupActiveClass }}">
                            <img src="{{ asset('admin/images/heroicon/outline/cog.svg') }}" alt="icon">
                            <span>{{ __('Backup') }}</span>
                        </a>
                    </li>
                </ul>
            </div>
            @endif
        </ul>
    </div>
</div>
