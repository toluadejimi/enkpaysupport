<div class="email-inbox__area bg-style">
    <div class="item-top mb-30 d-flex flex-wrap justify-content-between">
        <h2>{{ __('Pusher Configuration') }}</h2>
    </div>
    <form class="ajax" action="{{route('admin.setting.settings_env.update')}}" method="post"
          class="form-horizontal" data-handler="settingCommonHandler">
        @csrf
        <div class="form-group text-black row mb-3">
            <label class="col-lg-3">{{ __('Pusher App Id') }}</label>
            <div class="col-lg-9">
                <input type="text" name="pusher_app_id" id="pusher_app_id"
                       value="{{getOption('pusher_app_id')}}" class="form-control">
            </div>
        </div>
        <div class="form-group text-black row mb-3">
            <label class="col-lg-3">{{ __('Pusher App Key') }} </label>
            <div class="col-lg-9">
                <input type="text" name="pusher_app_key"
                       id="pusher_app_key"
                       value="{{getOption('pusher_app_key')}}" class="form-control">
            </div>
        </div>
        <div class="form-group text-black row mb-3">
            <label class="col-lg-3">{{ __('Pusher App Secret') }} </label>
            <div class="col-lg-9">
                <input type="text" name="pusher_app_secret"
                       id="pusher_app_secret"
                       value="{{getOption('pusher_app_secret')}}" class="form-control">
            </div>
        </div>
        <div class="form-group text-black row mb-3">
            <label class="col-lg-3">{{ __('Pusher Cluster') }} </label>
            <div class="col-lg-9">
                <input type="text" name="pusher_cluster"
                       id="pusher_cluster"
                       value="{{getOption('pusher_cluster')}}" class="form-control">
            </div>
        </div>
        <div class="justify-content-end row text-end">
            <div class="col-md-12">
                <button type="submit" class="btn btn-blue float-right">{{__('Update')}}</button>
            </div>
        </div>
    </form>
</div>