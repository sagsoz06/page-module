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

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary btn-flat">{{ trans('core::core.button.create') }}</button>
                        <button class="btn btn-default btn-flat" name="button" type="reset">{{ trans('core::core.button.reset') }}</button>
                        <a class="btn btn-danger pull-right btn-flat" href="{{ URL::route('admin.page.page.index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
                    </div>
                </div>
            </div> {{-- end nav-tabs-custom --}}
        </div>
        <div class="col-md-2">
            @includeIf('page::admin.partials.settings-fields')
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
                        {!! Form::select("template", $all_templates, old("template", 'default'), ['class' => "form-control select2", 'placeholder' => trans('page::pages.form.template')]) !!}
                        {!! $errors->first("template", '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label("menu", trans('page::pages.form.menu')) !!}
                        {!! Form::select('menu[]', $menuLists, old("menu"), ['class'=>'form-control select2', 'multiple'=>'multiple']) !!}
                        {!! $errors->first("menu", '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group" style="margin-right: 10px;">
                        <label>
                            {!! Form::checkbox("settings[update_menu]", 1, old('settings.update_menu'), ['class'=>'flat-blue']) !!}
                            &nbsp; Menü Başlığı Güncelle
                        </label>
                    </div>
                    @if($currentUser->hasAccess('page.pages.permission'))
                        <div class="form-group">
                            {!! Form::label("permissions", trans('page::pages.form.permissions')) !!}
                            {!! Form::select('permissions[]', $permissions, [], ['class'=>'form-control select2', 'multiple'=>'multiple']) !!}
                            {!! $errors->first("permissions", '<span class="help-block">:message</span>') !!}
                        </div>
                    @endif
                    @tags('asgardcms/page')
                </div>
            </div>
            @if($currentUser->hasAccess('page.pages.sitemap'))
                @includeIf('sitemap::admin.partials.robots')
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
