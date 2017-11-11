<div class="form-group" style="margin-right: 10px;">
    <label>
        {!! Form::checkbox("settings[image_gallery]", 1, old('settings.image_gallery', isset($page->settings->image_gallery) ? $page->settings->image_gallery : 0), ['class'=>'flat-blue']) !!}
        &nbsp; Resimleri Galeri olarak göster
    </label>
</div>
<div class="form-group">
    @mediaMultiple('pageImage', isset($page) ? $page : null, null, trans('page::pages.form.image'))
</div>
<div class="form-group">
    @mediaSingle('pageCover', isset($page) ? $page : null, null, trans('page::pages.form.cover'))
</div>