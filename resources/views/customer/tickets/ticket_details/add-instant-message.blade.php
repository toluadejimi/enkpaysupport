<form action="{{route('customer.conversations.instantMessage')}}" method="post" class="form-horizontal"
      enctype="multipart/form-data" data-handler="commonResponseForModal">
    @csrf
    <div class="modal fade" id="InstantModal" tabindex="-2" aria-labelledby="InstantModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg ">
            <div class="modal-content">
                <div class="noteTitle">
                    <h5 class=" " id="InstantModalLabel">{{__('Add Instant Reply')}}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="noteIntoPart">
                    <h6>{{ __('Title') }}:</h6>
                    <input type="text" placeholder="{{ __('Title') }}" name="title" id="title" class="mb-5">
                    <h6>{{__('Message')}}:</h6>
                    <textarea name="message" id="message" cols="30" rows="10"
                              placeholder="{{__('Message')}}"></textarea>
                </div>
                <div class="noteIntoPart-btu">
                    <button type="button" class="noteIntoPartBtuBorder mx-3"
                            data-bs-dismiss="modal">{{__('Back')}}</button>
                    <button type="submit" data-bs-dismiss="modal" class=" submit-btu mx-3">{{__('Add Reply')}}</button>
                </div>
            </div>
        </div>
    </div>
</form>
