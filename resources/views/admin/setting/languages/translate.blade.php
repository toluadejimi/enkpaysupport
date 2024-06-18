@extends('admin.layouts.app')
@push('style')
    <link rel="stylesheet" type="text/css" href="{{asset('admin/libs/datatable/datatables.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('admin/css/custom/image-preview.css')}}">
@endpush
@section('content')
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
                                    <li class="breadcrumb-item active" aria-current="page">{{ __($pageTitle) }}</li>
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
                                <button type="button" class="btn btn-primary btn-sm text-white" data-bs-toggle="modal"
                                        data-bs-target="#importModal" title="Import Keywords">
                                    {{__('Import Keywords')}}
                                </button>
                                <button type="button" class="btn btn-success btn-sm addmore"><i class="fa fa-plus"></i>
                                    {{__('Add More')}}
                                </button>
                            </div>
                        </div>
                        <div class="customers__table">
                            <table
                                class="row-border table-style common-datatable responsive dataTable no-footer dtr-inline">
                                <thead>
                                <tr>
                                <tr>
                                    <th>{{ __('Key') }}</th>
                                    <th>{{ __('Value') }}</th>
                                    <th class="text-end">{{ __('Action') }}</th>
                                </tr>
                                </thead>
                                <tbody id="append">
                                @foreach ($translators as $key => $value)
                                    <tr>
                                        <td>
                                            <textarea type="text" class="key form-control" readonly
                                                      required>{!! $key !!}</textarea>
                                        </td>
                                        <td>
                                            <input type="hidden" value="0"
                                                   class="is_new">
                                            <textarea type="text" class="val form-control"
                                                      required>{!! $value !!}</textarea>
                                        </td>
                                        <td class="text-end">
                                            <button type="button"
                                                    class="updateLangItem btn btn-primary"
                                            >{{ __('Update') }}</button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Add Modal section start -->
    <div class="modal fade" id="importModal" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form class="ajax" action="{{ route('admin.setting.languages.import') }}" method="POST"
                      data-handler="languageHandler">
                    @csrf
                    <input type="hidden" name="current" value="{{ $language->iso_code }}">
                    <div class="modal-header align-items-center">
                        <h5 class="modal-title">{{ __('Import Language') }}</h5>
                        <button type="button" class="btn-close modal-close-btn-2" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-inner-form-box">
                            <div class="row">
                                <div class="mb-30">
                                    <span
                                        class="text-danger text-center">{{ __('Note: If you import keywords, your current keywords will be deleted and replaced by the imported keywords.') }}</span>
                                </div>
                                <div class="col-md-6 mb-25">
                                    <label for="status" class="label-text-title color-heading font-medium mb-2">
                                        {{ __('Language') }} </label>
                                    <select name="import" class="form-select flex-shrink-0 export shadow-none"
                                            id="inputGroupSelect02">
                                        <option value=""> {{ __('Select Option') }} </option>
                                        @foreach ($languages as $lang)
                                            <option value="{{ $lang->iso_code }}">{{ __($lang->language) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-start">
                        <button type="button" class="theme-btn-back m-0 me-3 btn btn-secondary py-2" data-bs-dismiss="modal" title="Back">{{ __('Back') }}</button>
                        <button type="submit" class="theme-btn m-0 btn btn-primary py-2" title="Submit">{{ __('Import') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <input type="hidden" id="updateLangItemRoute"
           value="{{ route('admin.setting.languages.update.translate', [$language->id]) }}">
@endsection

@push('script')
    <script src="{{asset('admin/libs/datatable/datatables.min.js')}}"></script>
    <script src="{{asset('admin/js/custom/languages.js')}}"></script>
    <script src="{{asset('admin/js/custom/image-preview.js')}}"></script>
@endpush
