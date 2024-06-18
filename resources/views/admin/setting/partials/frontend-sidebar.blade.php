<div class="email__sidebar bg-style">
    <div class="sidebar__item">
        <ul class="sidebar__mail__nav">
            <li>
                <a href="{{ route('admin.setting.frontend.index') }}"
                   class="list-item {{ @$subFrontendBasicSectionListActiveClass }}">
                    <img src="{{ asset('admin/images/heroicon/outline/cog.svg') }}" alt="icon">
                    <span>{{ __('Basic CMS Setting') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.setting.frontend.section') }}"
                   class="list-item {{ @$subFrontendSectionListActiveClass }}">
                    <img src="{{ asset('admin/images/heroicon/outline/cog.svg') }}" alt="icon">
                    <span>{{ __('Section Settings') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.setting.frontend.feature.index') }}"
                   class="list-item {{ @$subFeatureListActiveClass }}">
                    <img src="{{ asset('admin/images/heroicon/outline/cog.svg') }}" alt="icon">
                    <span>{{ __('Features') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.setting.frontend.faq-category.index') }}"
                   class="list-item {{ @$subFeqCategoryListActiveClass }}">
                    <img src="{{ asset('admin/images/heroicon/outline/cog.svg') }}" alt="icon">
                    <span>{{ __('Faq Category') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.setting.frontend.faq.index') }}"
                   class="list-item {{ @$subFeqListActiveClass }}">
                    <img src="{{ asset('admin/images/heroicon/outline/cog.svg') }}" alt="icon">
                    <span>{{ __('Faq') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.setting.frontend.testimonial.index') }}"
                   class="list-item {{ @$subTestimonialListActiveClass }}">
                    <img src="{{ asset('admin/images/heroicon/outline/cog.svg') }}" alt="icon">
                    <span>{{ __('Testimonial') }}</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.setting.frontend.pages.index') }}"
                   class="list-item {{ @$subPageListActiveClass }}">
                    <img src="{{ asset('admin/images/heroicon/outline/cog.svg') }}" alt="icon">
                    <span>{{ __('Pages') }}</span>
                </a>
            </li>

            @if(getOption('ZAIDESKTENANCY_build_version') !=null && getOption('ZAIDESKTENANCY_build_version') > 0)
                @if(auth()->check() && auth()->user()->role === USER_ROLE_ADMIN)
                    <li>
                        <a href="{{ route('admin.setting.frontend.knowledge-category.index') }}"
                           class="list-item {{ @$subKnowledgeCategoryListActiveClass }}">
                            <img src="{{ asset('admin/images/heroicon/outline/cog.svg') }}" alt="icon">
                            <span>{{ __('Knowledge Category') }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.setting.frontend.knowledge.index') }}"
                           class="list-item {{ @$subKnowledgeListActiveClass }}">
                            <img src="{{ asset('admin/images/heroicon/outline/cog.svg') }}" alt="icon">
                            <span>{{ __('Knowledge') }}</span>
                        </a>
                    </li>
                @endif
            @else
                <li>
                    <a href="{{ route('admin.setting.frontend.knowledge-category.index') }}"
                       class="list-item {{ @$subKnowledgeCategoryListActiveClass }}">
                        <img src="{{ asset('admin/images/heroicon/outline/cog.svg') }}" alt="icon">
                        <span>{{ __('Knowledge Category') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.setting.frontend.knowledge.index') }}"
                       class="list-item {{ @$subKnowledgeListActiveClass }}">
                        <img src="{{ asset('admin/images/heroicon/outline/cog.svg') }}" alt="icon">
                        <span>{{ __('Knowledge') }}</span>
                    </a>
                </li>
            @endif


        </ul>
    </div>
</div>
