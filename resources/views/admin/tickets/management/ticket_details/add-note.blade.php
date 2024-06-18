<form action="{{route('admin.notes.noteStore')}}" method="post" class="form-horizontal" enctype="multipart/form-data" data-handler="commonResponseForModal">
    @csrf
    <div class="modal fade" id="noteAddModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg ">
      <div class="modal-content">
        <div class="noteTitle">
          <h5 class=" " id="exampleModalLabel">{{__('Add Ticket Note ')}}</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"><i class="fa-solid fa-times"></i></span>
          </button>
        </div>
          <input type="hidden" name="ticket_id" value="" id="noteTickeId">
          <input type="hidden" name="id" value="" id="noteId">
        <div class="noteIntoPart">
          <h6>{{__('Note Details')}}:</h6>
          <textarea name="note_details" id="note_details" cols="30" rows="10"
            placeholder="{{__('Note Details')}}"></textarea>
        </div>
        <div class="noteIntoPart-btu sf-noteIntoPart-btu">
            <input type="hidden" name="note_id" value="{{$roles->id ?? ''}}" id="note_id">
          <button type="button" class="noteIntoPartBtuBorder mx-3" data-bs-dismiss="modal">{{__('Back')}}</button>
          <button type="submit" data-bs-dismiss="modal" class=" submit-btu mx-3 ">{{__('Add Note')}}</button>
        </div>
      </div>
    </div>
  </div>
</form>
