<div class="customers__area bg-style mb-30">
    <div class="item-top mb-30">
        <h2>{{__('Referral Setting')}}</h2>
    </div>
    <form class="ajax" action="{{ route('admin.setting.referral.update') }}" method="post"
          class="form-horizontal" data-handler="commonResponseForModal">
        @csrf
        <div class="row">
            <div class="input__group mb-25 col-md-4">
                <label>{{__('Level')}} 1 (%)</label>
                <div class="input-group">
                    <input type="number" min="0" max="100" step="any" name="referral_level_1"
                           value="{{getOption('referral_level_1')}}" class="form-control">
                    <span class="input-group-text">%</span>
                    @if ($errors->has('referral_level_1'))
                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('referral_level_1') }}</span>
                    @endif
                </div>
            </div>
            <div class="input__group mb-25 col-md-4">
                <label>{{__('Level')}} 2 (%)</label>
                <div class="input-group">
                    <input type="number" min="0" max="100" step="any" name="referral_level_2"
                           value="{{getOption('referral_level_2')}}" class="form-control">
                    <span class="input-group-text">%</span>
                    @if ($errors->has('referral_level_2'))
                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('referral_level_2') }}</span>
                    @endif
                </div>
            </div>
            <div class="input__group mb-25 col-md-4">
                <label>{{__('Level')}} 3 (%)</label>
                <div class="input-group">
                    <input type="number" min="0" max="100" step="any" name="referral_level_3"
                           value="{{getOption('referral_level_3')}}" class="form-control">
                    <span class="input-group-text">%</span>
                    @if ($errors->has('referral_level_3'))
                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('referral_level_3') }}</span>
                    @endif
                </div>
            </div>
            <div class="input__group mb-25 col-md-4">
                <label>{{__('Level')}} 4 (%)</label>
                <div class="input-group">
                    <input type="number" min="0" max="100" step="any" name="referral_level_4"
                           value="{{getOption('referral_level_4')}}" class="form-control">
                    <span class="input-group-text">%</span>
                    @if ($errors->has('referral_level_4'))
                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('referral_level_4') }}</span>
                    @endif
                </div>
            </div>
            <div class="input__group mb-25 col-md-4">
                <label>{{__('Level')}} 5 (%)</label>
                <div class="input-group">
                    <input type="number" min="0" max="100" step="any" name="referral_level_5"
                           value="{{getOption('referral_level_5')}}" class="form-control">
                    <span class="input-group-text">%</span>
                    @if ($errors->has('referral_level_5'))
                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('referral_level_5') }}</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12 text-end">
                <button class="btn btn-blue" type="submit">{{ __('Update') }}</button>
            </div>
        </div>
    </form>
</div>