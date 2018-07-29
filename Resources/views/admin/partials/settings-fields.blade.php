<button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modal-settings">
    <i class="fa fa-cog"></i> Sayfa Ayarları
</button>
<div class="modal fade" id="modal-settings">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Sayfa Ayarları</h4>
            </div>
            <div class="modal-body">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#home-box" data-toggle="tab">Anasayfa</a></li>
                        <li><a href="#title" data-toggle="tab">Başlık</a></li>
                        <li><a href="#page" data-toggle="tab">Sayfa</a></li>
                        <li><a href="#images" data-toggle="tab">Resim & Dosya</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="home-box">
                            @include('page::admin.partials.settings.home')
                        </div>
                        <div class="tab-pane" id="title">
                            @include('page::admin.partials.settings.title')
                        </div>
                        <div class="tab-pane" id="page">
                            @include('page::admin.partials.settings.page')
                        </div>
                        <div class="tab-pane" id="images">
                            @include('page::admin.partials.settings.image')
                        </div>
                    </div>
                 </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary pull-left" data-dismiss="modal">KAYDET VE KAPAT</button>
            </div>
        </div>
    </div>
</div>

@push('js-stack')
    <script>
        $(function () {
            $('.colorpicker').colorpicker();
        });
    </script>
@endpush

@push('css-stack')
<style>
    .modal-header {
        background: #3c8dbc;
        color: #ffffff;
    }

    .modal-footer {
        background: #ececec;
    }

    #modal-settings legend {
        padding: 5px 20px;
        background: #ebebeb;
        font-size: 14px;
        font-weight: bold;
    }
    .btn-block {
        margin-bottom: 10px;
    }
</style>
@endpush