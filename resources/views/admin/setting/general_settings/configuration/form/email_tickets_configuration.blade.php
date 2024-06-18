<div class="email-inbox__area bg-style">
    <div class="item-top mb-30 d-flex flex-wrap justify-content-between">
        <h2>{{ __('Email Tickets Configuration') }}</h2>
    </div>
    <form class="ajax" action="{{route('admin.setting.settings_env.update')}}" method="POST"
          enctype="multipart/form-data" data-handler="commonResponseForModal">
        @csrf
        <div class="row">
            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4 mb-3">
                <div class="form-group text-black">
                    <label>{{__('MAIL MAILER')}} <span class="text-danger">*</span></label>
                    <input type="text" name="EMAIL_TICKETS_MAILER" value="{{getOption('EMAIL_TICKETS_MAILER')}}" required
                           class="form-control">
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4 mb-3">
                <div class="form-group text-black">
                    <label>{{__('MAIL HOST')}} <span class="text-danger">*</span></label>
                    <input type="text" name="EMAIL_TICKETS_HOST" value="{{getOption('EMAIL_TICKETS_HOST')}}" required
                           class="form-control">
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4 mb-3">
                <div class="form-group text-black">
                    <label>{{__('MAIL PORT')}} <span class="text-danger">*</span></label>
                    <input type="text" name="EMAIL_TICKETS_PORT" value="{{getOption('EMAIL_TICKETS_PORT')}}" required
                           class="form-control">
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4 mb-3">
                <div class="form-group text-black">
                    <label>{{__('MAIL USERNAME')}} <span class="text-danger">*</span></label>
                    <input type="text" name="EMAIL_TICKETS_USERNAME" value="{{getOption('EMAIL_TICKETS_USERNAME')}}"
                           required class="form-control">
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4 mb-3">
                <div class="form-group text-black">
                    <label>{{__('MAIL PASSWORD')}} <span class="text-danger">*</span></label>
                    <input type="password" name="EMAIL_TICKETS_PASSWORD" value="{{getOption('EMAIL_TICKETS_PASSWORD')}}"
                           required class="form-control">
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4 mb-3">
                <div class="form-group text-black">
                    <label>{{__('MAIL ENCRYPTION')}} <span class="text-danger">*</span></label>
                    <select name="EMAIL_TICKETS_ENCRYPTION" required class="form-control">
                        <option value="tls" {{getOption('EMAIL_TICKETS_ENCRYPTION') == 'tls' ? 'selected' : '' }} >
                            {{__('tls')}}
                        </option>
                        <option value="ssl" {{getOption('EMAIL_TICKETS_ENCRYPTION') == 'ssl' ? 'selected' : '' }} >
                            {{__('ssl')}}
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4 mb-3">
                <div class="form-group text-black">
                    <label>{{__('MAIL FROM ADDRESS')}} <span class="text-danger">*</span></label>
                    <input type="text" name="EMAIL_TICKETS_FROM_ADDRESS" value="{{getOption('EMAIL_TICKETS_FROM_ADDRESS')}}"
                           required class="form-control">
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4 mb-3">
                <div class="form-group text-black">
                    <label>{{__('MAIL FROM NAME')}} <span class="text-danger">*</span></label>
                    <input type="text" name="EMAIL_TICKETS_FROM_NAME" value="{{getOption('EMAIL_TICKETS_FROM_NAME')}}"
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
