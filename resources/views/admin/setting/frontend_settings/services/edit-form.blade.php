<div class="modal-header">
    <h5 class="modal-title">{{ __('Update') }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form class="ajax reset" action="{{ route('admin.setting.frontend.service.update', $service->id) }}" method="post"
      data-handler="commonResponseForModal">
    @csrf
    <div class="modal-body">
        <input type="hidden" name="id" value="{{$service->id}}">
        <div class="row">
            <div class="col-12">
                <div class="input__group mb-25">
                    <label for="title">{{ __('Title') }} <span class="text-danger">*</span></label>
                    <input type="text" name="title" placeholder="{{ __('Title') }}" value="{{$service->title}}">
                </div>
            </div>

            <div class="col-12">
                <div class="input__group mb-25">
                    <label for="description">{{ __('Description') }} <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="description" rows="5"
                              id="">{{$service->description}}</textarea>
                </div>
            </div>
            <div class="col-12">
                <div class="input__group mb-25">
                    <label for="icon" class="text-lg-right text-black"> {{__('Icon')}} <span
                            class="text-danger">*</span></label>
                    <div class="upload-img-box">
                        <img src="{{ getFileUrl($service->icon) }}">
                        <input type="file" name="icon" accept="image/*" onchange="previewFile(this)">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-purple">{{ __('Update') }}</button>
    </div>
</form>
