<div class="modal-header">
    <h5 class="modal-title">{{ __('Update') }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form class="ajax reset" action="{{ route('admin.setting.frontend.faq.update', $faq->id) }}" method="post"
      data-handler="commonResponseForModal">
    @csrf
    <div class="modal-body">
        <input type="hidden" name="id" value="{{$faq->id}}">
        <div class="row">
            <div class="col-12">
                <div class="input__group mb-25">
                    <label for="title">{{ __('Question') }} <span class="text-danger">*</span></label>
                    <input type="text" name="question" placeholder="{{ __('Question') }}" value="{{$faq->question}}">
                </div>
            </div>

            <div class="col-12">
                <div class="input__group mb-25">
                    <label for="description">{{ __('Answer') }} <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="answer" rows="5" id="">{{$faq->answer}}</textarea>
                </div>
            </div>
            <div class="col-12">
                <div class="input__group mb-25">
                    <label class="form-label">{{ __('Status') }}</label>
                    <div class="input-group">
                        <select name="status" class="form-control">
                            <option value="1" {{$faq->status == 1?'selected':''}}>{{ __('Active') }}</option>
                            <option value="0" {{$faq->status == 0?'selected':''}}>{{ __('Deactive') }}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-purple">{{ __('Update') }}</button>
    </div>
</form>
