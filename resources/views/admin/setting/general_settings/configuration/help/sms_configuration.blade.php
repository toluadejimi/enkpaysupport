<div class="email-inbox__area bg-style">
    <div class="item-top mb-30 d-flex flex-wrap justify-content-between">
        <h2>{{ __('SMS Configuration') }}</h2>
        <a href="javascript:void(0);" id="sendTestSMSBtn" class="btn btn-success btn-sm"> <i class="fa fa-envelope"></i> {{ __('Send Test SMS') }} </a>
    </div>
    <form class="ajax" action="{{route('admin.setting.sms-configuration')}}" method="POST" enctype="multipart/form-data" data-handler="settingCommonHandler">
        @csrf
        <div class="row">
            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4 mb-3">
                <div class="form-group text-black">
                    <label>{{__('TWILIO ACCOUNT SID')}} <span class="text-danger">*</span></label>
                    <input type="text" name="TWILIO_ACCOUNT_SID" value="{{getOption('TWILIO_ACCOUNT_SID')}}" required class="form-control">
                </div>
            </div>

            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4 mb-3">
                <div class="form-group text-black">
                    <label>{{__('TWILIO AUTH TOKEN')}} <span class="text-danger">*</span></label>
                    <input type="text" name="TWILIO_AUTH_TOKEN" value="{{getOption('TWILIO_AUTH_TOKEN')}}" required class="form-control">
                </div>
            </div>

            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4 mb-3">
                <div class="form-group text-black">
                    <label>{{__('TWILIO PHONE NUMBER')}} <span class="text-danger">*</span></label>
                    <input type="text" name="TWILIO_PHONE_NUMBER" value="{{getOption('TWILIO_PHONE_NUMBER')}}" required class="form-control">
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-12">
                <div class="input__group general-settings-btn">
                    <button type="submit" class="btn btn-blue float-right">{{__('Save')}}</button>
                </div>
            </div>
        </div>

    </form>
</div>