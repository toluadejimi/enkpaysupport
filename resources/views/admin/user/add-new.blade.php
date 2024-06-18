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
                                <h2>{{__('User')}}</h2>
                            </div>
                        </div>
                        <div class="breadcrumb__content__right">
                            <nav aria-label="breadcrumb">
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('Dashboard')}}</a></li>
                                    <li class="breadcrumb-item">{{ __("User") }}</li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ __($pageTitle) }}</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="customers__area bg-style mb-30">
                        <div class="item-title d-flex flex-wrap justify-content-between">
                            <h2>{{ __($pageTitle) }}</h2>
                        </div>
                        <div class="">
                            <form action="{{route('admin.user.store')}}" method="post" class="form-horizontal" enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input__group mb-25">
                                            <label for="name">{{__('Name')}} <span class="text-danger">*</span></label>
                                            <input type="text" name="name" id="name" value="{{old('name')}}" placeholder="{{__('Name')}}" class="form-control">
                                            @if ($errors->has('name'))
                                                <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input__group mb-25">
                                            <label for="contact_number">{{__('Mobile Number')}} <span class="text-danger">*</span></label>
                                            <input type="text" name="mobile" id="contact_number" value="{{old('mobile')}}" placeholder="{{__('Contact Number')}}" class="form-control">
                                            @if ($errors->has('mobile'))
                                                <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('mobile') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="input__group mb-25">
                                            <label for="email">{{__('Email')}} <span class="text-danger">*</span></label>
                                            <input type="text" name="email" id="email" value="{{old('email')}}" placeholder="{{__('Email')}}" class="form-control">
                                            @if ($errors->has('email'))
                                                <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('email') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input__group mb-25">
                                            <label for="password">{{__('Password')}} <span class="text-danger">*</span></label>
                                            <input type="password" name="password" id="password" value="" placeholder="{{__('Password')}}" class="form-control">
                                            @if ($errors->has('password'))
                                                <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('password') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="input__group mb-25">
                                            <label for="dob">{{__('Date of Birth')}} <span class="text-danger">*</span></label>
                                            <input type="date" name="dob" id="dob" value="{{old('dob')}}" placeholder="{{__('Date of Birth')}}" class="form-control">
                                            @if ($errors->has('dob'))
                                                <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('dob') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="input__group mb-25">
                                            <label for="gender">{{__('Gender')}} <span class="text-danger">*</span></label>
                                            <select name="gender" id="gender" class="form-control">
                                                <option value="{{old('gender')}}">{{ __('Select') }}</option>
                                                <option value="male">{{ __('Male') }}</option>
                                                <option value="female">{{ __('Female') }}</option>
                                                <option value="others">{{ __('Others') }}</option>

                                            </select>
                                            @if ($errors->has('gender'))
                                                <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('gender') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="input__group mb-25">
                                            <label for="address">{{__('Address')}} <span class="text-danger">*</span></label>
                                            <textarea name="address" id="address" class="form-control" placeholder="{{__('Address')}}">{{old("address")}}</textarea>
                                            @if ($errors->has('address'))
                                                <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('address') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input__group mb-25">
                                            <label for="phone_verification_status">{{__('Mobile No Verification')}} <span class="text-danger">*</span></label>
                                            <select name="phone_verification_status" id="phone_verification_status" class="form-control">
                                                <option value="0">{{ __('No') }}</option>
                                                <option value="1">{{ __('Yes') }}</option>

                                            </select>
                                            @if ($errors->has('mobile_no_verification'))
                                                <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('mobile_no_verification') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="input__group mb-25">
                                            <label for="email_verification_status">{{__('Email Verification')}} <span class="text-danger">*</span></label>
                                            <select name="email_verification_status" id="email_verification_status" class="form-control">
                                                <option value="0">{{ __('No') }}</option>
                                                <option value="1">{{ __('Yes') }}</option>

                                            </select>
                                            @if ($errors->has('email_verification_status'))
                                                <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('email_verification_status') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="input__group mb-25">
                                            <label for="status">{{__('Status')}} <span class="text-danger">*</span></label>
                                            <select name="status" id="status" class="form-control">
                                                <option value="">{{ __('Select') }}</option>
                                                <option value="1">{{ __('Active') }}</option>
                                                <option value="0">{{ __('Inactive') }}</option>

                                            </select>
                                            @if ($errors->has('status'))
                                                <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('status') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    @if(isAddonInstalled('DESKSAAS') > 0)
                                        @if(auth()->user()->role == USER_ROLE_ADMIN && auth()->user()->tenant_id != null)
                                            <div class="col-md-6">
                                                <div class="input__group mb-25">
                                                    <label for="user_role">{{__('User Role')}} <span class="text-danger">*</span></label>
                                                    <select name="user_role" id="user_role" class="form-control">
                                                        <option value="{{USER_ROLE_AGENT}}">{{ __('Agent') }}</option>
                                                        <option value="{{USER_ROLE_CUSTOMER}}">{{ __('Customer') }}</option>
                                                    </select>
                                                    @if ($errors->has('user_role'))
                                                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('user_role') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    @else
                                        <div class="col-md-6">
                                            <div class="input__group mb-25">
                                                <label for="user_role">{{__('User Role')}} <span class="text-danger">*</span></label>
                                                <select name="user_role" id="user_role" class="form-control">
                                                    <option value="{{USER_ROLE_AGENT}}">{{ __('Agent') }}</option>
                                                    <option value="{{USER_ROLE_CUSTOMER}}">{{ __('Customer') }}</option>
                                                </select>
                                                @if ($errors->has('user_role'))
                                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('user_role') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    @endif

                                    <div class="col-md-6">
                                        <label for="address">{{__('Profile Image')}} </label>
                                        <div class="upload-img-box mb-25 overflow-hidden">
                                            <img src="{{asset('no-image.jpg')}}" alt="img" class="img-fluid">
                                            <input type="file" name="profile_image" id="profile_image" accept="image/*" onchange="previewFile(this)">
                                            <div class="upload-img-box-icon">
                                                <i class="fa fa-camera"></i>
                                                <p class="m-0">{{__('Image')}}</p>
                                            </div>
                                        </div>
                                        <p>{{ __('Accepted Image Files') }}: {{__('JPEG, JPG, PNG')}} <br> {{ __('Recommend Size') }}: 300 x 300 (1MB)</p>
                                    </div>
                                </div>
                                @if ($errors->has('profile_image'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('user_role') }}</span>
                                @endif

                                <div class="justify-content-end row text-end">
                                    <div class="col-md-12">
                                        <a href="{{route('admin.user.list')}}" class="btn btn-grey btn-sm" >{{ __('Back') }}</a>
                                        <button class="btn btn-blue float-right" type="submit">{{ __('Update') }}</button>
                                    </div>
                                </div>


                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content area end -->



@endsection

@push('script')

    <script src="{{asset('admin/libs/datatable/datatables.min.js')}}"></script>
    <script src="{{asset('admin/js/custom/user.js')}}"></script>
    <script src="{{asset('admin/js/custom/image-preview.js')}}"></script>

@endpush
