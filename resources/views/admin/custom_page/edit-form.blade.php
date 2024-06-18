<div class="modal-header">
    <h5 class="modal-title">{{ __('Update') }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<form class="ajax reset" action="{{ route('admin.custom-pages-update', $page->id) }}" method="post"
    data-handler="commonResponseForModal">
    @csrf
    <div class="modal-body model-lg">
        <div class="row">
            <div class="col-md-12">
                <div class="input__group mb-25">
                    <label for="title">{{ __('Title') }} <span class="text-danger">*</span></label>
                    <input type="text" name="title" value="{{$page->title}}" placeholder="{{ __('Title') }}">
                </div>
            </div>

            <div class="col-md-12 mb-25">
                <label>{{__('Details')}} <span class="text-danger">*</span></label>
                <textarea name="details" class="summernote" placeholder="{{ __("Details") }}">{{$page->desc}}</textarea>
            </div>

            <div class="col-md-6">
                <div class="input__group mb-25">
                    <label class="form-label">{{ __('Status') }} <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <select name="status" class="form-control">
                            <option value="1" {{$page->status == 1?'selected':''}}>{{ __('Publish') }}</option>
                            <option value="0" {{$page->status == 0?'selected':''}}>{{ __('Unpublish') }}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-purple">{{ __('Save') }}</button>
    </div>
</form>
<script src="{{ asset('admin/js/custom/summernote-init.js') }}"></script>


