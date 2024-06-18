@extends('admin.layouts.app')

@section('content')
    <!-- Page content area start -->
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb__content">
                        <div class="breadcrumb__content__left">
                            <div class="breadcrumb__title">
                                <h2>{{ __('Application Settings') }}</h2>
                            </div>
                        </div>
                        <div class="breadcrumb__content__right">
                            <nav aria-label="breadcrumb">
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('Dashboard')}}</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ @$pageTitle }}</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-4">
                    @include('admin.setting.sidebar')
                </div>
                <div class="col-lg-9 col-md-8">
                    <div class="email-inbox__area bg-style admin-about-us-client">
                        <div class="item-top mb-30"><h2>{{ @$pageTitle }}</h2></div>
                        <form action="{{route('admin.setting.home.testimonial.update')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row custom-form-group mb-3">
                                <label for="testimonial_title" class="col-lg-3 text-lg-right text-black">{{ __('Title') }} </label>
                                <div class="col-lg-9">
                                    <input type="text" name="testimonial_title" id="testimonial_title" value="{{ getOption('testimonial_title') }}"
                                           class="form-control" placeholder="{{__('Type title')}}">
                                    @if ($errors->has('testimonial_title'))
                                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('testimonial_title') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="custom-form-group mb-3 row">
                                <label for="testimonial_subtitle" class="col-lg-3 text-lg-right text-black">{{ __('Subtitle') }} </label>
                                <div class="col-lg-9">
                                    <textarea name="testimonial_subtitle" class="form-control" rows="5" id="testimonial_subtitle"
                                              required>{{ getOption('testimonial_subtitle') }}</textarea>
                                    @if ($errors->has('testimonial_subtitle'))
                                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('testimonial_subtitle') }}</span>
                                    @endif
                                </div>
                            </div>
                            <hr>
                            <div id="add_repeater" class="mb-3">
                                <div data-repeater-list="testimonials">
                                    @if($testimonials->count() > 0)
                                        @foreach($testimonials as $testimonial)
                                            <div data-repeater-item="" class="form-group row">
                                                <input type="hidden" name="id" value="{{ @$testimonial['id'] }}"/>
                                                <div class="custom-form-group mb-3 col-md-3 col-lg-3 col-xl-3 col-xxl-2">
                                                    <label for="image_{{ @$testimonial['id'] }}" class=" text-lg-right text-black">{{ __('Image') }}</label>
                                                    <div class="upload-img-box">
                                                        <img src="{{$testimonial->image}}">
                                                        <input type="file" name="image" id="image_{{ @$testimonial['id'] }}" accept="image/*" onchange="preview125DimensionFile(this)">
                                                        <div class="upload-img-box-icon">
                                                            <i class="fa fa-camera"></i>
                                                        </div>
                                                    </div>
                                                    <p><span class="text-black">{{__('Accepted Files:')}}</span> {{__('PNG')}} <br> <span class="text-black">{{__('Accepted Size:')}}</span> {{__('125 x 125')}}</p>
                                                </div>
                                                <div class="custom-form-group mb-3 col-md-3 col-lg-3 col-xl-3 col-xxl-3">
                                                    <label for="name_{{ @$testimonial['id'] }}" class="text-lg-right text-black"> {{ __('Name') }} </label>
                                                    <div>
                                                        <input type="text" name="name" id="name_{{ @$testimonial['id'] }}" value="{{ $testimonial->name }}" class="form-control" placeholder="{{__('Type name')}}" required>
                                                    </div>
                                                </div>
                                                <div class="custom-form-group mb-3 col-md-3 col-lg-3 col-xl-3 col-xxl-3">
                                                    <label for="designation_{{ @$testimonial['id'] }}" class="text-lg-right text-black"> {{ __('Designation') }}</label>
                                                    <div>
                                                        <input type="text" name="designation" id="designation_{{ @$testimonial['id'] }}" value="{{ $testimonial->designation }}" class="form-control" placeholder="{{ __('Designation') }}" required>
                                                    </div>
                                                </div>
                                                <div class="custom-form-group mb-3 col-md-3 col-lg-3 col-xl-3 col-xxl-3">
                                                    <label for="quote_{{ @$testimonial['id'] }}" class="text-lg-right text-black"> {{ __('Quote') }}</label>
                                                    <div>
                                                        <textarea name="quote" class="form-control" id="quote_{{ @$testimonial['id'] }}" rows="7" placeholder="{{ __('Quote') }}"
                                                                  required>{{ $testimonial->quote }}</textarea>
                                                    </div>
                                                </div>

                                                <div class="col-lg-1 mb-3 ">
                                                    <label class="text-lg-right text-black opacity-0">{{__('Remove')}}</label>
                                                    <a href="javascript:;" data-repeater-delete=""
                                                       class="btn btn-icon-remove">
                                                       <img src="{{asset('admin/images/icons/trash-2.svg')}}" alt="trash" class="onlyForProductRules">
                                                    </a>
                                                </div>

                                            </div>
                                        @endforeach
                                    @else
                                        <div data-repeater-item="" class="form-group row">
                                            <div class="custom-form-group mb-3 col-md-3 col-lg-3 col-xl-3 col-xxl-2">
                                                <label for="image" class=" text-lg-right text-black"> {{ __('Image') }} </label>
                                                <div class="upload-img-box">
                                                    <img src="{{ getDefaultImage() }}">
                                                    <input type="file" name="image" id="image" accept="image/*"  onchange="preview125DimensionFile(this)" required>
                                                    <div class="upload-img-box-icon">
                                                        <i class="fa fa-camera"></i>
                                                    </div>
                                                </div>
                                                <p><span class="text-black">{{__('Accepted Files:')}}</span> {{__('PNG')}} <br> <span class="text-black">{{__('Accepted Size:')}}</span> {{__('125 x 125')}} </p>
                                            </div>
                                            <div class="custom-form-group mb-3 col-md-3 col-lg-3 col-xl-3 col-xxl-3">
                                                <label for="name" class="text-lg-right text-black"> {{ __('Name') }}</label>
                                                <div>
                                                    <input type="text" name="name" id="name" value="" class="form-control" placeholder="{{ __('Name') }}" required>
                                                </div>
                                            </div>
                                            <div class="custom-form-group mb-3 col-md-3 col-lg-3 col-xl-3 col-xxl-3">
                                                <label for="designation" class="text-lg-right text-black"> {{ __('Designation') }}</label>
                                                <div>
                                                    <input type="text" name="designation" id="designation" value="" class="form-control" placeholder="{{ __('Designation') }}" required>
                                                </div>
                                            </div>
                                            <div class="custom-form-group mb-3 col-md-3 col-lg-3 col-xl-3 col-xxl-3">
                                                <label for="quote" class="text-lg-right text-black"> {{ __('Quote') }}</label>
                                                <div>
                                                    <textarea name="quote" class="form-control" id="quote" rows="7" placeholder="{{ __('Quote') }}" required></textarea>
                                                </div>
                                            </div>
                                            {{ __('Remove') }}

                                            <div class="col-lg-1 mb-3 ">
                                                <label class="text-lg-right text-black opacity-0">{{__('Remove')}}</label>
                                                <a href="javascript:;" data-repeater-delete=""
                                                   class="btn btn-icon-remove">
                                                   <img src="{{asset('admin/images/icons/trash-2.svg')}}" alt="trash" class="onlyForProductRules">
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="col-lg-2">
                                    <a id="add" href="javascript:;" data-repeater-create=""
                                       class="btn btn-blue">
                                        <i class="fas fa-plus"></i> {{ __('Add') }}
                                    </a>
                                </div>

                            </div>

                            <div class="row justify-content-end">
                                <div class="col-md-2 text-end">
                                    <button class="btn btn-blue">{{ __('Update') }}</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content area end -->
@endsection


@push('style')
    <link rel="stylesheet" href="{{asset('admin/css/custom/image-preview.css')}}">
@endpush

@push('script')
    <script src="{{asset('admin/js/custom/image-preview.js')}}"></script>
    <script src="{{ asset('common/js/jquery.repeater.min.js') }}"></script>
    <script src="{{ asset('common/js/add-repeater.js') }}"></script>
@endpush
