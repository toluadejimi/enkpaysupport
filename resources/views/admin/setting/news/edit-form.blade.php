<div class="modal-header">
    <h5 class="modal-title">{{ __('Update') }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form class="ajax reset" action="{{ route('admin.setting.news.update') }}" method="post"
      data-handler="settingCommonHandler">
    @csrf
    <div class="modal-body">
        <div class="row">
            <div class="col-12">
                <div class="input__group mb-25">
                    <input name="id" type="hidden" value="{{ $data->id }}">
                </div>
                <div class="input__group mb-25">
                    <label>{{ __('Title') }}<span class="text-danger">*</span></label>
                    <input type="text" name="title" placeholder="{{ __('Title') }}" value="{{ $data->title }}">
                </div>
            </div>
            <div class="col-12">
                <div class="input__group mb-25">
                    <label>{{ __('Description') }}<span class="text-danger">*</span></label>
                    <textarea name="description" rows="6" placeholder="{{ __('Description') }}">{{ $data->description }}</textarea>
                </div>
            </div>
            <div class="col-12">
                <div class="input__group mb-25">
                    <label>{{ __('Status') }}<span class="text-danger">*</span></label>
                    <select name="status">
                        <option {{ $data->status == 1 ? 'selected' : '' }} value="1">{{ __('Active') }}</option>
                        <option {{ $data->status == 0 ? 'selected' : '' }} value="0">{{ __('Deactivated') }}</option>
                    </select>
                </div>
            </div>
            <div class="col-12">
                <div class="input__group mb-25">
                    <label for="image" class="text-lg-right text-black"> {{__('Image')}} <span
                            class="text-danger">*</span></label>
                    <div class="upload-img-box">
                        <img src="{{ getFileUrl($data->image) }}">
                        <input type="file" name="image" accept="image/*" onchange="previewFile(this)">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-purple">{{ __('Update') }}</button>
    </div>
</form>
