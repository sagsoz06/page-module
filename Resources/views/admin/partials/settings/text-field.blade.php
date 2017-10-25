<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        @foreach(LaravelLocalization::getSupportedLocales() as $locale => $language)
            <li class="{{ $loop->first ? 'active' : '' }}"><a href="#{{ $field }}_{{ $locale }}" data-toggle="tab">{{ $language['native'] }}</a></li>
        @endforeach
    </ul>
    <div class="tab-content">
        @foreach(LaravelLocalization::getSupportedLocales() as $locale => $language)
            <div class="tab-pane {{ $loop->first ? 'active' : '' }}" id="slogan_{{ $locale }}">
                <div class="form-group{{ $errors->has("settings.slogan") ? ' has-error' : '' }}">
                    {!! Form::label("settings.icon", $language['native'].' '.$label.':') !!}
                    {!! Form::input('text', 'settings['.$field.']['.$locale.']', old('settings.'.$field.'.'.$locale, $page->settings->slogan->{$locale} ?? ''), ['class'=>'form-control']) !!}
                    {!! $errors->first("settings.'.$field.'.".$locale, '<span class="help-block">:message</span>') !!}
                </div>
            </div>
        @endforeach
    </div>
</div>