<!-- BEGIN: Content-->
<?
$order_type = $_SESSION['yandex_type'];

if($order_type == 'taken'){

$data = "AND zakaz.TAKEN = 1 AND zakaz.PAID = 1";

}elseif($order_type == 'all'){

$data = 'AND zakaz.TAKEN IN (1, 0) AND zakaz.PAID = 1';
}else{

$data = 'AND zakaz.TAKEN = 0 AND zakaz.PAID = 1';
}

$delivery = db::arr("SELECT
loc.ID, 
loc.CREATED_DATE AS `TIME`,
user.CODE AS CODE,
user.ISM_FAMILIYA AS `NAME`,
user.PHONE AS PHONE,
zakaz.ID AS ORDER_ID,
zakaz.WEIGHT AS `WEIGHT`,
zakaz.SHELF AS `SHELF`
FROM ac_location AS loc
LEFT JOIN tg_users AS user ON user.CHAT_ID = loc.CHAT_ID
LEFT JOIN ac_zakaz AS zakaz ON zakaz.ID = loc.ORDER_ID
WHERE zakaz.PAYMENT_TYPE IS NOT NULL 
$data 
AND loc.TYPE = 'yandex' AND loc.ACTIVE = '1'");

?>


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
                                <h4 class="card-title">Lokatsiyalar ro'yxati</h4>
                                <div class="dt-action-buttons bt-right">
                                    <div class="dt-buttons d-inline-flex">
                                        <button type="button" class="btn btn-outline-primary-2x" data-bs-toggle="modal" data-original-title="test" onclick="filterModal()"><i class="fa fa-filter"></i> Filter qilish</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive" id="table">
                                    <table class="display" id="basic-1">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Klient kod</th>
                                                <th>Mijoz ismi</th>
                                                <th>Sana</th>
                                                <th>Telefon</th>
                                                <th>Og'irligi</th>
                                                <th>Polkasi</th>
                                                <th>Harakat</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <? foreach ($delivery as $v): ?>
                                                <tr>
                                                    <td class="short-td"><?= $v['ID'] ?></td>
                                                    <td><?= $v['CODE'] ?></td>
                                                    <td><?= $v['NAME'] ?></td>
                                                    <td><?= $v['TIME'] ?></td>
                                                    <td><?= $v['PHONE'] ?></td>
                                                    <td><?= $v['WEIGHT'] ?></td>
                                                    <td><?= $v['SHELF'] ?></td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary" onclick="shippedYandexModal('<?= $v['ORDER_ID'] ?>')">
                                                            <span class="fa fa-truck"></span>
                                                        </button>
                                                        <button type="button" class="btn btn-primary" onclick="infoYandexModal('<?= $v['ORDER_ID'] ?>')"><span class="fa fa-file-text"></span></button>
                                                        <button type="button" class="btn btn-primary" onclick="deleteModal('<?=$v['ID']?>')"><span class="fa fa-trash"></span></button>
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
    .short-td {
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

<? require "modules/viho/yandex_dostavka/yandex_dostavka_js.php"; ?>
<? require "modules/viho/yandex_dostavka/yandex_dostavka_modal.php"; ?>