
<div class="row">
    <fieldset style="padding: 0 20px;">
        <legend>Gösterim Ayarları</legend>
        <div class="row">
            <div class="col-md-12 form-inline">
                <div class="form-group" style="margin-right: 10px;">
                    <label>
                        {!! Form::checkbox("settings[show_cover]", 1, old('settings.show_cover', isset($page->settings->show_cover) ? $page->settings->show_cover : null), ['class'=>'flat-blue']) !!}
                        &nbsp; Kapak Resmi Göster
                    </label>
                </div>
                <div class="form-group" style="margin-right: 10px;">
                    <label>
                        {!! Form::checkbox("settings[show_image]", 1, old('settings.show_image', isset($page->settings->show_image) ? $page->settings->show_image : null), ['class'=>'flat-blue']) !!}
                        &nbsp; Resim Göster
                    </label>
                </div>
                <div class="form-group" style="margin-right: 10px;">
                    <label>
                        {!! Form::checkbox("settings[show_gallery]", 1, old('settings.show_gallery', isset($page->settings->show_gallery) ? $page->settings->show_gallery : null), ['class'=>'flat-blue']) !!}
                        &nbsp; Resimleri Galeri olarak göster
                    </label>
                </div>
            </div><br/>
            <hr/>
            <div class="col-md-12 form-inline">
                <div class="form-group">
                    <span style="margin-right: 10px;"><strong>Resim Pozisyonu</strong></span>
                    @foreach([null=>'Seçiniz', 'left'=>'Sol', 'right'=>'Sağ', 'top'=>'Üst', 'bottom'=>'Aşağı'] as $key => $val)
                        <div class="radio-inline">
                            <label>
                                {!! Form::radio('settings[image_position]', $key, $key == @$page->settings->image_position ?? $loop->first) !!}
                                {{ $val }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div><br/>
            <hr/>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group{{ $errors->has("settings.image_width") ? ' has-error' : '' }}">
                            {!! Form::input('text', 'settings[image_width]', !isset($page->settings->image_width) ? 400 : $page->settings->image_width, ['class'=>'form-control', 'placeholder'=>'Resim Genişliği']) !!}
                            {!! $errors->first("settings.image_width", '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group{{ $errors->has("settings.image_height") ? ' has-error' : '' }}">
                            {!! Form::input('text', 'settings[image_height]', !isset($page->settings->image_height) ? null : $page->settings->image_height, ['class'=>'form-control', 'placeholder'=>'Resim Yüksekliği']) !!}
                            {!! $errors->first("settings.image_height", '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                    <div class="col-md-3">
                        {!! Form::select('settings[image_mode]', [null=>'Varsayılan', 'fit'=>'Kırp', 'resize'=>'Ölçeklendir'],!isset($page->settings->image_mode) ? '' : $page->settings->image_mode, ['class'=>'form-control']) !!}
                        {!! $errors->first("settings.image_mode", '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="col-md-3">
                        {!! Form::select('settings[image_quality]', array_combine(range(10,100,10), range(10,100,10)), !isset($page->settings->image_quality) ? 70 : $page->settings->image_quality, ['class'=>'form-control']) !!}
                        {!! $errors->first("settings.image_quality", '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
</div>
<br/>
<div class="row">
    <fieldset style="padding: 0 20px;">
        <legend>Resim Ekleme</legend>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    @mediaSingle('pageCover', isset($page) ? $page : null, null, trans('page::pages.form.cover'))
                </div>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    @mediaMultiple('pageImage', isset($page) ? $page : null, null, trans('page::pages.form.image'))
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    @mediaMultiple('pageFiles', isset($page) ? $page : null, null, trans('page::pages.form.file'))
                </div>
            </div>
        </div>
    </fieldset>
</div>