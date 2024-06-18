<div class="email-inbox__area bg-style">
    <div class="item-top mb-30 d-flex flex-wrap justify-content-between">
        <h2>{{ __('Google Recaptcha Credentials') }}</h2>
    </div>
    <form class="ajax" action="{{route('admin.setting.settings_env.update')}}" method="post" class="form-horizontal" data-handler="settingCommonHandler">
        @csrf
        <div class="form-group text-black row mb-3">
            <label class="col-lg-3">{{ __('Google Recaptcha Site Key') }}</label>
            <div class="col-lg-9">
                <input type="text" name="google_recaptcha_site_key" id="google_recaptcha_site_key"
                       value="{{getOption('google_recaptcha_site_key')}}" class="form-control">
            </div>
        </div>
        <div class="form-group text-black row mb-3">
            <label class="col-lg-3">{{ __('Google Recaptcha Secret Key') }} </label>
            <div class="col-lg-9">
                <input type="text" name="google_recaptcha_secret_key"
                       id="google_recaptcha_secret_key"
                       value="{{getOption('google_recaptcha_secret_key')}}" class="form-control">
            </div>
        </div>
        <div class="justify-content-end row text-end">
            <div class="col-md-12">
                <button type="submit" class="btn btn-blue float-right">{{__('Update')}}</button>
            </div>
        </div>
    </form>
</div>