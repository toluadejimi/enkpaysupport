<div class="email-inbox__area bg-style">
    <div class="item-top mb-30 d-flex flex-wrap justify-content-between">
        <h2>{{ __('Social Login (Google) Configuration') }}</h2>
    </div>
    <form class="ajax" action="{{route('admin.setting.settings_env.update')}}" method="POST"
          enctype="multipart/form-data" data-handler="settingCommonHandler">
        @csrf
        <div class="form-group text-black row mb-3">
            <label class="col-lg-3">{{ __('Facebook Client ID') }}</label>
            <div class="col-lg-9">
                <input type="text" name="facebook_client_id" id="facebook_client_id"
                       value="{{getOption('facebook_client_id')}}" class="form-control">
            </div>
        </div>
        <div class="form-group text-black row mb-3">
            <label class="col-lg-3">{{ __('Facebook Client Secret') }} </label>
            <div class="col-lg-9">
                <input type="text" name="facebook_client_secret" id="facebook_client_secret"
                       value="{{getOption('facebook_client_secret')}}" class="form-control">
            </div>
        </div>
        <div class="form-group text-black row mb-3">
            <p>{{ __('Set callback URL') }} : <strong>{{ url('/auth/facebook/callback') }}</strong></p>
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
