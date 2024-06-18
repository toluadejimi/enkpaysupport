<div class="modal-header">
    <h5 class="modal-title">{{ __('Update') }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form class="ajax reset" action="{{ route('admin.setting.frontend.how_it_work.update', $howItWork->id) }}" method="post"
      data-handler="commonResponseForModal">
    @csrf
    <div class="modal-body">
        <input type="hidden" name="id" value="{{$howItWork->id}}">
        <div class="row">
            <div class="col-12">
                <div class="input__group mb-25">
                    <label for="title">{{ __('Title') }} <span class="text-danger">*</span></label>
                    <input type="text" name="title" placeholder="{{ __('Title') }}" value="{{$howItWork->title}}">
                </div>
            </div>
            <div class="col-12">
                <div class="input__group mb-25">
                    <label for="description">{{ __('Description') }} <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="description" rows="5"
                              id="">{{$howItWork->description}}</textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-purple">{{ __('Update') }}</button>
    </div>
</form>
