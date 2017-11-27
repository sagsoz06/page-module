<div class="row">
    <fieldset>
        <legend>Sayfa Listeleme Ayarları</legend>
        <div class="col-md-3">
            {!! Form::normalSelect("settings[list_page]", "Alt Sayfaları göster", $errors, [0=>'Hayır', 1=>'Evet'], isset($page->settings->list_page) ? $page->settings->list_page : 0) !!}
        </div>
        <div class="col-md-3">
            {!! Form::normalSelect("settings[list_per_page]", "Sayfalama", $errors, array(''=>'Seçiniz') + array_combine(range(1, 20, 1), range(1, 20, 1)), isset($page->settings->list_per_page) ? $page->settings->list_per_page : 6) !!}
        </div>
        <div class="col-md-3">
            {!! Form::normalSelect("settings[list_type]", "Liste Türü", $errors, ['grid'=>'Grid', 'list'=>'Liste'], isset($page->settings->list_type) ? $page->settings->list_type : 6) !!}
        </div>
        <div class="col-md-3">
            {!! Form::normalSelect("settings[list_grid]", "Grid", $errors, array(''=>'Seçiniz') + array_combine(range(1, 12, 1), range(1, 12, 1)), isset($page->settings->list_grid) ? $page->settings->list_grid : 6) !!}
        </div>
    </fieldset>
</div>
<div class="row">
    <fieldset>
        <legend>Gösterim Ayarları</legend>
        <div class="row">
            <div class="col-md-12 form-inline">
                <div class="form-group" style="margin-right: 10px;">
                    <label>
                        {!! Form::checkbox("settings[cover_image]", 1, old('settings.cover_image', isset($page->settings->cover_image) ? $page->settings->cover_image : 0), ['class'=>'flat-blue']) !!}
                        &nbsp; Kapak Resmi Göster
                    </label>
                </div>
                <div class="form-group" style="margin-right: 10px;">
                    <label>
                        {!! Form::checkbox("settings[page_body]", 1, old('settings.page_body', isset($page->settings->page_body) ? $page->settings->page_body : 0), ['class'=>'flat-blue']) !!}
                        &nbsp; Sayfa İçeriği Göster
                    </label>
                </div>
                <div class="form-group" style="margin-right: 10px;">
                    <label>
                        {!! Form::checkbox("settings[list_page_content]", 1, old('settings.list_page_content', isset($page->settings->list_page_content) ? $page->settings->list_page_content : 0), ['class'=>'flat-blue']) !!}
                        &nbsp; Alt Sayfa İçeriği Göster
                    </label>
                </div>
                <div class="form-group" style="margin-right: 10px;">
                    <label>
                        {!! Form::checkbox("settings[list_page_image]", 1, old('settings.list_page_image', isset($page->settings->list_page_image) ? $page->settings->list_page_image : 0), ['class'=>'flat-blue']) !!}
                        &nbsp; Resim Göster
                    </label>
                </div>
                <div class="form-group" style="margin-right: 10px;">
                    <label>
                        {!! Form::checkbox("settings[list_page_button]", 1, old('settings.list_page_button', isset($page->settings->list_page_button) ? $page->settings->list_page_button : 0), ['class'=>'flat-blue']) !!}
                        &nbsp; İncele Butonu
                    </label>
                </div>
                <div class="form-group" style="margin-right: 10px;">
                    <label>
                        {!! Form::checkbox("settings[show_logo]", 1, old('settings.show_logo', isset($page->settings->show_logo) ? $page->settings->show_logo : 0), ['class'=>'flat-blue']) !!}
                        &nbsp; Logo
                    </label>
                </div>
            </div>
        </div>
    </fieldset>
</div>
<br/>
<div class="row">
    <fieldset>
        <legend>Sayfa Ayarları</legend>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group{{ $errors->has("settings.password") ? ' has-error' : '' }}">
                    {!! Form::label("settings.title_bg_color", "Sayfa Şifrele".':') !!}
                    {!! Form::input('text', 'settings[password]', !isset($page->settings->password) ? '' : $page->settings->password, ['class'=>'form-control']) !!}
                    {!! $errors->first("settings.password", '<span class="help-block">:message</span>') !!}
                </div>
            </div>
        </div>
    </fieldset>
</div>