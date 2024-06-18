<div class="customers__area bg-style mb-30">
    <div class="item-top mb-30">
        <h2>{{__('Envato Personal Api Token')}}</h2>
    </div>
    <form class="ajax" action="{{ route('admin.envato.config-modal-data-store') }}" method="post" class="form-horizontal" data-handler="commonResponseForModal">
        @csrf
        <div class="form-group text-black row mb-3">
            <label class="col-lg-3">{{ __('Api Token') }} </label>
            <div class="col-lg-9">
                <input type="text" min="0" max="100" step="any" name="envato_personal_api_token" value="{{ isset($envatoConfigData->personal_api_token) ? $envatoConfigData->personal_api_token : '' }}"  class="form-control">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12 text-end">
                <button class="btn btn-blue" type="submit">{{ __('Update') }}</button>
            </div>
        </div>
    </form>
</div>
