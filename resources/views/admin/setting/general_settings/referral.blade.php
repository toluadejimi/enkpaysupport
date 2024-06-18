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
                                    <li class="breadcrumb-item"><a href="#">{{__('Referral ')}}</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{__(@$pageTitle)}}</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xxl-2 col-lg-3 col-md-4 mb-3 pr-0">
                    @include('admin.setting.partials.general-sidebar')
                </div>
                <div class="col-xxl-10 col-lg-9 col-md-8">
                    <div class="customers__area bg-style mb-30">
                        <div class="item-top mb-30">
                            <h2>{{__('Referral Setting')}}</h2>
                        </div>
                        <form class="ajax" action="{{ route('admin.setting.referral.update') }}" method="post"
                              class="form-horizontal" data-handler="commonResponse">
                            @csrf
                            <div class="row">
                                <div class="input__group mb-25 col-md-4">
                                    <label>{{__('Level')}} 1 (%)</label>
                                    <div class="input-group">
                                        <input type="number" min="0" max="100" step="any" name="referral_level_1"
                                               value="{{getOption('referral_level_1')}}" class="form-control">
                                        <span class="input-group-text">%</span>
                                        @if ($errors->has('referral_level_1'))
                                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('referral_level_1') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="input__group mb-25 col-md-4">
                                    <label>{{__('Level')}} 2 (%)</label>
                                    <div class="input-group">
                                        <input type="number" min="0" max="100" step="any" name="referral_level_2"
                                               value="{{getOption('referral_level_2')}}" class="form-control">
                                        <span class="input-group-text">%</span>
                                        @if ($errors->has('referral_level_2'))
                                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('referral_level_2') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="input__group mb-25 col-md-4">
                                    <label>{{__('Level')}} 3 (%)</label>
                                    <div class="input-group">
                                        <input type="number" min="0" max="100" step="any" name="referral_level_3"
                                               value="{{getOption('referral_level_3')}}" class="form-control">
                                        <span class="input-group-text">%</span>
                                        @if ($errors->has('referral_level_3'))
                                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('referral_level_3') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="input__group mb-25 col-md-4">
                                    <label>{{__('Level')}} 4 (%)</label>
                                    <div class="input-group">
                                        <input type="number" min="0" max="100" step="any" name="referral_level_4"
                                               value="{{getOption('referral_level_4')}}" class="form-control">
                                        <span class="input-group-text">%</span>
                                        @if ($errors->has('referral_level_4'))
                                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('referral_level_4') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="input__group mb-25 col-md-4">
                                    <label>{{__('Level')}} 5 (%)</label>
                                    <div class="input-group">
                                        <input type="number" min="0" max="100" step="any" name="referral_level_5"
                                               value="{{getOption('referral_level_5')}}" class="form-control">
                                        <span class="input-group-text">%</span>
                                        @if ($errors->has('referral_level_5'))
                                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('referral_level_5') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <hr>
                            
                            <div class="item-top mb-30">
                                <h2>{{__('Status')}}</h2>
                            </div>
                            <div class="row">
                                <div class="input__group mb-25 col-md-3">
                                    <label>{{__('Allow Referral Status')}} </label>
                                    <div class="input-group">
                                        <select name="referral_status" id="" class="form-control">
                                            <option
                                                value="1" {{ getOption('referral_status') == 1 ? 'selected':'' }}>{{ __('Yes') }}</option>
                                            <option
                                                value="0" {{ getOption('referral_status') != 1 ? 'selected':'' }}>{{ __('No') }}</option>
                                        </select>
                                        @if ($errors->has('referral_status'))
                                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('referral_status') }}</span>
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
@endpush
@push('script')
    <script src="{{asset('admin/js/custom/image-preview.js')}}"></script>
@endpush
