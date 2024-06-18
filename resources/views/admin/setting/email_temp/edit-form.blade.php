<div class="modal-header">
    <h5 class="modal-title">{{ __('Update') }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>



<form class="ajax reset" action="{{ route('admin.setting.email-temp-update', $template->id) }}" method="post"
    data-handler="commonResponseForModal">
    @csrf
    <div class="modal-body model-lg">
        <div class="row">
            <div class="col-md-12 mb-25">
                <p class="alert-success p-20">{{__("Email Template Fields")}} : @foreach(emailTempFields() as $key=>$item) {{$key}} @endforeach</p>
            </div>

            <div class="col-md-6">
                <div class="input__group mb-25">
                    <label for="subject">{{ __('Subject') }} <span class="text-danger">*</span></label>
                    <input type="text" name="subject" value="{{ $template->subject }}" placeholder="{{ __('Subject') }}">
                </div>
            </div>
            <div class="col-md-12 mb-25">
                <label>{{__('Body')}} <span class="text-danger">*</span></label>
                <textarea name="body" class="summernote" placeholder="{{ __("Body") }}">{!! $template->body !!}</textarea>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-purple">{{ __('Save') }}</button>
    </div>
</form>
<script src="{{ asset('admin/js/custom/summernote-init.js') }}"></script>
<script src="{{ asset('admin/js/custom/select2-init.js') }}"></script>

