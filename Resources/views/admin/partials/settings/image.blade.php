@mediaMultiple('pageImage', isset($page) ? $page : null, null, trans('page::pages.form.image'))
<hr/>
@mediaSingle('pageCover', isset($page) ? $page : null, null, trans('page::pages.form.cover'))