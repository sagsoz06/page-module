@extends('layouts.master')

@push('css-stack')
    <link href="{!! Module::asset('page:css/nestable.css') !!}" rel="stylesheet" type="text/css"/>
@endpush

@section('content-header')
    <h1>
        {{ trans('page::pages.title.pages') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ URL::route('dashboard.index') }}"><i
                        class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('page::pages.title.pages') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ URL::route('admin.page.page.create') }}" class="btn btn-primary btn-flat"
                       style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> {{ trans('page::pages.button.create page') }}
                    </a>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header">
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                {!! $pageStructure !!}
                <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </div>
    @include('core::partials.delete-modal')
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>c</code></dt>
        <dd>{{ trans('page::pages.title.create page') }}</dd>
    </dl>
@stop

@push('js-stack')
    <script src="{!! Module::asset('page:js/jquery.nestable.js') !!}"></script>
    {!! Theme::style('vendor/sweetalert/dist/sweetalert.css') !!}
    {!! Theme::script('vendor/sweetalert/dist/sweetalert.min.js') !!}
    <script>
        $(document).ready(function () {
            $('.dd').nestable({
                collapsedClass: 'dd-collapsed'
            }).nestable('collapseAll');
            $('.dd').on('change', function () {
                var data = $('.dd').nestable('serialize');
                $.ajax({
                    type: 'POST',
                    url: '{{ route('api.page.update') }}',
                    data: {'page': JSON.stringify(data), '_token': '<?php echo csrf_token(); ?>'},
                    dataType: 'json',
                    success: function (data) {

                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('.jsDeleteMenuItem').on('click', function (e) {
                var self = $(this), pageId = self.data('item-id');
                swal({
                    title: "{{ trans('core::core.modal.confirmation-message') }}",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#DD6B55',
                    confirmButtonText: '{{ trans('core::core.button.delete') }}',
                    cancelButtonText: '{{ trans('core::core.button.cancel') }}',
                    closeOnConfirm: true
                },
                function () {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('api.page.delete') }}',
                        data: {
                            _token: '{{ csrf_token() }}',
                            pageId: pageId
                        },
                        success: function (data) {
                            if (!data.errors) {
                                var elem = self.closest('li');
                                elem.fadeOut();
                                setTimeout(function () {
                                    elem.remove()
                                }, 300);
                            }
                        },
                        error: function (xhr, status, response) {
                            var error = jQuery.parseJSON(xhr.responseText);
                            var errorMessages = '';
                            $.each(error.messages, function(key, value) {
                                errorMessages += value+"\n";
                            });

                            swal("{{ trans('global.error') }}", errorMessages, "error");
                        }
                    });
                });
            });
        });
    </script>
    <?php $locale = App::getLocale(); ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $(document).keypressAction({
                actions: [
                    {key: 'c', route: "<?= route('admin.page.page.create') ?>"}
                ]
            });
        });
    </script>
@endpush
