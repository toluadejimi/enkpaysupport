<div class="allNotes-area mb-5">
    <div class="allNotes-tille">

        <h4>{{__('All Notes')}}</h4>
        <span>
        <img src="{{ asset('agent/assets/images/pin.png')}}" alt="">
      </span>
    </div>
    @php
        $counter = 1;
    @endphp
    @forelse($noteData as $note)
        <div class="noteText @if($counter % 2 == 1) paleGreen @else yellowGreen @endif " id="note_{{$note->id}}">
            <div class="d-flex justify-content-between gap-2">
                <p id="note_body_{{$note->id}}">{{ nl2br(strip_tags($note->body))}}</p>
                <span class="iconNotifi">
          <span class="ellipsisDote ">
            <i class="fa-solid fa-ellipsis-vertical  @if($counter % 2 == 1) paleGreenColor @else yellowGreenColor @endif"></i>
          </span>
          <div class="editPart">
                            <a href="#" class="editNoteBtn" data-id="{{$note->id}}" data-body="{{$note->body}}"
                               data-ticket_id="{{$note->ticket_id}}" ><div class="coustomPart"> <span>{{__('Edit')}}</span>
                  <svg
                      xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                      fill="none">
                  <path
                      d="M13.9987 8C13.8219 8 13.6523 8.07024 13.5273 8.19526C13.4023 8.32029 13.332 8.48986 13.332 8.66667V12.6667C13.332 12.8435 13.2618 13.013 13.1368 13.1381C13.0117 13.2631 12.8422 13.3333 12.6654 13.3333H3.33203C3.15522 13.3333 2.98565 13.2631 2.86063 13.1381C2.7356 13.013 2.66536 12.8435 2.66536 12.6667V3.33333C2.66536 3.15652 2.7356 2.98695 2.86063 2.86193C2.98565 2.7369 3.15522 2.66667 3.33203 2.66667H7.33203C7.50884 2.66667 7.67841 2.59643 7.80344 2.4714C7.92846 2.34638 7.9987 2.17681 7.9987 2C7.9987 1.82319 7.92846 1.65362 7.80344 1.5286C7.67841 1.40357 7.50884 1.33333 7.33203 1.33333H3.33203C2.8016 1.33333 2.29289 1.54405 1.91782 1.91912C1.54274 2.29419 1.33203 2.8029 1.33203 3.33333V12.6667C1.33203 13.1971 1.54274 13.7058 1.91782 14.0809C2.29289 14.456 2.8016 14.6667 3.33203 14.6667H12.6654C13.1958 14.6667 13.7045 14.456 14.0796 14.0809C14.4547 13.7058 14.6654 13.1971 14.6654 12.6667V8.66667C14.6654 8.48986 14.5951 8.32029 14.4701 8.19526C14.3451 8.07024 14.1755 8 13.9987 8ZM3.9987 8.50667V11.3333C3.9987 11.5101 4.06894 11.6797 4.19396 11.8047C4.31898 11.9298 4.48855 12 4.66536 12H7.49203C7.57977 12.0005 7.66674 11.9837 7.74797 11.9505C7.82919 11.9173 7.90307 11.8685 7.96536 11.8067L12.5787 7.18667L14.472 5.33333C14.5345 5.27136 14.5841 5.19762 14.618 5.11638C14.6518 5.03515 14.6692 4.94801 14.6692 4.86C14.6692 4.77199 14.6518 4.68485 14.618 4.60362C14.5841 4.52238 14.5345 4.44864 14.472 4.38667L11.6454 1.52667C11.5834 1.46418 11.5097 1.41458 11.4284 1.38074C11.3472 1.34689 11.26 1.32947 11.172 1.32947C11.084 1.32947 10.9969 1.34689 10.9156 1.38074C10.8344 1.41458 10.7607 1.46418 10.6987 1.52667L8.8187 3.41333L4.19203 8.03333C4.13024 8.09563 4.08136 8.1695 4.04818 8.25073C4.01501 8.33195 3.99819 8.41893 3.9987 8.50667ZM11.172 2.94L13.0587 4.82667L12.112 5.77333L10.2254 3.88667L11.172 2.94ZM5.33203 8.78L9.28537 4.82667L11.172 6.71333L7.2187 10.6667H5.33203V8.78Z"
                      fill="#737C90"/>
                </svg>

            </div>
                                 </a>
            <a href="#" onclick="deleteNote('{{route('admin.notes.note-delete',$note->id)}}',{{$note->id}})">
                <div class="coustomPart">
                <span>{{__('Delete')}}</span>
                <span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                           fill="none">
                    <path d="M2 4H3.33333H14" stroke="#737C90" stroke-width="1.4" stroke-linecap="round"
                          stroke-linejoin="round"/>
                    <path
                        d="M5.33203 4.00004V2.66671C5.33203 2.31309 5.47251 1.97395 5.72256 1.7239C5.9726 1.47385 6.31174 1.33337 6.66536 1.33337H9.33203C9.68565 1.33337 10.0248 1.47385 10.2748 1.7239C10.5249 1.97395 10.6654 2.31309 10.6654 2.66671V4.00004M12.6654 4.00004V13.3334C12.6654 13.687 12.5249 14.0261 12.2748 14.2762C12.0248 14.5262 11.6857 14.6667 11.332 14.6667H4.66536C4.31174 14.6667 3.9726 14.5262 3.72256 14.2762C3.47251 14.0261 3.33203 13.687 3.33203 13.3334V4.00004H12.6654Z"
                        stroke="#737C90" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M6.66797 7.33337V11.3334" stroke="#737C90" stroke-width="1.4"
                          stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M9.33203 7.33337V11.3334" stroke="#737C90" stroke-width="1.4"
                          stroke-linecap="round" stroke-linejoin="round"/>
                    </svg></span>
                </div>
            </a>
          </div>
        </span>
            </div>
            <div class="noteUserInfo">
                <div class="sf-img">
                    <img src="{{ getFileUrl($note->user->image) }}" alt="">
                </div>
                <p>{{$note->user->name}} <span>({{getRoleName($note->user->role)}})</span></p>
            </div>
        </div>
        @php
            $counter++;
        @endphp
    @empty
        <div class="notes-not-yet">
            <div class="notes-not-img">
                <img src="../../../assets/images/no-data.png" alt="">
            </div>
            <h5 class="notes-not-title">{{__('Don’t have any notes yet.')}}</h5>
            <p class="notes-not-yet">{{__('Add your notes here.')}}</p>
        </div>
    @endforelse
</div>

