<div class="modal-header">
    <h5 class="modal-title">{{ __('Update') }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form class="ajax reset" action="{{ route('admin.setting.frontend.knowledge_category.update', $knowledgeCategory->id) }}" method="post"
      data-handler="commonResponseForModal">
    @csrf
    <div class="modal-body">
        <input type="hidden" name="id" value="{{$knowledgeCategory->id}}">
        <div class="row">
            <div class="col-12">
                <div class="input__group mb-25">
                    <label for="title">{{ __('Category') }} <span class="text-danger">*</span></label>
                    <input type="text" name="title" placeholder="{{ __('Category') }}" value="{{$knowledgeCategory->title}}">
                </div>
            </div>
            <div class="col-12">
                <div class="input__group mb-25">
                    <label for="title">{{ __('Description') }} <span class="text-danger">*</span></label>
                    <input type="text" name="description" placeholder="{{ __('Description') }}" value="{{$knowledgeCategory->description}}">
                </div>
            </div>
            <div class="col-12">
                <div class="input__group mb-25">
                    <label class="form-label">{{ __('Status') }}</label>
                    <div class="input-group">
                        <select name="status" class="form-control">
                            <option value="1" {{$knowledgeCategory->status == 1?'selected':''}}>{{ __('Active') }}</option>
                            <option value="0" {{$knowledgeCategory->status == 0?'selected':''}}>{{ __('Deactive') }}</option>
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
