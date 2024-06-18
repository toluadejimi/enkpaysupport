<div class="modal-header">
    <h5 class="modal-title">{{ __('Update') }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form class="ajax reset" action="{{ route('admin.tickets.ticketRatingUpdate') }}" method="post"
      data-handler="commonResponseForModal">
    @csrf
    <div class="modal-body">
        <div class="row">

            <div class="col-12">
                <div class="input__group mb-25">
                    <label class="form-label">{{ __('Status') }}</label>
                    <div class="input-group">
                        <input type="hidden" name="ticket_rating_id" value="{{$ticket_rating->id}}">
                        <select name="status" class="form-control">
                            <option value="1" {{$ticket_rating->status == 1?'selected':''}}>{{ __('Active') }}</option>
                            <option value="0" {{$ticket_rating->status == 0?'selected':''}}>{{ __('Deactive') }}</option>
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
