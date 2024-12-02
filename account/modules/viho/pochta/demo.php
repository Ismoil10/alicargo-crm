<?
$data = db::arr("SELECT az.*, tg.ADRES, tg.PHONE, tg.ISM_FAMILIYA FROM `ac_zakaz` AS az INNER JOIN `tg_users` AS tg ON tg.CODE=az.CLIENT_CODE WHERE az.DELIVERY_TYPE='pochta' AND az.PAID=1 AND az.PICKUP_DATE IS NULL AND az.POCHTA_PHOTO IS NULL ORDER BY az.LAST_MODIFIED DESC LIMIT 0, 15");
$amount = db::arr_s("SELECT COUNT(ID) AS amount FROM `ac_zakaz` WHERE CART='1'");
?>
<style>
  .filter-btn{
    width: 25px;
    text-align: center;
    padding: 1px;
    opacity: 0.2;
  }
  .filter-btn:hover{
    opacity: 1;
  }
  .filter-btn i {
    font-size: 12px;
  }
  .filter-active{
    background-color: #1b4c43;
    padding: 3px;
    color: #f3f3f3;
    border-radius: 6px;
    opacity: 1;
  }
  .th-header{
    display: flex; 
    align-items: center;
  }
</style>
<div class="container-fluid">
  <div class="page-header">
    <div class="row">
      <div class="col-sm-9">
        <h3>ALICARGO</h3>
        <span>Pochtalar</span>
      </div>
      <div class="col-sm-3">
        <div class="d-flex align-items-center">
          <input placeholder="Поиск..." type="text" id="search" autocomplete="off" class="form-control  w-75">
          <button class="btn btn-primary btn-lg ms-1 searchData"><i class="fa fa-search"></i></button>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
              <h4>Pochtalar Ro'yhati</h4>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-12 d-flex justify-content-md-end">
              <span class="d-inline-block">
                <a href="./cart" type="button" class="btn btn-outline-primary-2x">
                  <!-- <i class="fa fa-shopping-cart 2x"></i> -->Корзина
                  <span class="badge rounded-pill badge-info cart-count"><?= $amount["amount"] ?></span>
                </a>
                <!-- <button type="button" class="btn btn-outline-primary-2x filter-button">
                  Филтер
                  <span class="badge rounded-pill badge-info">
                    <i data-feather="filter"></i>
                  </span>
                </button> -->
                <!-- <div class="mt-1 card d-none filter-options" style="z-index: 1; position: absolute; width:300px;">
                  <div class="left-filter">
                    <div class="card-header p-2">
                      <button class="btn btn-xs close-filter float-end"><i class="w-75" data-feather="x-circle"></i></button>
                    </div>
                    <div class="card-body filter-cards-view animate-chk">
                      <div class="product-filter">
                        <label for="filter-option">Сортировать по</label>
                        <select name="filter-option-list" id="filter-option" class="form-select">
                          <option value="date">Дате</option>
                          <option value="client_code">Клиент код</option>
                          <option value="shelf">Полка</option>
                        </select>
                      </div>
                      <div class="product-filter">
                        <label for="method">Порядок по</label>
                        <select name="method" id="method" class="form-select">
                          <option value="desc">Убыванию</option>
                          <option value="asc">Возрастанию</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="m-3 d-flex justify-content-end">
                    <button class="btn btn-sm btn-secondary me-1 cancel-filter"><i class="fa fa-times-circle fa-lg"></i></button>
                    <button class="btn btn-sm btn-primary conform-filter"><i class="fa fa-check-circle fa-lg"></i></button>
                  </div>
                </div> -->
              </span>
            </div>
          </div>
        </div>
        <div class="table-responsive pe-3 ps-3">
          <table class="table" style="border: #eee solid 1px;">
            <thead>
              <tr>
                <th scope="col"><span class="th-header">Tushgan Sana <div class="filter-btn filter-date filter-active"><i class="fa fa-arrow-down"></i></div></span></th>
                <th scope="col">ID</th>
                <th scope="col"><span class="th-header">Foydalanuvchi <div class="filter-btn filter-user"><i class="fa fa-arrow-down"></i></div></span></th>
                <th scope="col">Manzil</th>
                <th scope="col">Tel. raqam</th>
                <th scope="col">Vazni</th>
                <th scope="col"><span class="th-header">Polka <div class="filter-btn filter-shelf"><i class="fa fa-arrow-down"></i></div></span></th>
                <th scope="col">Haraqat</th>
              </tr>
            </thead>
            <tbody class="table-body">
              <? foreach ($data as $v) : ?>
                <tr id="<?= $v["ID"] ?>" <? if ($v["CART"] == '1') echo 'class="bg-secondary"' ?>>
                  <td><?= $v['LAST_MODIFIED'] ?></td>
                  <td><?= $v['ID'] ?></td>
                  <td><?= $v['CLIENT_CODE'] ?></td>
                  <td><?= $v['ADRES'] ?></td>
                  <td><?= $v['PHONE'] ?></td>
                  <td><?= $v['WEIGHT'] ?></td>
                  <td><?= $v["SHELF"] ?></td>
                  <td>
                    <div class="btn-group">
                      <button class="btn btn-xs btn-outline-primary" onclick="shippedModal(<?= $v['ID'] ?>)" type="button"><i class="fa fa-truck"></i> </button>
                      <button class="btn btn-xs btn-outline-primary" onclick="infoModal('<?= $v['ID'] ?>')" type="button"><i class="fa fa-file-text"></i> </button>
                      <button class="btn btn-xs btn-outline-primary" onclick="addCart(<?= $v['ID'] ?>)" type="button"><i class="fa fa-plus"></i> </button>
                    </div>
                  </td>
                </tr>
              <? endforeach ?>
            </tbody>
          </table>
          <div class="loader-box mt-4" style="display: none;">
            <div class="loader-3"></div>
          </div>
          <nav aria-label="Page navigation example">
            <ul class="pagination pagination-primary float-end m-3">
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="/account/modules/viho/pochta/pochta.js"></script>
<? require "pochta_modals.php"; ?>