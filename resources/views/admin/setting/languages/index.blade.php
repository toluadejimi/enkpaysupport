@extends('admin.layouts.app')
@push('style')
    <link rel="stylesheet" type="text/css" href="{{asset('admin/libs/datatable/datatables.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('admin/css/custom/image-preview.css')}}">
@endpush
@section('content')
    <!-- Page content area start -->
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb__content">
                        <div class="breadcrumb__content__left">
                            <div class="breadcrumb__title">
                                <h2>{{ __("Settings") }}</h2>
                            </div>
                        </div>
                        <div class="breadcrumb__content__right">
                            <nav aria-label="breadcrumb">
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a
                                            href="{{route('admin.dashboard')}}">{{__('Dashboard')}}</a></li>
                                    <li class="breadcrumb-item">{{ __("Settings") }}</li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ $pageTitle }}</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <input type="hidden" id="language-route" value="{{ route('admin.setting.languages.index') }}">
                <div class="col-lg-12">
                    <div class="customers__area bg-style mb-30">
                        <div class="item-title d-flex flex-wrap justify-content-between">
                            <h2>{{ $pageTitle }}</h2>
                            <div>
                                <button class="btn btn-success btn-sm" type="button" data-bs-toggle="modal"
                                        data-bs-target="#add-modal">
                                    <i class="fa fa-plus"></i> {{ __('Add Language') }}
                                </button>
                            </div>
                        </div>
                        <div class="customers__table">
                            <table
                                class="row-border table-style common-datatable responsive dataTable no-footer dtr-inline"
                                id="commonDataTable">
                                <thead>
                                <tr>
                                    <th>{{ __("Flag") }}</th>
                                    <th>{{ __("Language") }}</th>
                                    <th>{{ __("ISO code") }}</th>
                                    <th>{{ __("RTL") }}</th>
                                    <th>{{ __("Font") }}</th>
                                    <th class="action__buttons d-flex justify-content-end">{{ __("Action") }}</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content area end -->

    <!-- Add Modal section start -->
    <div class="modal fade" id="add-modal" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Add Language') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="ajax reset" action="{{ route('admin.setting.languages.store') }}" method="post"
                      data-handler="languageHandler" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="input__group mb-25">
                                    <label for="language">{{ __('Language') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="language" placeholder="{{ __("Type Language Name") }}"
                                           required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input__group mb-25">
                                    <label for="iso_code">{{ __('ISO Code') }} <span
                                            class="text-danger">*</span></label>
                                    <select name="iso_code" required>
                                        <option value="">--{{ __('Select ISO Code') }}--</option>
                                        @foreach(languageIsoCode() as $code => $isoCountryName)
                                            <option value="{{$code}}">{{ $isoCountryName.'('.$code.')' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="input__group mb-25">
                                    <label for="flag" class="text-lg-right text-black"> {{__('Flag')}} <span
                                            class="text-danger">*</span> </label>
                                    <div class="upload-img-box">
                                        <img src="{{ getDefaultImage() }}">
                                        <input type="file" name="flag" accept="image/*" onchange="previewFile(this)">
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="input__group mb-25">
                                    <label for="font">{{ __('Font File') }}</label>
                                    <input type="file" name="font" placeholder="{{ __("Font") }}"
                                           accept="file/ttf,file/otf,file/woff,file/woff2">
                                    @if ($errors->has('font'))
                                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('font') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input__group mb-25">
                                    <label for="rtl">{{ __('RTL Supported') }} <span
                                            class="text-danger">*</span></label>
                                    <select name="rtl" required>
                                        <option value="0">{{__("No")}}</option>
                                        <option value="1">{{__("Yes")}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-check">
                                    <input name="default" class="form-check-input" type="checkbox" value="1"
                                           id="flexCheckChecked">
                                    <label class="form-check-label p-1" for="flexCheckChecked">
                                        {{ __('Default Language') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-purple">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Add Modal section end -->

    <!-- Edit Modal section start -->
    <div class="modal fade" id="edit-modal" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

            </div>
        </div>
    </div>
    <!-- Edit Modal section end -->
@endsection
@push('script')
    <script src="{{asset('admin/libs/datatable/datatables.min.js')}}"></script>
    <script src="{{asset('admin/js/custom/languages.js')}}"></script>
    <script src="{{asset('admin/js/custom/image-preview.js')}}"></script>
@endpush
