<div class="customers__area bg-style mb-30">
    <div class="item-top mb-30">
        <h2>{{__('Cookie Configuration')}}</h2>
    </div>
    <form class="ajax" action="{{ route('admin.setting.common.settings.update') }}" method="post"
          class="form-horizontal" data-handler="commonResponseForModal">
        @csrf
        <div class="row">
            <div class="col-12 mb-4">
                <label class="form-label">{{__('Cookie Consent Text')}} </label>
                <textarea class="form-control" name="cookie_consent_text" cols="30" rows="10">{{getOption('cookie_consent_text')}}</textarea>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12 text-end">
                <button class="btn btn-blue" type="submit">{{ __('Update') }}</button>
            </div>
        </div>
    </form>
</div>
