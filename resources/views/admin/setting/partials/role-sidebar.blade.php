<div class="email__sidebar bg-style">
    <div class="sidebar__item">
        <ul class="sidebar__mail__nav">

            <li>
                <a class="list-item {{ @$subRoleActiveClass }}" href="{{ route('admin.setting.role.settings') }}">
                    <img src="{{ asset('admin/images/heroicon/outline/cog.svg') }}" alt="icon">
                    <span>{{ __('Role Settings') }}</span>
                </a>
            </li>
        </ul>
    </div>
</div>
