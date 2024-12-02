<?

$_SESSION['item_id'] = $_GET['item_id'];

$user_id = $_SESSION['item_id'];

$range = explode(" ", $_SESSION['date_range']);

if($_SESSION['date_range'] != null){

$data = "AND (DATE BETWEEN '$range[0]' AND '$range[2]')";

}else{

$data = '';

}

$employee = db::arr_by_id("SELECT * FROM gl_sys_users WHERE ID = '$user_id' AND STATUS = '1'");

$select_rasxod = db::arr("SELECT * FROM ac_expense WHERE EMPLOYEE_ID = '$user_id' $data AND ACTIVE = '1'");

$rasxod = db::arr_s("SELECT SUM(AMOUNT) AS AMOUNT FROM ac_expense WHERE EMPLOYEE_ID = '$user_id' $data AND ACTIVE = '1'");
?>

<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Xarajatlar</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/account/main_page/list">Asosiy menyu</a>
                                </li>
                                <li class="breadcrumb-item active">Xarajatlar ro'yxati
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
        <? //echo '<pre>'; print_r($user_id); echo '</pre>'; ?>
            <div class="row">
                <div class="col-sm-6">
                    <div class="card ecommerce-widget pro-gress">
                        <div class="card-body support-ticket-font">
                            <div class="row">
                                <div class="col-5">
                                    <h6>Umumiy xarajat: </h6>
                                    <h4 class="total-num"><?= $rasxod['AMOUNT'] ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Responsive Datatable -->
            <section id="responsive-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h4 class="card-title">Xarajatlar ro'yhati</h4>
                                <div class="dt-action-buttons bt-right">
                                    <div class="dt-buttons d-inline-flex">
                                        <button class="dt-button create-new btn btn-primary mr-1 mg-right" type="button" data-toggle="modal" onclick="add_expence()">Yangi qo'shish</button>
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
                                                <th>Ism</th>
                                                <th>Xarajat</th>
                                                <th>Izoh</th>
                                                <th>Data</th>
                                                <th>Harakat</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <? foreach ($select_rasxod as $v): ?>
                                                <tr>
                                                    <td class="short-td"><?= $v['ID'] ?></td>
                                                    <td><?= $employee[$v['EMPLOYEE_ID']]['NAME'] ?></td>
                                                    <td><?= $v['AMOUNT'] ?></td>
                                                    <td><?= $v['COMMENT'] ?></td>
                                                    <td><?= $v['DATE'] ?></td>
                                                    <td>
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
    .mg-right {
        margin-right: 6px;
    }

    .bt-right {
        float: right;
    }

    .input-container {
        max-width: 400px;
    }

    .input-container input {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        box-sizing: border-box;
    }
</style>
<? require "modules/viho/employee/employee_js.php"; ?>
<? require "modules/viho/employee/employee_detail_modal.php"; ?>