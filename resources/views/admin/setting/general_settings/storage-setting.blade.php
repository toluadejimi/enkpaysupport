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
                                <h2>{{ $pageTitle }}</h2>
                            </div>
                        </div>
                        <div class="breadcrumb__content__right">
                            <nav aria-label="breadcrumb">
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a
                                            href="{{route('admin.dashboard')}}">{{__('Dashboard')}}</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ $pageTitle }}</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xxl-2 col-lg-3 col-md-4 pr-0">
                    @include('admin.setting.partials.general-sidebar')
                </div>
                <div class="col-xxl-10 col-lg-9 col-md-8">
                    <div class="email-inbox__area bg-style">
                        <div class="item-top mb-30"><h2>{{ $pageTitle }}</h2></div>
                        <div class="bg-dark-primary-soft-varient p-4 border-1">
                            <h2>{{ __('Instructions') }}: </h2>
                            <p>{{ __('You need to click on') }}
                                <strong>{{ __(' "Storage Link"') }}</strong> {{ __(' button, after change ') }}
                                <strong>{{ __('"Storage Driver"') }}</strong></p>
                            <div class="text-black">
                                <a href="{{route('admin.setting.storage.link')}}" class="btn btn-success">{{__(' Storage
                                    Link')}}</a>
                            </div>
                        </div>
                        <br>
                        <form class="ajax" action="{{route('admin.setting.storage.update')}}" method="POST"
                              enctype="multipart/form-data" data-handler="settingCommonHandler">
                            @csrf
                            <div class="form-group text-black row mb-3">
                                <label class="col-lg-3">{{ __('Storage Driver') }} <span
                                        class="text-danger">*</span></label>
                                <div class="col-lg-9">
                                    <select name="STORAGE_DRIVER" id="storage_driver" class="form-control" required>
                                        <option
                                            value="{{ STORAGE_DRIVER_PUBLIC }}" {{  env('STORAGE_DRIVER') == STORAGE_DRIVER_PUBLIC ?  'selected':'' }}>{{__('Public')}}</option>
                                        <option
                                            value="{{ STORAGE_DRIVER_AWS }}" {{  env('STORAGE_DRIVER') == STORAGE_DRIVER_AWS ?  'selected':'' }}>{{__('AWS')}}</option>
                                        <option
                                            value="{{ STORAGE_DRIVER_WASABI }}" {{ env('STORAGE_DRIVER') == STORAGE_DRIVER_WASABI ?  'selected':'' }}>{{__('Wasabi')}}</option>
                                        <option
                                            value="{{ STORAGE_DRIVER_VULTR }}" {{  env('STORAGE_DRIVER') == STORAGE_DRIVER_VULTR ?  'selected':'' }}>{{__('Vultr')}}</option>
{{--                                        <option value="{{ STORAGE_DRIVER_DO }}" {{  env('STORAGE_DRIVER') == STORAGE_DRIVER_DO ?  'selected':'' }}>{{__('Digital Ocean (DO)')}}</option>--}}
                                    </select>
                                </div>
                            </div>
                            <div class="d-none storage-driver" id="aws">
                                <div class="row input__group mb-25">
                                    <label class="col-lg-3">{{ __('AWS Access Key ID') }} <span
                                            class="text-danger">*</span></label>
                                    <div class="col-lg-9">
                                        <input type="text" name="AWS_ACCESS_KEY_ID"
                                               value="{{ env('AWS_ACCESS_KEY_ID') }}" class="form-control">
                                    </div>
                                </div>
                                <div class="row input__group mb-25">
                                    <label class="col-lg-3">{{ __('AWS Secret Access Key') }} <span class="text-danger">*</span></label>
                                    <div class="col-lg-9">
                                        <input type="text" name="AWS_SECRET_ACCESS_KEY"
                                               value="{{ env('AWS_SECRET_ACCESS_KEY') }}" class="form-control">
                                    </div>
                                </div>
                                <div class="row input__group mb-25">
                                    <label class="col-lg-3">{{ __('AWS Default Region') }} <span
                                            class="text-danger">*</span></label>
                                    <div class="col-lg-9">
                                        <input type="text" name="AWS_DEFAULT_REGION"
                                               value="{{ env('AWS_DEFAULT_REGION') }}" class="form-control">
                                    </div>
                                </div>
                                <div class="row input__group mb-25">
                                    <label class="col-lg-3">{{ __('AWS Bucket') }} <span
                                            class="text-danger">*</span></label>
                                    <div class="col-lg-9">
                                        <input type="text" name="AWS_BUCKET" value="{{ env('AWS_BUCKET') }}"
                                               class="form-control">
                                    </div>
                                </div>
                                <div class="row input__group mb-25">
                                    <label class="col-lg-3">{{ __('AWS URL') }} <span
                                            class="text-danger">*</span></label>
                                    <div class="col-lg-9">
                                        <input type="text" name="AWS_URL" value="{{ env('AWS_URL') }}"
                                               class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="d-none storage-driver" id="wasabi">
                                <div class="row input__group mb-25">
                                    <label class="col-lg-3">{{ __('WAS Access Key ID') }} <span
                                            class="text-danger">*</span></label>
                                    <div class="col-lg-9">
                                        <input type="text" name="WASABI_ACCESS_KEY_ID"
                                               value="{{ env('WASABI_ACCESS_KEY_ID') }}" class="form-control">
                                    </div>
                                </div>
                                <div class="row input__group mb-25">
                                    <label class="col-lg-3">{{ __('WAS Secret Access Key') }} <span class="text-danger">*</span></label>
                                    <div class="col-lg-9">
                                        <input type="text" name="WASABI_SECRET_ACCESS_KEY"
                                               value="{{ env('WASABI_SECRET_ACCESS_KEY') }}" class="form-control">
                                    </div>
                                </div>
                                <div class="row input__group mb-25">
                                    <label class="col-lg-3">{{ __('WAS Default Region') }} <span
                                            class="text-danger">*</span></label>
                                    <div class="col-lg-9">
                                        <input type="text" name="WASABI_DEFAULT_REGION"
                                               value="{{ env('WASABI_DEFAULT_REGION') }}" class="form-control">
                                    </div>
                                </div>
                                <div class="row input__group mb-25">
                                    <label class="col-lg-3">{{ __('WAS Bucket') }} <span
                                            class="text-danger">*</span></label>
                                    <div class="col-lg-9">
                                        <input type="text" name="WASABI_BUCKET" value="{{ env('WASABI_BUCKET') }}"
                                               class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="d-none storage-driver" id="vultr">
                                <div class="row input__group mb-25">
                                    <label class="col-lg-3">{{ __('VULTR Access Key') }} <span
                                            class="text-danger">*</span></label>
                                    <div class="col-lg-9">
                                        <input type="text" name="VULTR_ACCESS_KEY_ID"
                                               value="{{ env('VULTR_ACCESS_KEY') }}" class="form-control">
                                    </div>
                                </div>
                                <div class="row input__group mb-25">
                                    <label class="col-lg-3">{{ __('VULTR Secret Key') }} <span
                                            class="text-danger">*</span></label>
                                    <div class="col-lg-9">
                                        <input type="text" name="VULTR_SECRET_ACCESS_KEY"
                                               value="{{ env('VULTR_SECRET_KEY') }}" class="form-control">
                                    </div>
                                </div>
                                <div class="row input__group mb-25">
                                    <label class="col-lg-3">{{ __('VULTR Region') }} <span class="text-danger">*</span></label>
                                    <div class="col-lg-9">
                                        <input type="text" name="VULTR_DEFAULT_REGION" value="{{ env('VULTR_REGION') }}"
                                               class="form-control">
                                    </div>
                                </div>
                                <div class="row input__group mb-25">
                                    <label class="col-lg-3">{{ __('VULTR Bucket') }} <span class="text-danger">*</span></label>
                                    <div class="col-lg-9">
                                        <input type="text" name="VULTR_BUCKET" value="{{ env('VULTR_BUCKET') }}"
                                               class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="d-none storage-driver" id="do">
                                <div class="row input__group mb-25">
                                    <label class="col-lg-3">{{ __('DO Access Key ID') }} <span
                                            class="text-danger">*</span></label>
                                    <div class="col-lg-9">
                                        <input type="text" name="DO_ACCESS_KEY_ID" value="{{ env('DO_ACCESS_KEY_ID') }}"
                                               class="form-control">
                                    </div>
                                </div>
                                <div class="row input__group mb-25">
                                    <label class="col-lg-3">{{ __('DO Secret Access Key') }} <span
                                            class="text-danger">*</span></label>
                                    <div class="col-lg-9">
                                        <input type="text" name="DO_SECRET_ACCESS_KEY"
                                               value="{{ env('DO_SECRET_ACCESS_KEY') }}" class="form-control">
                                    </div>
                                </div>
                                <div class="row input__group mb-25">
                                    <label class="col-lg-3">{{ __('DO Default Region') }} <span
                                            class="text-danger">*</span></label>
                                    <div class="col-lg-9">
                                        <input type="text" name="DO_DEFAULT_REGION"
                                               value="{{ env('DO_DEFAULT_REGION') }}" class="form-control">
                                    </div>
                                </div>
                                <div class="row input__group mb-25">
                                    <label class="col-lg-3">{{ __('DO Bucket') }} <span
                                            class="text-danger">*</span></label>
                                    <div class="col-lg-9">
                                        <input type="text" name="DO_BUCKET" value="{{ env('DO_BUCKET') }}"
                                               class="form-control">
                                    </div>
                                </div>
                                <div class="row input__group mb-25">
                                    <label class="col-lg-3">{{ __('DO Folder') }} <span
                                            class="text-danger">*</span></label>
                                    <div class="col-lg-9">
                                        <input type="text" name="DO_FOLDER" value="{{ env('DO_FOLDER') }}"
                                               class="form-control">
                                    </div>
                                </div>
                                <div class="row input__group mb-25">
                                    <label class="col-lg-3">{{ __('DO CDN ID') }} <span
                                            class="text-danger">*</span></label>
                                    <div class="col-lg-9">
                                        <input type="text" name="DO_CDN_ID" value="{{ env('DO_CDN_ID') }}"
                                               class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="justify-content-end row text-end">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-blue float-right">{{ __('Update') }}</button>
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
@push('script')
    <script src="{{ asset('admin/js/custom/storage-settings.js') }}"></script>
        <script>
            $(function () {
                var value = $('#storage_driver').val();
                storage(value)
            })

            $('#storage_driver').on('change', function () {
                var value = this.value
                storage(value)
            })

            function storage(STORAGE_DRIVER) {
                if (STORAGE_DRIVER == 'public') {
                    $('#aws').addClass('d-none');
                    $('#wasabi').addClass('d-none');
                    $('#vultr').addClass('d-none');
                    $('#do').addClass('d-none');
                } else if (STORAGE_DRIVER == 's3') {
                    $('#aws').removeClass('d-none');
                    $('#wasabi').addClass('d-none');
                    $('#vultr').addClass('d-none');
                    $('#do').addClass('d-none');
                } else if (STORAGE_DRIVER == 'wasabi') {
                    $('#aws').addClass('d-none');
                    $('#wasabi').removeClass('d-none');
                    $('#vultr').addClass('d-none');
                    $('#do').addClass('d-none');
                } else if (STORAGE_DRIVER == 'vultr') {
                    $('#aws').addClass('d-none');
                    $('#wasabi').addClass('d-none');
                    $('#vultr').removeClass('d-none');
                    $('#do').addClass('d-none');
                }
            }
        </script>
@endpush


