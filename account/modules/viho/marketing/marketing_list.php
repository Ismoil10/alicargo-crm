<!-- BEGIN: Content-->

<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-lg-6">
                        <h2 class="content-header-title float-left mb-0">Marketing</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/account/main_page/list">Asosiy menyu</a>
                                </li>
                                <li class="breadcrumb-item active">Qo'shilgan foydalanuvchilar
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <!-- Bookmark Start-->
                <div class="bookmark">
                    <ul>

                        <li style="padding-right: 40px"><a href="https://t.me/alicargo_bot"><i class="bookmark-search" data-feather="at-sign"></i>alicargo_bot</a>

                        </li>
                    </ul>
                </div>
                <!-- Bookmark Ends-->
            </div>
        </div>
        <script>
            $('document').ready(function() {

                show_user_content = function(page_num, date, network) {

                    date = $('[name=date_filter]').val();
                    network = $('[name=network]').val();

                    var formData = new FormData();
                    formData.append('time', date);
                    formData.append('network', network);
                    formData.append('page_num', page_num);

                    js_ajax_post('marketing/marketing_table.php', formData).done(function(data) {
                        $('.user_list_content').html(data);
                    });
                }

                if ($('.user_list_content').html() == '') {
                    show_user_content(1, 'first');

                }
            });
        </script>

        <div class="content-body">
            <!-- Responsive Datatable -->
            <section id="responsive-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <? foreach (db::arr("SELECT COUNT(id) AS count, SOCIAL FROM tg_users WHERE SOCIAL = 'telegram'") as $v) : ?>
                                        <div class="col-sm-3">
                                            <a href="/account/marketing/list/<?=$v['SOCIAL']?>">
                                                <div class="card ecommerce-widget pro-gress">
                                                    <div class="card-body support-ticket-font">
                                                        <div class="row">
                                                            <h6><i class="fa fa-telegram"></i> Telegram</h6>
                                                            <span>Foydalanuvchilar soni: <?= $v['count'] ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    <? endforeach; ?>
                                    <? foreach (db::arr("SELECT COUNT(id) AS count, SOCIAL FROM tg_users WHERE SOCIAL = 'instagram'") as $v) : ?>
                                        <div class="col-sm-3">
                                            <a href="/account/marketing/list/<?=$v['SOCIAL']?>">
                                                <div class="card ecommerce-widget pro-gress">
                                                    <div class="card-body support-ticket-font">
                                                        <div class="row">
                                                            <h6><i class="fa fa-instagram"></i> Instagram</h6>
                                                            <span>Foydalanuvchilar soni: <?= $v['count'] ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    <? endforeach; ?>
                                    <? foreach (db::arr("SELECT COUNT(id) AS count, SOCIAL FROM tg_users WHERE SOCIAL = 'facebook'") as $v) : ?>
                                        <div class="col-sm-3">
                                            <a href="/account/marketing/list/<?=$v['SOCIAL']?>">
                                                <div class="card ecommerce-widget pro-gress">
                                                    <div class="card-body support-ticket-font">
                                                        <div class="row">
                                                            <h6><i class="fa fa-facebook-official"></i> Facebook</h6>
                                                            <span>Foydalanuvchilar soni: <?= $v['count'] ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    <? endforeach; ?>
                                    <? foreach (db::arr("SELECT COUNT(id) AS count, SOCIAL FROM tg_users WHERE SOCIAL = 'acquaintances'") as $v) : ?>
                                        <div class="col-sm-3">
                                            <a href="/account/marketing/list/<?=$v['SOCIAL']?>">
                                                <div class="card ecommerce-widget pro-gress">
                                                    <div class="card-body support-ticket-font">
                                                        <div class="row">
                                                            <h6><i class="fa fa-users"></i> Tanishlar</h6>
                                                            <span>Foydalanuvchilar soni: <?= $v['count'] ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    <? endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header border-bottom">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                        <h4 class="d-inline-block">Qo'shilgan foydalanuvchilar</h4><span></span>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-12 d-flex justify-content-md-end">
                                        <span class="d-inline-block">
                                            <button type="button" class="btn btn-outline-primary-2x" data-bs-toggle="modal" data-original-title="test" onclick="filter_modal()"><i class="fa fa-filter"></i> Filter</button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="user_list_content"></div>

                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<style>
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

<? require "modules/viho/marketing/marketing_js.php"; ?>
<? require "modules/viho/marketing/marketing_modal.php"; ?>