<div class="row">
    <fieldset>
        <legend>Alt Menü Ayarları</legend>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group{{ $errors->has("settings.menu_title_color") ? ' has-error' : '' }}">
                                {!! Form::label("settings.menu_title_color", "Başlık Rengi".':') !!}
                                {!! Form::input('text', 'settings[menu_title_color]', !isset($page->settings->menu_title_color) ? '' : $page->settings->menu_title_color, ['class'=>'form-control colorpicker']) !!}
                                {!! $errors->first("settings.menu_title_color", '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group{{ $errors->has("settings.menu_bg_color") ? ' has-error' : '' }}">
                                {!! Form::label("settings.menu_bg_color", "Başlık Arkaplan".':') !!}
                                {!! Form::input('text', 'settings[menu_bg_color]', !isset($page->settings->menu_bg_color) ? '' : $page->settings->menu_bg_color, ['class'=>'form-control colorpicker']) !!}
                                {!! $errors->first("settings.menu_bg_color", '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group{{ $errors->has("settings.menu_border_color") ? ' has-error' : '' }}">
                                {!! Form::label("settings.menu_border_color", "Kenarlık Rengi".':') !!}
                                {!! Form::input('text', 'settings[menu_border_color]', !isset($page->settings->menu_border_color) ? '' : $page->settings->menu_border_color, ['class'=>'form-control colorpicker']) !!}
                                {!! $errors->first("settings.menu_border_color", '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group{{ $errors->has("settings.menu_text_bg_color") ? ' has-error' : '' }}">
                                {!! Form::label("settings.menu_text_bg_color", "Arkaplan Rengi".':') !!}
                                {!! Form::input('text', 'settings[menu_text_bg_color]', !isset($page->settings->menu_text_bg_color) ? '' : $page->settings->menu_text_bg_color, ['class'=>'form-control colorpicker']) !!}
                                {!! $errors->first("settings.menu_text_bg_color", '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group{{ $errors->has("settings.menu_text_color") ? ' has-error' : '' }}">
                                {!! Form::label("settings.menu_text_color", "Yazı Rengi".':') !!}
                                {!! Form::input('text', 'settings[menu_text_color]', !isset($page->settings->menu_text_color) ? '' : $page->settings->menu_text_color, ['class'=>'form-control colorpicker']) !!}
                                {!! $errors->first("settings.menu_text_color", '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group{{ $errors->has("settings.menu_text_hover") ? ' has-error' : '' }}">
                                {!! Form::label("settings.menu_text_hover", "Yazı Rengi Efekti".':') !!}
                                {!! Form::input('text', 'settings[menu_text_hover]', !isset($page->settings->menu_text_hover) ? '' : $page->settings->menu_text_hover, ['class'=>'form-control colorpicker']) !!}
                                {!! $errors->first("settings.menu_text_hover", '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    {!! Form::normalSelect("settings[show_sidebar]", "Menüde Göster", $errors, [0=>'Hayır', 1=>'Evet'], isset($page->settings->show_sidebar) ? $page->settings->show_sidebar : 0) !!}
                </div>
            </div>
        </div>
    </fieldset>
</div>