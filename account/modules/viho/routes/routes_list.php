<!-- BEGIN: Content-->
<?


$route = db::arr("SELECT 
acm.ID AS MARSHRUT_ID,
acm.DISTRICT_ID,
user.LOGIN,
rayon.NAME_UZ AS RAYON,
acm.CREATED_DATE AS `DATE`,
loc.STATUS
FROM ac_marshrut AS acm
LEFT JOIN ac_rayon AS rayon ON rayon.ID = acm.DISTRICT_ID
LEFT JOIN ac_location AS loc ON loc.ID = acm.LOCATION_ID
LEFT JOIN gl_sys_users AS user ON user.ID = acm.EMPLOYEE_ID
WHERE acm.ACTIVE = 1");

//$status = ['new' => ""]
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
                        <? //echo '<pre>'; print_r($route); echo '</pre>'; ?>
                            <div class="card-header border-bottom">
                                <h4 class="card-title">Marshrutlar ro'yxati</h4>
                                <div class="dt-action-buttons bt-right">
                                    <div class="dt-buttons d-inline-flex">
                                        <button class="dt-button create-new btn btn-primary mr-1 mg-right" type="button" data-toggle="modal" onclick="add_modal()">Yangi qo'shish</button>
                                        <button type="button" class="btn btn-outline-primary-2x" data-bs-toggle="modal" data-original-title="test" onclick="filterModal()"><i class="fa fa-filter"></i>	Filter qilish</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive" id="table">
                                    <table class="display" id="basic-1">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Sana</th>
                                                <th>Xodim</th>
                                                <th>Tuman</th>
                                                <th>Harakat</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <? if($route != 'empty'): ?>
                                            <? foreach ($route as $v): ?>
                                                <tr>
                                                    <td class="short-td"><?= $v['MARSHRUT_ID'] ?></td>
                                                    <td><?= $v['DATE'] ?></td>
                                                    <td><?= $v['LOGIN'] ?></td>
                                                    <td><?= $v['RAYON'] ?></td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary" onclick="shippedModal('<?= $v['ORDER_ID'] ?>')">
                                                            <span class="fa fa-truck"></span>
                                                        </button>
                                                        <a href="/account/routes/detail/<?=$v['DISTRICT_ID']?>" target="_blank">
                                                            <button class="btn btn-primary" type="button"><span class="fa fa-chevron-right"></span></button>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <? endforeach; ?>
                                            <? endif; ?>
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

<? require "modules/viho/routes/routes_js.php"; ?>
<? require "modules/viho/routes/routes_modal.php"; ?>