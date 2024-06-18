<div class="modal-header">
    <h5 class="modal-title">{{ __('Update') }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form class="ajax reset" action="{{ route('admin.setting.frontend.testimonial.update', $testimonial->id) }}"
      method="post"
      data-handler="commonResponseForModal">
    @csrf
    <div class="modal-body">
        <input type="hidden" name="id" value="{{$testimonial->id}}">
        <div class="row">
            <div class="col-12">
                <div class="input__group mb-25">
                    <label for="title">{{ __('Client Name') }} <span class="text-danger">*</span></label>
                    <input type="text" name="name" placeholder="{{ __('Client Name') }}" id="title" value="{{$testimonial->name}}"/>
                </div>
            </div>
            <div class="col-12">
                <div class="input__group mb-25">
                    <label for="description">{{ __('Designation') }} <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="designation" rows="5" placeholder="{{ __('Designation') }}"
                              id="">{{$testimonial->designation}}</textarea>
                </div>
            </div>
            <div class="col-12">
                <div class="input__group mb-25">
                    <label for="description">{{ __('Comment') }} <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="comment" rows="5" id="">{{$testimonial->comment}}</textarea>
                </div>
            </div>
            <div class="col-12">
                <div class="input__group mb-25">
                    <label for="description">{{ __('Review') }} <span class="text-danger">*</span></label>
                    <input type="number" name="star" class="form-control"
                           value="{{$testimonial->star}}">
                </div>
            </div>
            <div class="col-12">
                <div class="input__group mb-25">
                    <label class="form-label">{{ __('Status') }}</label>
                    <div class="input-group">
                        <select name="status" class="form-control">
                            <option value="1" {{$testimonial->status == 1?'selected':''}}>{{ __('Active') }}</option>
                            <option value="0" {{$testimonial->status == 0?'selected':''}}>{{ __('Deactive') }}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="col-12">
                        <div class="input__group mb-25">
                            <label for="icon" class="text-lg-right text-black"> {{__('Client Image')}} <span
                                    class="text-danger">*</span></label>
                            <div class="upload-img-box">
                                <img src="{{ getFileUrl($testimonial->image) }}">
                                <input type="file" name="image" accept="image/*" onchange="previewFile(this)">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="col-12">
                        <div class="input__group mb-25">
                            <label for="icon" class="text-lg-right text-black"> {{__('Company Logo')}} <span
                                    class="text-danger">*</span></label>
                            <div class="upload-img-box">
                                <img src="{{ getFileUrl($testimonial->logo) }}">
                                <input type="file" name="logo" accept="image/*" onchange="previewFile(this)">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-purple">{{ __('Update') }}</button>
    </div>
</form>
