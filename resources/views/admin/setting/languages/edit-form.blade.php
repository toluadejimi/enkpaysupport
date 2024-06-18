<div class="modal-header">
    <h5 class="modal-title">{{ __('Update Language') }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form class="ajax reset" action="{{ route('admin.setting.languages.update', $language->id) }}" method="post"
      data-handler="languageHandler">
    @csrf
    <div class="modal-body">
        <div class="row">
            <div class="col-12">
                <div class="input__group mb-25">
                    <label for="language">{{ __('Language') }} <span class="text-danger">*</span></label>
                    <input type="text" name="language" value="{{ $language->language }}"
                           placeholder="{{ __("Type Language Name") }}" required>
                </div>
            </div>
            <div class="col-12">
                <div class="input__group mb-25">
                    <label for="iso_code">{{ __('ISO Code') }} <span class="text-danger">*</span></label>
                    <select name="iso_code" required>
                        <option value="">--{{ __('Select ISO Code') }}--</option>
                        @foreach(languageIsoCode() as $code => $isoCountryName)
                            <option
                                value="{{$code}}" {{ $code == $language->iso_code ? 'selected' : '' }}>{{$isoCountryName.'-'.$code}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-12">
                <div class="input__group mb-25">
                    <label for="flag" class="text-lg-right text-black"> {{__('Flag')}} <span
                            class="text-danger">*</span> </label>
                    <div class="upload-img-box">
                        <img src="{{ getFileUrl($language->flag_id) }}">
                        <input type="file" name="flag" accept="image/*" onchange="previewFile(this)">
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="input__group mb-25">
                    <label for="rtl">{{ __('RTL Supported') }} <span class="text-danger">*</span></label>
                    <select name="rtl" required>
                        <option {{ $language->rtl == 0 ? 'selected' : '' }} value="0">{{__("No")}}</option>
                        <option {{ $language->rtl == 1 ? 'selected' : '' }} value="1">{{__("Yes")}}</option>
                    </select>
                </div>
            </div>
            <div class="col-12">
                <div class="form-check">
                    <input name="default" class="form-check-input" type="checkbox" value="1"
                           {{ $language->default == STATUS_ACTIVE ? 'checked' : '' }} id="flexCheckChecked-{{ $language->id }}">
                    <label class="form-check-label p-1" for="flexCheckChecked-{{ $language->id }}">
                        {{ __('Default Language') }}
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-purple">{{ __('Update') }}</button>
    </div>
</form>
