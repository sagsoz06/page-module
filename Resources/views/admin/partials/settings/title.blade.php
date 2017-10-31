<div class="row">
    <fieldset>
        <legend>Başlık Ayarları</legend>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group{{ $errors->has("settings.title_color") ? ' has-error' : '' }}">
                        {!! Form::label("settings.title_color", "Başlık Yazı Rengi".':') !!}
                        {!! Form::input('text', 'settings[title_color]', !isset($page->settings->title_color) ? '' : $page->settings->title_color, ['class'=>'form-control colorpicker']) !!}
                        {!! $errors->first("settings.title_color", '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group{{ $errors->has("settings.title_bg_color") ? ' has-error' : '' }}">
                        {!! Form::label("settings.title_bg_color", "Başlık Arkaplan Rengi".':') !!}
                        {!! Form::input('text', 'settings[title_bg_color]', !isset($page->settings->title_bg_color) ? '' : $page->settings->title_bg_color, ['class'=>'form-control colorpicker']) !!}
                        {!! $errors->first("settings.title_bg_color", '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
                <div class="col-md-3">
                    {!! Form::normalSelect("settings[title_font_size]", "Başlık Font Boyutu", $errors, array(''=>'Seçiniz') + array_combine(range(2, 90, 2), range(2, 90, 2)), isset($page->settings->content_font_responsive) ? $page->settings->content_font_responsive : '') !!}
                </div>
                <div class="col-md-3">
                    <div class="form-group{{ $errors->has("settings.icon") ? ' has-error' : '' }}">
                        {!! Form::label("settings.icon", "İkon".':') !!}
                        {!! Form::input('text', 'settings[icon]', !isset($page->settings->icon) ? '' : $page->settings->icon, ['class'=>'form-control']) !!}
                        {!! $errors->first("settings.icon", '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    @include('page::admin.partials.settings.text-field', ['fields'=>['slogan','sub_title'], 'labels'=>['slogan'=>'Slogan', 'sub_title'=>'Alt Başlık']])
                </div>
            </div>
        </div>
    </fieldset>
</div>