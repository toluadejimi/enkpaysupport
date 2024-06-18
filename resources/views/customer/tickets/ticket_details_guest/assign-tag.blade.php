<div class="view-assign">
    <h3 class="mt-4">#{{$ticketData->tracking_no??""}}-{{$ticketData->ticket_title??""}}</h3>
    <p>{!! nl2br($ticketData->ticket_description)??"" !!}</p>
    @isset($existingTagsData['names'])
        <div class="tag-key-word mb-4">
            @foreach($existingTagsData['names'] as $tagNames)
                <span>{{$tagNames}}</span>
            @endforeach
        </div>
    @endisset

    <div class="image-type">
        @if($ticketData->file_id)
            <div class="file-type mb-3">
                @foreach(json_decode($ticketData->file_id) as $key=>$fileData)
                    @if(in_array(getFileType($fileData), ['image/jpeg','image/jpg','image/png','image/webp']))
                        <a class="test-popup-link" href="{{ getFileUrl($fileData) }}"><img
                                src="{{ getFileUrl($fileData) }}" alt=""></a>
                    @else
                        <a href="{{ getFileUrl($fileData) }}" target="_blank">
                            <button>{{getFileName($fileData)}}</button>
                        </a>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
</div>
