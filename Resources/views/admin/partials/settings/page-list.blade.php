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
                        {!! Form::checkbox("settings[list_page_content]", 1, old('settings.list_page_content', isset($page->settings->list_page_content) ? $page->settings->list_page_content : 0), ['class'=>'flat-blue']) !!}
                        &nbsp; İçeriği Göster
                    </label>
                </div>
                <div class="form-group">
                    <label>
                        {!! Form::checkbox("settings[list_page_image]", 1, old('settings.list_page_image', isset($page->settings->list_page_image) ? $page->settings->list_page_image : 0), ['class'=>'flat-blue']) !!}
                        &nbsp; Resim Göster
                    </label>
                </div>
                <div class="form-group">
                    <label>
                        {!! Form::checkbox("settings[list_page_button]", 1, old('settings.list_page_button', isset($page->settings->list_page_button) ? $page->settings->list_page_button : 0), ['class'=>'flat-blue']) !!}
                        &nbsp; İncele Butonu
                    </label>
                </div>
            </div>
        </div>
    </fieldset>
</div>