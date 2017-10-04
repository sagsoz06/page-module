<button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modal-settings">
    <i class="fa fa-cog"></i> Sayfa Ayarları
</button>
<div class="modal modal-info fade" id="modal-settings">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Sayfa Ayarları</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <fieldset>
                        <legend>Başlık Ayarları</legend>
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
                    </fieldset>
                </div>
                <div class="row">
                    <fieldset>
                        <legend>Alt Menü Ayarları</legend>
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
                    </fieldset>
                </div>
                <div class="row">
                    <fieldset>
                        <legend>Anasayfa Başlık Ayarları</legend>
                        <div class="col-md-3">
                            {!! Form::normalSelect("settings[show_box]", "Kutu da gösterilsin mi?", $errors, [0=>'Hayır', 1=>'Evet'], isset($page->settings->show_box) ? $page->settings->show_box : 0) !!}
                        </div>
                        <div class="col-md-3">
                            {!! Form::normalSelect("settings[column_box]", "Kutu boyutu", $errors, array(''=>'Seçiniz') + array_combine(range(2, 12, 2), range(2, 12, 2)), isset($page->settings->column_box) ? $page->settings->column_box : 4) !!}
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">KAYDET VE KAPAT</button>
            </div>
        </div>
    </div>
</div>

@push('js-stack')
<script>
    jQuery(document).ready(function () {
        $('.colorpicker').colorpicker();
    });
</script>
@endpush

@push('css-stack')
<style>
    #modal-settings legend {
        padding: 0 20px;
        color: #FFFFFF;
        font-size: 14px;
        font-weight: bold;
    }
    .btn-block {
        margin-bottom: 10px;
    }
</style>
@endpush