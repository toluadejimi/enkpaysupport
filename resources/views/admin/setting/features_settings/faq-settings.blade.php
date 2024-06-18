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
                                <h2>{{__(@$pageTitle)}}</h2>
                            </div>
                        </div>
                        <div class="breadcrumb__content__right">
                            <nav aria-label="breadcrumb">
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a
                                            href="{{route('admin.dashboard')}}">{{__('Dashboard')}}</a></li>
                                    <li class="breadcrumb-item"><a href="#">{{__('Features ')}}</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{__(@$pageTitle)}}</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row ">
                <div class="col-xxl-2 col-lg-3 col-md-4 mb-3 pr-0">
                    @include('admin.setting.partials.features-sidebar')
                </div>
                <div class="col-xxl-10 col-lg-9 col-md-8">
                    <div class="customers__area bg-style mb-30">
                        <div class="item-top mb-30">
                            <h2>{{__(@$pageTitle)}}</h2>
                        </div>
                        <form class="ajax" action="{{ route('admin.setting.cookie.settings.update') }}" method="post"
                              class="form-horizontal" data-handler="commonResponse">
                            @csrf
                            <div class="row mb-3">

                                <div class="col-xxl-6 col-lg-6 mb-6">
                                    <label>{{__('Enable FAQ at Coin Deposit')}} </label>
                                    <div class="input-group">
                                        <select name="coin_deposit_faq_status" id="" class="form-control">
                                            <option
                                                value="1" {{ getOption('coin_deposit_faq_status') == 1 ? 'selected':'' }}>{{ __('Yes') }}</option>
                                            <option
                                                value="0" {{ getOption('coin_deposit_faq_status') != 1 ? 'selected':'' }}>{{ __('No') }}</option>
                                        </select>
                                        @if ($errors->has('coin_deposit_faq_status'))
                                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('coin_deposit_faq_status') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-xxl-6 col-lg-6 mb-6">
                                    <label>{{__('Enable FAQ at Withdrawal')}} </label>
                                    <div class="input-group">
                                        <select name="coin_withdrawal_faq_status" id="" class="form-control">
                                            <option
                                                value="1" {{ getOption('coin_withdrawal_faq_status') == 1 ? 'selected':'' }}>{{ __('Yes') }}</option>
                                            <option
                                                value="0" {{ getOption('coin_withdrawal_faq_status') != 1 ? 'selected':'' }}>{{ __('No') }}</option>
                                        </select>
                                        @if ($errors->has('coin_withdrawal_faq_status'))
                                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('coin_withdrawal_faq_status') }}</span>
                                        @endif
                                    </div>
                                </div>

                            </div>

                                <div class="row mb-3">
                                    <div class="col-md-12 text-end">
                                        <button class="btn btn-blue" type="submit">{{ __('Update') }}</button>
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
@endpush
