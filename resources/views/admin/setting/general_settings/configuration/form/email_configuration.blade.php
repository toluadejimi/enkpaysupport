<div class="email-inbox__area bg-style">
    <div class="item-top mb-30 d-flex flex-wrap justify-content-between">
        <h2>{{ __('Mail Configuration') }}</h2>
        <a href="javascript:void(0);" id="sendTestMailBtn"
           class="btn btn-success btn-sm"> <i class="fa fa-envelope"></i> {{ __('Send Test Mail') }}
        </a>
    </div>
    <form class="ajax" action="{{route('admin.setting.settings_env.update')}}" method="POST"
          enctype="multipart/form-data" data-handler="commonResponseForModal">
        @csrf
        <div class="row">
            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4 mb-3">
                <div class="form-group text-black">
                    <label>{{__('MAIL MAILER')}} <span class="text-danger">*</span></label>
                    <input type="text" name="MAIL_MAILER" value="{{env('MAIL_MAILER')}}" required
                           class="form-control">
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4 mb-3">
                <div class="form-group text-black">
                    <label>{{__('MAIL HOST')}} <span class="text-danger">*</span></label>
                    <input type="text" name="MAIL_HOST" value="{{env('MAIL_HOST')}}" required
                           class="form-control">
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4 mb-3">
                <div class="form-group text-black">
                    <label>{{__('MAIL PORT')}} <span class="text-danger">*</span></label>
                    <input type="text" name="MAIL_PORT" value="{{env('MAIL_PORT')}}" required
                           class="form-control">
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4 mb-3">
                <div class="form-group text-black">
                    <label>{{__('MAIL USERNAME')}} <span class="text-danger">*</span></label>
                    <input type="text" name="MAIL_USERNAME" value="{{env('MAIL_USERNAME')}}"
                           required class="form-control">
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4 mb-3">
                <div class="form-group text-black">
                    <label>{{__('MAIL PASSWORD')}} <span class="text-danger">*</span></label>
                    <input type="password" name="MAIL_PASSWORD" value="{{env('MAIL_PASSWORD')}}"
                           required class="form-control">
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4 mb-3">
                <div class="form-group text-black">
                    <label>{{__('MAIL ENCRYPTION')}} <span class="text-danger">*</span></label>
                    <select name="MAIL_ENCRYPTION" required class="form-control">
                        <option value="tls" {{env('MAIL_ENCRYPTION') == 'tls' ? 'selected' : '' }} >
                            {{__('tls')}}
                        </option>
                        <option value="ssl" {{env('MAIL_ENCRYPTION') == 'ssl' ? 'selected' : '' }} >
                            {{__('ssl')}}
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4 mb-3">
                <div class="form-group text-black">
                    <label>{{__('MAIL FROM ADDRESS')}} <span class="text-danger">*</span></label>
                    <input type="text" name="MAIL_FROM_ADDRESS" value="{{env('MAIL_FROM_ADDRESS')}}"
                           required class="form-control">
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4 mb-3">
                <div class="form-group text-black">
                    <label>{{__('MAIL FROM NAME')}} <span class="text-danger">*</span></label>
                    <input type="text" name="MAIL_FROM_NAME" value="{{env('MAIL_FROM_NAME')}}"
                           required class="form-control">
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