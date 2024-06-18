<div class="modal-header">
    <h5 class="modal-title">{{ __('Update') }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form class="ajax reset" action="{{ route('admin.setting.frontend.counter_area.update', $counterArea->id) }}"
      method="post"
      data-handler="commonResponseForModal">
    @csrf
    <div class="modal-body">
        <input type="hidden" name="id" value="{{$counterArea->id}}">
        <div class="row">
            <div class="col-12">
                <div class="input__group mb-25">
                    <label for="title">{{ __('Number') }} <span class="text-danger">*</span></label>
                    <input type="text" name="number" placeholder="{{ __('Number') }}" value="{{$counterArea->number}}">
                </div>
            </div>
            <div class="col-12">
                <div class="input__group mb-25">
                    <label for="title">{{ __('Description') }} <span class="text-danger">*</span></label>
                    <input type="text" name="description" placeholder="{{ __('Description') }}" value="{{$counterArea->description}}">
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-purple">{{ __('Update') }}</button>
    </div>
</form>
