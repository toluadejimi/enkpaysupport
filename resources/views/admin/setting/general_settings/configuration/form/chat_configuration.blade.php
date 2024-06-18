<div class="customers__area bg-style mb-30">
    <div class="item-top mb-30">
        <h2>{{__('Chat Configuration')}}</h2>
    </div>
    <form action="{{ route('admin.setting.chat.configur') }}" method="post"
          class="form-horizontal" data-handler="commonResponseForModal">
        @csrf
        <div class="form-group text-black row mb-3">
            <label class="col-lg-3">{{ __('Need Help?') }} </label>

            <div class="col-lg-9">
                <input type="text" min="0" max="100" step="any" @if (!empty($chatConfigurData->chat_title)) value="{{$chatConfigurData->chat_title}}" @endif  name="chat_title" class="form-control">
            </div>
        </div>
        <div class="form-group text-black row mb-3">
            <label class="col-lg-3">{{ __('Send Us a Message') }} </label>
            <div class="col-lg-9">
                <input type="text" min="0" max="100" step="any" @if (!empty($chatConfigurData->message_title)) value="{{$chatConfigurData->message_title}}" @endif name="message_title" class="form-control">
            </div>
        </div>
        <div class="form-group text-black row mb-3">
            <label class="col-lg-3">{{ __('We typically reply in a few hours') }} </label>
            <div class="col-lg-9">
                <input type="text" min="0" max="100" step="any" @if (!empty($chatConfigurData->message_title)) value="{{$chatConfigurData->message_discription}}" @endif name="message_discription" class="form-control">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12 text-end">
                <button class="btn btn-blue" type="submit">{{ __('Update') }}</button>
            </div>
        </div>
    </form>
</div>


