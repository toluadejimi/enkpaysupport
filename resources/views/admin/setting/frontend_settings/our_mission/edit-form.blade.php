<div class="modal-header">
    <h5 class="modal-title">{{ __('Update') }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form class="ajax reset" action="{{ route('admin.setting.frontend.our_mission.update', $ourMission->id) }}"
      method="post"
      data-handler="commonResponseForModal">
    @csrf
    <div class="modal-body">
        <input type="hidden" name="id" value="{{$ourMission->id}}">
        <div class="row">
            <div class="col-12">
                <div class="input__group mb-25">
                    <label for="title">{{ __('Title') }} <span class="text-danger">*</span></label>
                    <input type="text" name="title" placeholder="{{ __('Title') }}" value="{{$ourMission->title}}">
                </div>
            </div>
            <div class="col-12 ">
                <div class="input__group mb-25">
                    <label for="description">{{ __('Description') }} <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="description" placeholder="{{ __('Description') }}" rows="5"
                              id="">{{$ourMission->description}}</textarea>
                </div>
            </div>
            <div class="col-12">
                <label for="description">{{ __('Description Point') }} <span class="text-danger">*</span></label>
                <button type="button" onclick="addOurMissionPoint(this)" class=" text-success float-end">
                    <span class="icon" data-icon=""></span>
                    {{ __("Add") }}
                </button>
            </div>
            @foreach($ourMission->description_point as $point)
                <div id="ourMissionHtml">
                    <div class="col-12 d-flex mb-10 ourMissionChild">
                        <textarea class="form-control me-2" name="description_point[]" rows="2">{{ $point }}</textarea>
                        @if(!$loop->first )
                            <button type="button" class="removeOurMission text-danger">
                                <i class="iconify" data-icon="gala:remove"></i>
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
            <div class="col-md-12">
                <div class="row ourMissionParent">
                </div>
                <div class="col-12">
                    <div class="input__group mb-25">
                        <label for="image" class="text-lg-right text-black"> {{__('Image')}} <span
                                class="text-danger">*</span></label>
                        <div class="upload-img-box">
                            <img src="{{ getFileUrl($ourMission->image) }}">
                            <input type="file" name="image" accept="image/*" onchange="previewFile(this)">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-purple">{{ __('Update') }}</button>
        </div>
    </div>
</form>
