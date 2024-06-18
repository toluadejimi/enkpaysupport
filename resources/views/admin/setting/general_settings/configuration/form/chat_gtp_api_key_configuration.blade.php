<div class="customers__area bg-style mb-30">
    <div class="item-top mb-30">
        <h2>{{__('Chat Gtp Api Key Generate')}}</h2>
    </div>
    <form class="ajax" action="{{ route('admin.setting.chat.gtp.update') }}" method="post" class="form-horizontal" data-handler="commonResponseForModal">
        @csrf
        <div class="form-group text-black row mb-3">
            <label class="col-lg-3">{{ __('Chat Gtp Api Key Generate') }} </label>
            <div class="col-lg-9">
                <input type="text" min="0" max="100" step="any" name="chat_gtp_api_key" value="{{getOption('chat_gtp_api_key')}}"  class="form-control">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12 text-end">
                <button class="btn btn-blue" type="submit">{{ __('Update') }}</button>
            </div>
        </div>
    </form>
</div>

