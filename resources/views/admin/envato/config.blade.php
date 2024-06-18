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
                <div class="col-12">
                    <div class="email-inbox__area bg-style form-horizontal__item bg-style admin-general-settings-page">
                        <div class="item-top mb-30">
                            <h2>{{ $pageTitle }}</h2>
                        </div>
                        <input type="hidden" id="statusChangeRoute" value="{{ route('admin.envato.config-store') }}">
                        <input type="hidden" id="configureUrl" value="{{ route('admin.envato.config-modal') }}">
                        <input type="hidden" id="helpUrl" value="{{ route('admin.envato.config-help') }}">
                        <form class="ajax" action="{{route('admin.envato.config-store')}}" method="POST"
                              enctype="multipart/form-data" data-handler="settingCommonHandler">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="customers__table">
                                        <table class="row-border table-style responsive no-footer dtr-inline">
                                            <thead>
                                            <tr>
                                                <th>{{ __("Extension") }}</th>
                                                <th class="action__buttons d-flex  justify-content-end">{{ __("Action") }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td id="licence-enable">
                                                    <h6>{{ __('Enable purchase code to New Ticket') }}</h6>
                                                    <small
                                                        class="fst-italic fw-normal">({{ __('If you enable this, Customer can see the purchase code field when create ticket.')}}
                                                        )</small>
                                                </td>
                                                <td>
                                                    <div class="action__buttons d-flex justify-content-end">
                                                        <div class="form-switch">
                                                            <input class="form-check-input mt-0"
                                                                   onchange="changeEnvatoSettingStatus(this,'enable_purchase_code')"
                                                                   value="1"
                                                                   {{ isset($envatoConfigData->enable_purchase_code) && $envatoConfigData->enable_purchase_code == STATUS_ACTIVE ? 'checked' : '' }} name="enable_purchase_code"
                                                                   type="checkbox" role="switch"
                                                                   id="enable_purchase_code">
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr id="licence-details"
                                                class="{{ isset($envatoConfigData->enable_purchase_code) && $envatoConfigData->enable_purchase_code == STATUS_ACTIVE ? '' : 'd-none' }}">
                                                <td>
                                                    <h6>{{ __('Envato Licence Details') }}</h6>
                                                    <small
                                                        class="fst-italic fw-normal">({{ __('If you enable this Envato Expired switch, Agent & author can see his licence Details.')}}
                                                        )</small>
                                                </td>
                                                <td>
                                                    <div class="action__buttons d-flex justify-content-end">
                                                        <div class="form-switch">
                                                            <input class="form-check-input mt-0"
                                                                   onchange="changeEnvatoSettingStatus(this,'envato_expired_on')"
                                                                   value="1"
                                                                   {{ isset($envatoConfigData->envato_expired_on) && $envatoConfigData->envato_expired_on == STATUS_ACTIVE ? 'checked' : '' }} name="envato_expired_on"
                                                                   type="checkbox" role="switch" id="envato_expired_on">
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr id="licence-api-tocken">
                                                <td>
                                                    <h6>{{ __('Envato Personal Api Token') }}</h6>
                                                </td>
                                                <td>
                                                    <div class="action__buttons d-flex justify-content-end">
                                                        <button type="button" class="btn btn-outline-primary me-2 p-2"
                                                                onclick="configureModal('api_token_config')"
                                                                title="{{ __('Configure') }}">
                                                            {{ __('Configure') }}
                                                        </button>
                                                        <button type="button"
                                                                class="btn btn-action btn-outline-dark p-2"
                                                                onclick="helpModal('api_token_config')"
                                                                title="{{ __('Help') }}">
                                                            {{ __('Help') }}
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content area end -->
    <!-- Configuration section start -->
    <div class="modal fade main-modal" id="configureModal" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

            </div>
        </div>
    </div>
    <!-- Configuration section end -->
    <!-- Help section start -->
    <div class="modal fade main-modal" id="helpModal" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

            </div>
        </div>
    </div>
    <!-- Help section end -->

@endsection
@push('script')
    <script src="{{ asset('admin/js/custom/envato_configuration.js') }}"></script>
@endpush
