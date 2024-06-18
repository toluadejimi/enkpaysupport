<div class="modal-header">
    <h5 class="modal-title">{{ __('Update') }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form class="ajax reset" action="{{ route('admin.setting.frontend.news-articles.update', $news->id) }}" method="post" data-handler="commonResponseForModal">
    @csrf
    <div class="modal-body">
        <input type="hidden" name="id" value="{{$news->id}}">
        <div class="row">
            <div class="col-12">
                <div class="input__group mb-25">
                    <label for="title">{{ __('Title') }} <span class="text-danger">*</span></label>
                    <input type="text" name="title" placeholder="{{ __('Title') }}" value="{{$news->title}}">
                </div>
            </div>

            <div class="col-12">
                <div class="input__group mb-25">
                    <label for="description">{{ __('Description') }} <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="description" placeholder="{{ __('Description') }}" rows="5" id="">{{$news->description}}</textarea>
                </div>
            </div>


            <div class="col-12">
                <div class="input__group mb-25">
                    <label for="image" class="text-lg-right text-black"> {{__('Image')}}  <span class="text-danger">*</span></label>
                    <div class="upload-img-box">
                        <img src="{{ getFileUrl($news->image) }}">
                        <input type="file" name="image" accept="image/*" onchange="previewFile(this)">
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="input__group mb-25">
                    <label class="form-label">{{ __('Status') }}</label>
                    <div class="input-group">
                        <select name="status" class="form-control">
                            <option value="1" {{$news->status == 1?'selected':''}}>{{ __('Active') }}</option>
                            <option value="0" {{$news->status == 0?'selected':''}}>{{ __('Deactive') }}</option>
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
