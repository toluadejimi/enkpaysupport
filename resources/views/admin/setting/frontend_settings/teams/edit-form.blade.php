<div class="modal-header">
    <h5 class="modal-title">{{ __('Update') }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form class="ajax reset" action="{{ route('admin.setting.frontend.team.update', $team->id) }}" method="post"
      data-handler="commonResponseForModal">
    @csrf
    <div class="modal-body">
        <input type="hidden" name="id" value="{{$team->id}}">
        <div class="row">
            <div class="col-12">
                <div class="input__group mb-25">
                    <label for="title">{{ __('Name') }} <span class="text-danger">*</span></label>
                    <input type="text" name="name" placeholder="{{ __('Name') }}" value="{{$team->name}}">
                </div>
            </div>
            <div class="col-12">
                <div class="input__group mb-25">
                    <label for="title">{{ __('Designation') }} <span class="text-danger">*</span></label>
                    <input type="text" name="designation" placeholder="{{ __('Designation') }}" value="{{$team->designation}}">
                </div>
            </div>
            <div class="col-12">
                <div class="input__group mb-25">
                    <label for="description">{{ __('Facebook Link') }} <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="facebook_link" rows="5" placeholder="{{ __('Facebook Link') }}"
                              id="">{{$team->facebook_link}}</textarea>
                </div>
            </div>
            <div class="col-12">
                <div class="input__group mb-25">
                    <label for="description">{{ __('Instagram Link') }} <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="instagram_link" rows="5" placeholder="{{ __('Instagram Link') }}"
                              id="">{{$team->instagram_link}}</textarea>
                </div>
            </div>
            <div class="col-12">
                <div class="input__group mb-25">
                    <label for="description">{{ __('Twitter Link') }} <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="twitter_link" rows="5" placeholder="{{ __('Twitter Link') }}"
                              id="">{{$team->twitter_link}}</textarea>
                </div>
            </div>
            <div class="col-12">
                <div class="input__group mb-25">
                    <label class="form-label">{{ __('Status') }}</label>
                    <div class="input-group">
                        <select name="status" class="form-control">
                            <option value="1" {{$team->status == 1?'selected':''}}>{{ __('Active') }}</option>
                            <option value="0" {{$team->status == 0?'selected':''}}>{{ __('Deactive') }}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="input__group mb-25">
                    <label for="icon" class="text-lg-right text-black"> {{__('Image')}} <span
                            class="text-danger">*</span></label>
                    <div class="upload-img-box">
                        <img src="{{ getFileUrl($team->image) }}">
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
