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
                    <div class="email-inbox__area bg-style">
                        <div class="item-top mb-30"><h2>{{ @$pageTitle }}</h2></div>
                        <form action="{{route('admin.setting.home.why-us.update')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="custom-form-group mb-3 row">
                                <label for="why_us_title" class="col-lg-3 text-lg-right text-black"> {{ __('Why Us Title') }} </label>
                                <div class="col-lg-9">
                                    <input type="text" name="why_us_title" id="why_us_title" value="{{ getOption('why_us_title') }}" class="form-control"
                                           placeholder="{{ __('Why Us Title') }}" required>
                                    @if ($errors->has('why_us_title'))
                                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('why_us_title') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="custom-form-group mb-3 row">
                                <label for="why_us_subtitle" class="col-lg-3 text-lg-right text-black"> {{ __('Why Us Subtitle') }} </label>
                                <div class="col-lg-9">
                                    <textarea name="why_us_subtitle" class="form-control" rows="5" id="why_us_subtitle" placeholder="{{ __('Why Us Subtitle') }}"
                                              required>{{ getOption('why_us_subtitle') }}</textarea>
                                    @if ($errors->has('why_us_subtitle'))
                                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('why_us_subtitle') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="custom-form-group mb-3 row">
                                <label for="why_us_image" class="col-lg-3 text-lg-right text-black"> {{ __('Why Us Image') }} </label>
                                <div class="col-lg-9">
                                    <div class="upload-img-box">
                                        <img src="{{ getSettingImage('why_us_image') }}">
                                        <input type="file" name="why_us_image" id="image" accept="image/*" onchange="preview815639DimensionsFile(this)">
                                        <div class="upload-img-box-icon">
                                            <i class="fa fa-camera"></i>
                                        </div>
                                    </div>
                                    <p><span class="text-black">{{ __('Accepted Files') }}:</span> PNG <br> <span class="text-black">{{ __('Accepted Size') }}:</span> 815 x 639</p>
                                </div>
                            </div>
                            <hr>
                            <div id="add_repeater" class="mb-3">
                                <div data-repeater-list="why_us_points" class="">
                                    @if($points->count() > 0)
                                        @foreach($points as $point)
                                            <div data-repeater-item="" class="form-group row">
                                                <input type="hidden" name="id" value="{{ @$point['id'] }}"/>
                                                <div class="custom-form-group mb-3 col-md-3 col-lg-3 col-xl-3 col-xxl-2">
                                                    <label for="image_{{ @$point['id'] }}" class=" text-lg-right text-black"> {{ __('Image') }} </label>
                                                    <div class="upload-img-box">
                                                        <img src="{{$point->image}}">
                                                        <input type="file" name="image" id="image_{{ $point['id'] }}" accept="image/*" onchange="preview35DimensionsFile(this)">
                                                        <div class="upload-img-box-icon">
                                                            <i class="fa fa-camera"></i>
                                                        </div>
                                                    </div>
                                                    <p><span class="text-black">{{ __('Accepted Files') }}:</span> PNG <br> <span class="text-black">{{ __('Accepted Size') }}:</span> 35 x 35</p>
                                                </div>
                                                <div class="custom-form-group mb-3 col-md-4 col-lg-4 col-xl-4 col-xxl-4">
                                                    <label for="title_{{ $point['id'] }}" class="text-lg-right text-black"> {{ __('Title') }} </label>
                                                    <input type="text" name="title" id="title_{{ $point['id'] }}" value="{{ $point->title }}" class="form-control"
                                                           placeholder="{{ __('Title') }}" required>
                                                </div>
                                                <div class="custom-form-group mb-3 col-md-5 col-lg-5 col-xl-5 col-xxl-5">
                                                    <label for="subtitle_{{ $point['id'] }}" class="text-lg-right text-black"> {{ __('Subtitle') }} </label>
                                                    <textarea name="subtitle" id="subtitle_{{ $point['id'] }}" rows="7" class="form-control" placeholder="{{ __('Subtitle') }}"
                                                              required>{{ $point->subtitle }}</textarea>
                                                </div>

                                                <div class="col-lg-1 mb-3">
                                                    <label class="text-lg-right text-black opacity-0">{{ __('Remove') }}</label>
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
                                                    <input type="file" name="image" id="image" accept="image/*" onchange="preview35DimensionsFile(this)">
                                                    <div class="upload-img-box-icon">
                                                        <i class="fa fa-camera"></i>
                                                    </div>
                                                </div>
                                                <p><span class="text-black">{{ __('Accepted Files') }}:</span> PNG <br> <span class="text-black">{{ __('Accepted Size') }}:</span> 35 x 35</p>
                                            </div>
                                            <div class="custom-form-group mb-3 col-md-4 col-lg-4 col-xl-4 col-xxl-4">
                                                <label for="title" class="text-lg-right text-black"> {{ __('Title') }} </label>
                                                <input type="text" name="title" id="title" value="" class="form-control" placeholder="{{ __('Title') }}" required>
                                            </div>
                                            <div class="custom-form-group mb-3 col-md-5 col-lg-5 col-xl-5 col-xxl-5">
                                                <label for="subtitle" class="text-lg-right text-black"> {{ __('Subtitle') }} </label>
                                                <textarea name="subtitle" id="subtitle" rows="7" class="form-control" placeholder="{{ __('Subtitle') }}"></textarea>
                                            </div>

                                            <div class="col-lg-1 mb-3 ">
                                                <label class="text-lg-right text-black opacity-0">{{ __('Remove') }}</label>
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
