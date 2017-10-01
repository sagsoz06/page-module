@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('page::pages.title.create page') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ URL::route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ URL::route('admin.page.page.index') }}">{{ trans('page::pages.title.pages') }}</a></li>
        <li class="active">{{ trans('page::pages.title.create page') }}</li>
    </ol>
@stop

@section('styles')
    <style>
        .checkbox label {
            padding-left: 0;
        }
    </style>
@stop

@section('content')
    {!! Form::open(['route' => ['admin.page.page.store'], 'method' => 'post']) !!}
    <div class="row">
        <div class="col-md-10">
            <div class="nav-tabs-custom">
                @include('partials.form-tab-headers', ['fields' => ['title', 'body']])
                <div class="tab-content">
                    <?php $i = 0; ?>
                    <?php foreach (LaravelLocalization::getSupportedLocales() as $locale => $language): ?>
                    <?php ++$i; ?>
                    <div class="tab-pane {{ App::getLocale() == $locale ? 'active' : '' }}" id="tab_{{ $i }}">
                        @include('page::admin.partials.create-fields', ['lang' => $locale])
                    </div>
                    <?php endforeach; ?>

                    <?php if (config('asgard.page.config.partials.normal.create') !== []): ?>
                    <?php foreach (config('asgard.page.config.partials.normal.create') as $partial): ?>
                    @include($partial)
                    <?php endforeach; ?>
                    <?php endif; ?>


                    <div class="box-body">
                        {!! Form::normalInput('video', trans('page::pages.form.video'), $errors) !!}
                    </div>

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary btn-flat">{{ trans('core::core.button.create') }}</button>
                        <button class="btn btn-default btn-flat" name="button" type="reset">{{ trans('core::core.button.reset') }}</button>
                        <a class="btn btn-danger pull-right btn-flat" href="{{ URL::route('admin.page.page.index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
                    </div>
                </div>
            </div> {{-- end nav-tabs-custom --}}
        </div>
        <div class="col-md-2">
            <div class="box box-primary">
                <div class="box-body">
                    <div class="checkbox{{ $errors->has('is_home') ? ' has-error' : '' }}">
                        <input type="hidden" name="is_home" value="0">
                        <label for="is_home">
                            <input id="is_home"
                                   name="is_home"
                                   type="checkbox"
                                   class="flat-blue"
                                   value="1" />
                            {{ trans('page::pages.form.is homepage') }}
                            {!! $errors->first('is_home', '<span class="help-block">:message</span>') !!}
                        </label>
                    </div>
                    <div class="form-group">
                        {!! Form::label("parent_id", trans('page::pages.form.parent_id')) !!}
                        {!! Form::select('parent_id', $selectPages, old("parent_id"), ['class'=>'form-control select2']) !!}
                        {!! $errors->first("parent_id", '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class='form-group{{ $errors->has("template") ? ' has-error' : '' }}'>
                        {!! Form::label("template", trans('page::pages.form.template')) !!}
                        {!! Form::select("template", $all_templates, old("template", 'default'), ['class' => "form-control", 'placeholder' => trans('page::pages.form.template')]) !!}
                        {!! $errors->first("template", '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label("menu", trans('page::pages.form.menu')) !!}
                        {!! Form::select('menu[]', $menuLists, old("menu"), ['class'=>'form-control select2', 'multiple'=>'multiple']) !!}
                        {!! $errors->first("menu", '<span class="help-block">:message</span>') !!}
                    </div>
                    {!! Form::normalInput('icon', trans('page::pages.form.icon'), $errors) !!}
                    @tags('asgardcms/page')
                    @mediaMultiple('pageImage', null, null, trans('page::pages.form.image'))
                    @mediaSingle('pageCover', null, null, trans('page::pages.form.cover'))
                </div>
            </div>
            @if(Authentication::hasAccess('page.pages.sitemap'))
                <div class="box box-primary">
                    <div class="box-body">
                        <div class='form-group{{ $errors->has("meta_robot_no_index") ? ' has-error' : '' }}'>
                            {!! Form::checkbox("meta_robot_no_index", 'noindex', old("meta_robot_no_index"), ['class' => 'flat-blue']) !!}
                            {!! Form::label("meta_robot_no_index", trans('page::pages.form.meta_robot_no_index')) !!}
                            {!! $errors->first("meta_robot_no_index", '<span class="help-block">:message</span>') !!}
                            <br/>
                            {!! Form::checkbox("meta_robot_no_follow", 'nofollow', old("meta_robot_no_follow"), ['class' => 'flat-blue']) !!}
                            {!! Form::label("meta_robot_no_follow", trans('page::pages.form.meta_robot_no_follow')) !!}
                            {!! $errors->first("meta_robot_no_follow", '<span class="help-block">:message</span>') !!}
                            <br/>
                            {!! Form::checkbox("sitemap_include", '1', old("sitemap_include", 1), ['class' => 'flat-blue']) !!}
                            {!! Form::label("sitemap_include", trans('core::sitemap.title.include')) !!}
                            {!! $errors->first("sitemap_include", '<span class="help-block">:message</span>') !!}
                        </div>
                        <div class="form-group">
                            {!! Form::normalSelect('sitemap_frequency', trans('core::sitemap.title.frequency'), $errors, $sitemapFrequencies, 'weekly') !!}
                        </div>
                        <div class="form-group">
                            {!! Form::normalSelect('sitemap_priority', trans('core::sitemap.title.priority'), $errors, $sitemapPriorities, '0.9') !!}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {!! Form::close() !!}
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>b</code></dt>
        <dd>{{ trans('page::pages.navigation.back to index') }}</dd>
    </dl>
@stop

@push('js-stack')
<script>
    $( document ).ready(function() {
        $(document).keypressAction({
            actions: [
                { key: 'b', route: "<?= route('admin.page.page.index') ?>" }
            ]
        });
        $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
            checkboxClass: 'icheckbox_flat-blue',
            radioClass: 'iradio_flat-blue'
        });
        $('.select2').select2();
    });
</script>
@endpush
