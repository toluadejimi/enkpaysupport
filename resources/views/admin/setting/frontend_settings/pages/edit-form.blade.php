<div class="modal-header">
    <h5 class="modal-title">{{ __('Update') }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form class="ajax reset" action="{{ route('admin.setting.frontend.pages.update', $page->id) }}" method="post"
      data-handler="commonResponseForModal">
    @csrf
    <div class="modal-body">
        <input type="hidden" name="id" value="{{$page->id}}">
        <div class="row">
            <div class="col-12">
                <div class="input__group mb-25">
                    <label for="type">{{ __('Type') }} <span class="text-danger">*</span></label>
                    <input type="text" name="type" disabled value="{{getPageType($page->type)}}">
                </div>
            </div>

            <div class="col-12">
                <div class="input__group mb-25">
                    <label for="title">{{ __('Title') }} <span class="text-danger">*</span></label>
                    <input type="text" name="title" placeholder="{{ __('Title') }}" value="{{$page->title}}">
                </div>
            </div>

            <div class="col-12">
                <div class="col-md-12 mb-25">
                    <label>{{__('Description')}} <span class="text-danger">*</span></label>
                    <textarea name="description" class="summernote"
                              placeholder="{{ __("Description") }}">{!! $page->description !!}</textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-purple">{{ __('Update') }}</button>
    </div>
</form>

<script src="{{ asset('admin/js/custom/summernote-init.js') }}"></script>
