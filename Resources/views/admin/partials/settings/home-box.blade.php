<div class="row">
    <fieldset>
        <legend>Anasayfa Başlık Ayarları</legend>
        <div class="col-md-3">
            {!! Form::normalSelect("settings[show_box]", "Kutu da gösterilsin mi?", $errors, [0=>'Hayır', 1=>'Evet'], isset($page->settings->show_box) ? $page->settings->show_box : 0) !!}
        </div>
        <div class="col-md-3">
            {!! Form::normalSelect("settings[column_box]", "Kutu boyutu", $errors, array(''=>'Seçiniz') + array_combine(range(1, 12, 1), range(1, 12, 1)), isset($page->settings->column_box) ? $page->settings->column_box : 4) !!}
        </div>
    </fieldset>
</div>