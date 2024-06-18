<div class="modal-header">
    <h5 class="modal-title">{{ __('Update') }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form class="ajax reset" action="{{ route('admin.tickets.category-store') }}" method="post"
      data-handler="commonResponseForModal">
    @csrf
    <div class="modal-body">
        <input type="hidden" name="id" value="{{$singleData->id}}">
        <div class="row">
            <div class="col-12">
                <div class="input__group mb-25">
                    <label for="title">{{ __('Name') }} <span class="text-danger">*</span></label>
                    <input type="text" name="name" placeholder="{{ __('Name') }}" value="{{$singleData->name}}">
                </div>
            </div>
            <div class="col-12">
                <div class="input__group mb-25">
                    <label for="title">{{ __('Code') }} <span class="text-danger">*</span></label>
                    <input type="text" name="code" placeholder="" value="{{$singleData->code}}">
                </div>
            </div>

            <div class="col-12">
                <div class="input__group mb-25">
                    <label class="form-label">{{ __('Group User') }}</label>
                    <div class="input-group">
                        <select name="group_user[]" class="form-control " multiple="multiple">
                            @foreach($userList as $user)
                                <option value="{{$user->id}}" {{in_array($user->id, $categoryUserData)?'selected':''}}>{{ $user->email.'('.getRoleName(USER_ROLE_AGENT).')' }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="input__group mb-25">
                    <label class="form-label">{{ __('Is Ticket Prefix') }}</label>
                    <div class="input-group">
                        <select name="is_ticket_prefix" class="form-control">
                            <option value="1" {{$singleData->is_ticket_prefix == 1?'selected':''}}>{{ __('Active') }}</option>
                            <option value="0" {{$singleData->is_ticket_prefix == 0?'selected':''}}>{{ __('Deactive') }}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="input__group mb-25">
                    <label class="form-label">{{ __('Status') }}</label>
                    <div class="input-group">
                        <select name="status" class="form-control">
                            <option value="1" {{$singleData->status == 1?'selected':''}}>{{ __('Active') }}</option>
                            <option value="0" {{$singleData->status == 0?'selected':''}}>{{ __('Deactive') }}</option>
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
