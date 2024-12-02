<? 

$role = db::arr_by_id("SELECT * FROM gl_sys_roles");
?>
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Xodimlar</h2>
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
                                <h4 class="card-title">Xodimlar ro'yhati</h4>
                                <div class="dt-action-buttons bt-right">
                                    <div class="dt-buttons d-inline-flex">
                                        <button class="dt-button create-new btn btn-primary mr-1 mg-right" type="button" data-toggle="modal" onclick="add_modal()">Yangi qo'shish</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive" id="table">
                                    <table class="display" id="basic-1">
                                        <thead>
                                            <?  //echo '<pre>'; print_r($role); echo '</pre>'; ?>
                                            <tr>
                                                <th>ID</th>
                                                <th>Ism</th>
                                                <th>Login</th>
                                                <th>Telefon</th>
                                                <th>Rol</th>
                                                <th>Harakat</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <? foreach(db::arr("SELECT * FROM gl_sys_users WHERE STATUS = 1") as $v): ?>       
                                            <tr>
                                                <td class="short-td"><?=$v['ID']?></td>
                                                <td><?=$v['NAME']?></td>
                                                <td><?=$v['LOGIN']?></td>
                                                <td><?=$v['PHONE']?></td>
                                                <td><?=$role[$v['ROLE_ID']]['NAME']?></td>
                                                <td>
                                                    <a href="/account/employee/detail/<?=$v['ID']?>" target="_blank">
                                                        <button class="btn btn-primary" type="button"><span class="fa fa-chevron-right"></span></button>
                                                    </a>
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

</style>
<? require "modules/viho/employee/employee_js.php"; ?>
<? require "modules/viho/employee/employee_modal.php"; ?>