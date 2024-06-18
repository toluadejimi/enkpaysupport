<div class="modal-header">
    <h5 class="modal-title">{{ __('Update') }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form class="ajax reset" action="{{ route('admin.setting.frontend.knowledge.update', $knowledge->id) }}" method="post"
      data-handler="commonResponseForModal">
    @csrf
    <div class="modal-body">
        <input type="hidden" name="id" value="{{$knowledge->id}}">
        <div class="row">
            <div class="col-12">
                <div class="input__group mb-25">
                    <label for="title">{{ __('Title') }} <span class="text-danger">*</span></label>
                    <input type="text" name="title" placeholder="{{ __('Title') }}" value="{{$knowledge->title}}">
                </div>
            </div>
            <div class="col-12">
                <div class="input__group mb-25">
                    <label for="title">{{ __('Description') }} <span class="text-danger">*</span></label>
                    <textarea name="description" class="summernote" placeholder="{{ __("Description") }}">{!! $knowledge->description !!}</textarea>
                </div>
            </div>
            <div class="col-12">
                <div class="input__group mb-25">
                    <label class="form-label">{{ __('Status') }}</label>
                    <div class="input-group">
                        <select name="status" class="form-control">
                            <option value="1" {{$knowledge->status == 1?'selected':''}}>{{ __('Active') }}</option>
                            <option value="0" {{$knowledge->status == 0?'selected':''}}>{{ __('Deactive') }}</option>
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
<script src="{{ asset('admin/js/custom/summernote-init.js') }}"></script>
<script src="{{ asset('admin/js/custom/select2-init.js') }}"></script>
