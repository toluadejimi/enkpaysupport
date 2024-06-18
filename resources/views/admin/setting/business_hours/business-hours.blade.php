@extends('admin.layouts.app')
@push('style')
    <link rel="stylesheet" type="text/css" href="{{asset('admin/libs/datatable/datatables.min.css')}}"/>
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
                <input type="hidden" id="update-country-Route" value="{{ route('admin.setting.country.update') }}">
                <div class="col-lg-12">
                    <div class="customers__area bg-style mb-30">
                        <div class="item-title d-flex flex-wrap justify-content-between">
                            <h2>{{ __('Section Configuration') }}</h2>
                        </div>
                        <form class="ajax reset" action="{{route('admin.setting.business-hours-section-data-store')}}" method="post"
                              data-handler="commonResponse">
                            @csrf
                            <input type="hidden" value="{{auth()->id()}}" name="user_id">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input__group mb-25">
                                        <label for="user_role">{{__('Title')}} <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="schedule_title" value="{{isset($configData->schedule_title)?$configData->schedule_title:''}}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input__group mb-25">
                                        <label for="user_role">{{__('Short Description')}} <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="schedule_desc" value="{{isset($configData->schedule_desc)?$configData->schedule_desc:''}}" class="form-control">
                                    </div>
                                </div>
                                <div class="justify-content-end row text-end">
                                    <div class="col-md-12">
                                        <button class="btn btn-blue float-right"
                                                type="submit">{{ __('Update') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <input type="hidden" id="country-route" value="{{ route('admin.setting.country.list') }}">
                <input type="hidden" id="update-country-Route" value="{{ route('admin.setting.country.update') }}">
                <div class="col-lg-12">
                    <div class="customers__area bg-style mb-30">
                        <div class="item-title d-flex flex-wrap justify-content-between">
                            <h2>{{ __('Schedule') }}</h2>
                        </div>
                        <form class="ajax reset" action="{{route('admin.setting.business-hours-store')}}" method="post"
                              data-handler="commonResponse">
                            @csrf
                            <input type="hidden" value="{{auth()->id()}}" name="user_id">
                            <div class="row">
                                <div class="col-md-3">
                                    @if(count($businessHours)>0)
                                        @foreach($businessHours as $key=>$item)
                                            @if($key==0)
                                                <div class="input__group mb-25">
                                                    <label for="user_role">{{__('User Role')}} <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="day[]" value="{{$item->days}}"
                                                           class="form-control">
                                                </div>
                                            @else
                                                <div class="input__group mb-25">
                                                    <input type="text" name="day[]" value="{{$item->days}}"
                                                           class="form-control">
                                                </div>
                                            @endif
                                        @endforeach

                                    @else
                                        <div class="input__group mb-25">
                                            <label for="user_role">{{__('User Role')}} <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="day[]" value="" class="form-control">
                                        </div>
                                        <div class="input__group mb-25">
                                            <input type="text" name="day[]" value="" class="form-control">
                                        </div>
                                        <div class="input__group mb-25">
                                            <input type="text" name="day[]" value="" class="form-control">
                                        </div>
                                        <div class="input__group mb-25">
                                            <input type="text" name="day[]" value="" class="form-control">
                                        </div>
                                        <div class="input__group mb-25">
                                            <input type="text" name="day[]" value="" class="form-control">
                                        </div>
                                        <div class="input__group mb-25">
                                            <input type="text" name="day[]" value="" class="form-control">
                                        </div>
                                        <div class="input__group mb-25">
                                            <input type="text" name="day[]" value="" class="form-control">
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-3">
                                    @if(count($businessHours)>0)
                                        @foreach($businessHours as $key=>$item)
                                            @if($key==0)
                                                <div class="input__group mb-25">
                                                    <label for="status">{{__('Status(Open/Close)')}} <span
                                                            class="text-danger">*</span></label>
                                                    <select name="status[]" id="status" class="form-control">
                                                        <option value="">{{ __('Select') }}</option>
                                                        <option
                                                            value="Opened" {{$item->status == 'Opened'?'selected':''}}>
                                                            Opened
                                                        </option>
                                                        <option
                                                            value="Closed" {{$item->status == 'Closed'?'selected':''}}>
                                                            Closed
                                                        </option>
                                                    </select>
                                                </div>
                                            @else
                                                <div class="input__group mb-25">
                                                    <select name="status[]" class="form-control">
                                                        <option value="">{{ __('Select') }}</option>
                                                        <option
                                                            value="Opened" {{$item->status == 'Opened'?'selected':''}}>
                                                            Opened
                                                        </option>
                                                        <option
                                                            value="Closed" {{$item->status == 'Closed'?'selected':''}}>
                                                            Closed
                                                        </option>
                                                    </select>
                                                </div>
                                            @endif
                                        @endforeach
                                    @else
                                        <div class="input__group mb-25">
                                            <label for="status">{{__('Status(Open/Close)')}} <span
                                                    class="text-danger">*</span></label>
                                            <select name="status[]" id="status" class="form-control">
                                                <option value="">{{ __('Select') }}</option>
                                                <option value="Opened">Opened</option>
                                                <option value="Closed">Closed</option>
                                            </select>
                                        </div>
                                        <div class="input__group mb-25">
                                            <select name="status[]" class="form-control">
                                                <option value="">{{ __('Select') }}</option>
                                                <option value="Opened">Opened</option>
                                                <option value="Closed">Closed</option>
                                            </select>
                                        </div>
                                        <div class="input__group mb-25">
                                            <select name="status[]" class="form-control">
                                                <option value="">{{ __('Select') }}</option>
                                                <option value="Opened">Opened</option>
                                                <option value="Closed">Closed</option>
                                            </select>
                                        </div>

                                        <div class="input__group mb-25">
                                            <select name="status[]" class="form-control">
                                                <option value="">{{ __('Select') }}</option>
                                                <option value="Opened">Opened</option>
                                                <option value="Closed">Closed</option>
                                            </select>
                                        </div>
                                        <div class="input__group mb-25">
                                            <select name="status[]" class="form-control">
                                                <option value="">{{ __('Select') }}</option>
                                                <option value="Opened">Opened</option>
                                                <option value="Closed">Closed</option>
                                            </select>
                                        </div>
                                        <div class="input__group mb-25">
                                            <select name="status[]" class="form-control">
                                                <option value="">{{ __('Select') }}</option>
                                                <option value="Opened">Opened</option>
                                                <option value="Closed">Closed</option>
                                            </select>
                                        </div>
                                        <div class="input__group mb-25">
                                            <select name="status[]" class="form-control">
                                                <option value="">{{ __('Select') }}</option>
                                                <option value="Opened">Opened</option>
                                                <option value="Closed">Closed</option>
                                            </select>
                                        </div>
                                    @endif

                                </div>
                                <div class="col-md-3">
                                    @if(count($businessHours)>0)
                                        @foreach($businessHours as $key=>$item)
                                            @if($key==0)
                                                <div class="input__group mb-25">
                                                    <label for="start_time">{{__('Status Time')}} <span
                                                            class="text-danger">*</span></label>
                                                    <select name="start_time[]" id="start_time" class="form-control">
                                                        <option value="">{{ __('Select') }}</option>
                                                        @foreach($timeArray as $time)
                                                            <option
                                                                value="{{$time}}" {{$item->start_time == $time?'selected':''}}>{{$time}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            @else
                                                <div class="input__group mb-25">
                                                    <select name="start_time[]" class="form-control">
                                                        <option value="">{{ __('Select') }}</option>
                                                        @foreach($timeArray as $time)
                                                            <option
                                                                value="{{$time}}" {{$item->start_time == $time?'selected':''}}>{{$time}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            @endif
                                        @endforeach
                                    @else
                                        <div class="input__group mb-25">
                                            <label for="start_time">{{__('Status Time')}} <span
                                                    class="text-danger">*</span></label>
                                            <select name="start_time[]" id="start_time" class="form-control">
                                                <option value="">{{ __('Select') }}</option>
                                                @foreach($timeArray as $time)
                                                    <option value="{{$time}}">{{$time}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="input__group mb-25">
                                            <select name="start_time[]" class="form-control">
                                                <option value="">{{ __('Select') }}</option>
                                                @foreach($timeArray as $time)
                                                    <option value="{{$time}}">{{$time}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="input__group mb-25">
                                            <select name="start_time[]" class="form-control">
                                                <option value="">{{ __('Select') }}</option>
                                                @foreach($timeArray as $time)
                                                    <option value="{{$time}}">{{$time}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="input__group mb-25">
                                            <select name="start_time[]" class="form-control">
                                                <option value="">{{ __('Select') }}</option>
                                                @foreach($timeArray as $time)
                                                    <option value="{{$time}}">{{$time}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="input__group mb-25">
                                            <select name="start_time[]" class="form-control">
                                                <option value="">{{ __('Select') }}</option>
                                                @foreach($timeArray as $time)
                                                    <option value="{{$time}}">{{$time}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="input__group mb-25">
                                            <select name="start_time[]" class="form-control">
                                                <option value="">{{ __('Select') }}</option>
                                                @foreach($timeArray as $time)
                                                    <option value="{{$time}}">{{$time}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="input__group mb-25">
                                            <select name="start_time[]" class="form-control">
                                                <option value="">{{ __('Select') }}</option>
                                                @foreach($timeArray as $time)
                                                    <option value="{{$time}}">{{$time}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif


                                </div>
                                <div class="col-md-3">
                                    @if(count($businessHours)>0)
                                        @foreach($businessHours as $key=>$item)
                                            @if($key==0)
                                                <div class="input__group mb-25">
                                                    <label for="end_time">{{__('Status Time')}} <span
                                                            class="text-danger">*</span></label>
                                                    <select name="end_time[]" id="end_time" class="form-control">
                                                        <option value="">{{ __('Select') }}</option>
                                                        @foreach($timeArray as $time)
                                                            <option
                                                                value="{{$time}}" {{$item->end_time == $time?'selected':''}}>{{$time}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            @else
                                                <div class="input__group mb-25">
                                                    <select name="end_time[]" class="form-control">
                                                        <option value="">{{ __('Select') }}</option>
                                                        @foreach($timeArray as $time)
                                                            <option
                                                                value="{{$time}}" {{$item->end_time == $time?'selected':''}}>{{$time}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            @endif
                                        @endforeach
                                    @else
                                        <div class="input__group mb-25">
                                            <label for="end_time">{{__('Status Time')}} <span
                                                    class="text-danger">*</span></label>
                                            <select name="end_time[]" id="end_time" class="form-control">
                                                <option value="">{{ __('Select') }}</option>
                                                @foreach($timeArray as $time)
                                                    <option value="{{$time}}">{{$time}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="input__group mb-25">
                                            <select name="end_time[]" class="form-control">
                                                <option value="">{{ __('Select') }}</option>
                                                @foreach($timeArray as $time)
                                                    <option value="{{$time}}">{{$time}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="input__group mb-25">
                                            <select name="end_time[]" class="form-control">
                                                <option value="">{{ __('Select') }}</option>
                                                @foreach($timeArray as $time)
                                                    <option value="{{$time}}">{{$time}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="input__group mb-25">
                                            <select name="end_time[]" class="form-control">
                                                <option value="">{{ __('Select') }}</option>
                                                @foreach($timeArray as $time)
                                                    <option value="{{$time}}">{{$time}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="input__group mb-25">
                                            <select name="end_time[]" class="form-control">
                                                <option value="">{{ __('Select') }}</option>
                                                @foreach($timeArray as $time)
                                                    <option value="{{$time}}">{{$time}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="input__group mb-25">
                                            <select name="end_time[]" class="form-control">
                                                <option value="">{{ __('Select') }}</option>
                                                @foreach($timeArray as $time)
                                                    <option value="{{$time}}">{{$time}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="input__group mb-25">
                                            <select name="end_time[]" class="form-control">
                                                <option value="">{{ __('Select') }}</option>
                                                @foreach($timeArray as $time)
                                                    <option value="{{$time}}">{{$time}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif


                                </div>
                            </div>
                            <div class="justify-content-end row text-end">
                                <div class="col-md-12">
                                    <button class="btn btn-blue float-right" type="submit">{{ __('Update') }}</button>
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
    <script src="{{asset('admin/libs/datatable/datatables.min.js')}}"></script>
    <script src="{{asset('admin/js/custom/country.js')}}"></script>
@endpush
