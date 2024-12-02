<!-- BEGIN: Content-->

<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Ro'yxat</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/account/main_page/list">Asosiy menyu</a>
                                </li>
                                <li class="breadcrumb-item active">Ro'yxat
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <!-- Responsive Datatable -->
            <section id="responsive-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h4 class="card-title">Adminlar ro'yhati</h4>
                                <div class="dt-action-buttons bt-right">
                                    <div class="dt-buttons d-inline-flex">
                                        <button class="dt-button create-new btn btn-primary mr-1 mg-right" type="button" data-toggle="modal" onclick="add_modal()">Yangi qo'shish</button>
                                        <?/*
                                        <button class="dt-button create-new btn btn-warning btn-icon" type="button" data-toggle="modal" data-target="#filter"><i data-feather="filter"></i></button>
                                        */?>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive" id="table">
                                    <table class="display" id="basic-1">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Kod</th>
                                                <th>Ism</th>
                                                <th>Telefon</th>
                                                <th>Harakat</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <? foreach(db::arr("SELECT * FROM ac_adminka WHERE ACTIVE = 1") as $v): ?>
                                            <tr>
                                                <td class="short-td"><?=$v['ID']?></td>
                                                <td><?=$v['CODE']?></td>
                                                <td><?=$v['NAME']?></td>
                                                <td><?=$v['PHONE']?></td>
                                                <td>
                                                    <a href="/account/adminka/detail/<?=$v['ID']?>" target="_blank">
                                                    <button class="btn btn-primary" type="button"><span class="fa fa-chevron-right"></span></button>
                                                    </a>
                                                    <button class="btn btn-success" onclick="edit_modal('<?= $v['ID']; ?>')" type="button"><span class="fa fa-pencil"></span></button>
                                                    <button class="btn btn-danger" onclick="delete_modal('<?= $v['ID']; ?>')" type="button"><span class="fa fa-trash"></span></button>
                                                </td>
                                            </tr>
                                            <? endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<style>
    .short-td{
        max-width: 110px;
        width: 60px;
    }

    .short-text {
        width: 1000px;
    }

    .mg-right {
        margin-right: 6px;
    }

    .bt-right {
        float: right;
    }

    .custom-img {
        max-width: auto;
        max-height: auto;
    }
</style>
<? require "modules/viho/adminka/adminka_js.php"; ?>
<? require "modules/viho/adminka/adminka_modal.php"; ?>