<? require $_SERVER["DOCUMENT_ROOT"] . '/core/backend.php'; ?>
<? ini_set('display_errors', 0); ?>
<? session_start(); ?>
<?
$keyword =  explode(" " , str_replace("'","",$_POST['keyword']));


									
$num = 10;
$_SESSION['user_page_num'] = $_POST['page_num'];
$page = $_SESSION['user_page_num'];
$start = $page * $num - $num; 

$like = "(LOWER(tg.ID) LIKE  LOWER('%$keyword[0]%') OR LOWER(tg.ISM_FAMILIYA) LIKE  LOWER('%$keyword[0]%') OR LOWER(tg.USERNAME) LIKE  LOWER('%$keyword[0]%') OR LOWER(tg.PHONE) LIKE  LOWER('%$keyword[0]%') OR LOWER(tg.STATUS) LIKE  LOWER('%$keyword[0]%')) AND
(LOWER(tg.ID) LIKE  LOWER('%$keyword[1]%') OR LOWER(tg.ISM_FAMILIYA) LIKE LOWER('%$keyword[1]%') OR LOWER(tg.USERNAME) LIKE  LOWER('%$keyword[1]%') OR LOWER(tg.PHONE) LIKE  LOWER('%$keyword[1]%') OR LOWER(tg.STATUS) LIKE  LOWER('%$keyword[1]%')) AND
(LOWER(tg.ID) LIKE  LOWER('%$keyword[2]%') OR LOWER(tg.ISM_FAMILIYA) LIKE LOWER('%$keyword[2]%') OR LOWER(tg.USERNAME) LIKE  LOWER('%$keyword[2]%') OR LOWER(tg.PHONE) LIKE  LOWER('%$keyword[2]%') OR LOWER(tg.STATUS) LIKE  LOWER('%$keyword[2]%'))";

$users = db::arr("SELECT * 
FROM message_log AS ms_log
LEFT JOIN tg_users AS users ON users.CHAT_ID = ms_log.CHAT_ID
WHERE ms_log.RASSILKA_ID='$_POST[itemId]' AND users.ROLE NOT IN ('0')
LIMIT $start, 10");

//$_POST[item_id]

$count = db::arr_s("
SELECT COUNT(*) AS COUNT FROM (
SELECT * FROM tg_users tg WHERE tg.ROLE NOT IN ('0') AND 
(LOWER(tg.ID) LIKE  LOWER('%$keyword[0]%') OR LOWER(tg.ISM_FAMILIYA) LIKE  LOWER('%$keyword[0]%') OR LOWER(tg.USERNAME) LIKE  LOWER('%$keyword[0]%') OR LOWER(tg.PHONE) LIKE  LOWER('%$keyword[0]%') OR LOWER(tg.STATUS) LIKE  LOWER('%$keyword[0]%')) AND
(LOWER(tg.ID) LIKE  LOWER('%$keyword[1]%') OR LOWER(tg.ISM_FAMILIYA) LIKE  LOWER('%$keyword[1]%') OR LOWER(tg.USERNAME) LIKE  LOWER('%$keyword[1]%') OR LOWER(tg.PHONE) LIKE  LOWER('%$keyword[1]%') OR LOWER(tg.STATUS) LIKE  LOWER('%$keyword[1]%')) AND
(LOWER(tg.ID) LIKE  LOWER('%$keyword[2]%') OR LOWER(tg.ISM_FAMILIYA) LIKE  LOWER('%$keyword[2]%') OR LOWER(tg.USERNAME) LIKE  LOWER('%$keyword[2]%') OR LOWER(tg.PHONE) LIKE  LOWER('%$keyword[2]%') OR LOWER(tg.STATUS) LIKE  LOWER('%$keyword[2]%'))) as T"); 
 
 
$count = $count['COUNT'];
$max = intval(($count - 1) / $num) + 1;	
if ($start+$num<=$count){$do = $start+$num;}else{$do = $count;}	
?>
<?$_SESSION['user_list_keyword'] = implode (" ",$keyword);?>
<div class="table-responsive">
<? //echo '<pre>'; print_r($users); echo '</pre>'; ?>
<? //echo '<pre>'; print_r($_POST); echo '</pre>'; ?>
    <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
        <div class="dataTables_length" id="basic-1_length">
            <label>Show
                <select name="basic-1_length" aria-controls="basic-1" class="">
                    <option value="10">10</option>
                </select> entries</label>
        </div>
        <div id="basic-1_filter" class="dataTables_filter">
            <label>
                <input type="search" class="" placeholder="" aria-controls="basic-1" name="search_user" value="<?= $_SESSION['user_list_keyword'] ?>">
                <button class="btn btn-primary btn-sm" type="button" onclick="show_user_content(1,'search')"><i class="icofont icofont-search-alt-1"></i> Поиск</button>
            </label>
        </div>
        <table class="display dataTable no-footer" id="basic-1" role="grid" aria-describedby="basic-1_info">
            <thead>
                <tr>
                    <th></th>
                    <th>#</th>
                    <th>Yaratilgan sana</th>
                    <th>Yuborilgan sana</th>
                    <th>Kimga</th>
                </tr>
            </thead>
            <tbody>
                <? foreach ($users as $v) : ?>
                    <tr>
                        <td></td>
                        <td><?= $v['ID'] ?></td>
                        <td><?= $v['CREATE_DATE'] ?></td>
                        <td><?= $v['SEND_DATE'] ?></td>
                        <td><?= $v['T_NAME'] ?></td>
                    </tr>
                <? endforeach; ?>
            </tbody>
        </table>

        <div class="dataTables_info" id="basic-1_info" role="status" aria-live="polite">Showing <?= $start + 1 ?> to <?= $do ?> of <?= $count ?> entries</div>

        <div class="dataTables_paginate paging_simple_numbers" id="basic-1_paginate">

            <? if ($page < 5) : ?>

                <a class="paginate_button previous <? if ($page == 1) {
                                                        echo 'disabled';
                                                    } ?>" <? if ($page == 1) {
                                                                        echo 'style = "display:none;"';
                                                                    } ?> onclick="show_user_content('<?= $page - 1 ?>')" aria-controls="basic-1" data-dt-idx="0" tabindex="0" id="basic-1_previous" data-bs-original-title="" title="">Previous</a>

                <span>
                    <a class="paginate_button <? if ($page == 1) {
                                                    echo 'current';
                                                } ?>" onclick="show_user_content('1')" aria-controls="basic-1" data-dt-idx="1" tabindex="0" data-bs-original-title="" title="">1</a>
                    <? if (2 <= $max) : ?>
                        <a class="paginate_button <? if ($page == 2) {
                                                        echo 'current';
                                                    } ?>" onclick="show_user_content('2')" aria-controls="basic-1" data-dt-idx="2" tabindex="0" data-bs-original-title="" title="">2</a>
                    <? endif; ?>
                    <? if (3 <= $max) : ?>
                        <a class="paginate_button <? if ($page == 3) {
                                                        echo 'current';
                                                    } ?>" onclick="show_user_content('3')" aria-controls="basic-1" data-dt-idx="3" tabindex="0" data-bs-original-title="" title="">3</a>
                    <? endif; ?>
                    <? if (4 <= $max) : ?>
                        <a class="paginate_button <? if ($page == 4) {
                                                        echo 'current';
                                                    } ?>" onclick="show_user_content('4')" aria-controls="basic-1" data-dt-idx="4" tabindex="0" data-bs-original-title="" title="">4</a>
                    <? endif; ?>
                    <? if (5 <= $max) : ?>
                        <a class="paginate_button <? if ($page == 5) {
                                                        echo 'current';
                                                    } ?>" onclick="show_user_content('5')" aria-controls="basic-1" data-dt-idx="5" tabindex="0" data-bs-original-title="" title="">5</a>
                    <? endif; ?>

                    <? if ($max != 1 and $max > 5) : ?>
                        <span class="ellipsis">…</span>
                        <a class="paginate_button " onclick="show_user_content('<?= $max ?>')" aria-controls="basic-1" data-dt-idx="6" tabindex="0" data-bs-original-title="" title=""><?= $max ?></a>
                    <? endif ?>


                </span>

                <a class="paginate_button next <? if ($page == $max) {
                                                    echo 'disabled';
                                                } ?>" <? if ($page == $max) {
                                                                    echo 'style = "display:none;"';
                                                                } ?> onclick="show_user_content('<?= $page + 1 ?>')" aria-controls="basic-1" data-dt-idx="7" tabindex="0" id="basic-1_next" data-bs-original-title="" title="">Next</a>

            <? elseif ($max > ($page + 3)) : ?>

                <a class="paginate_button previous" onclick="show_user_content('<?= $page - 1 ?>')" aria-controls="basic-1" data-dt-idx="0" tabindex="0" id="basic-1_previous" data-bs-original-title="" title="">Previous</a>

                <span>
                    <a class="paginate_button <? if ($page == 1) {
                                                    echo 'current';
                                                } ?>" onclick="show_user_content('1')" aria-controls="basic-1" data-dt-idx="1" tabindex="0" data-bs-original-title="" title="">1</a>
                    <span class="ellipsis">…</span>
                    <a class="paginate_button" onclick="show_user_content('<?= $page - 1 ?>')" aria-controls="basic-1" data-dt-idx="2" tabindex="0" data-bs-original-title="" title=""><?= $page - 1 ?></a>
                    <a class="paginate_button" onclick="show_user_content('<?= $page ?>')" aria-controls="basic-1" data-dt-idx="2" tabindex="0" data-bs-original-title="" title=""><?= $page ?></a>
                    <a class="paginate_button" onclick="show_user_content('<?= $page + 1 ?>')" aria-controls="basic-1" data-dt-idx="2" tabindex="0" data-bs-original-title="" title=""><?= $page + 1 ?></a>
                    <span class="ellipsis">…</span>
                    <a class="paginate_button" onclick="show_user_content('<?= $max ?>')" aria-controls="basic-1" data-dt-idx="2" tabindex="0" data-bs-original-title="" title=""><?= $max ?></a>

                </span>

                <a class="paginate_button next" onclick="show_user_content('<?= $page + 1 ?>')" aria-controls="basic-1" data-dt-idx="7" tabindex="0" id="basic-1_next" data-bs-original-title="" title="">Next</a>

            <? else : ?>

                <a class="paginate_button previous" onclick="show_user_content('<?= $page - 1 ?>')" aria-controls="basic-1" data-dt-idx="0" tabindex="0" id="basic-1_previous" data-bs-original-title="" title="">Previous</a>
                <span>
                    <a class="paginate_button" onclick="show_user_content('1')" aria-controls="basic-1" data-dt-idx="1" tabindex="0" data-bs-original-title="" title="">1</a>
                    <span class="ellipsis">…</span>
                    <a class="paginate_button " onclick="show_user_content('<?= $max - 4 ?>')" aria-controls="basic-1" data-dt-idx="2" tabindex="0" data-bs-original-title="" title=""><?= $max - 4 ?></a>
                    <a class="paginate_button <? if ($page == ($max - 3)) {
                                                    echo 'current';
                                                } ?>" onclick="show_user_content('<?= $max - 3 ?>')" aria-controls="basic-1" data-dt-idx="3" tabindex="0" data-bs-original-title="" title=""><?= $max - 3 ?></a>
                    <a class="paginate_button <? if ($page == ($max - 2)) {
                                                    echo 'current';
                                                } ?>" onclick="show_user_content('<?= $max - 2 ?>')" aria-controls="basic-1" data-dt-idx="4" tabindex="0" data-bs-original-title="" title=""><?= $max - 2 ?></a>
                    <a class="paginate_button <? if ($page == ($max - 1)) {
                                                    echo 'current';
                                                } ?>" onclick="show_user_content('<?= $max - 1 ?>')" aria-controls="basic-1" data-dt-idx="5" tabindex="0" data-bs-original-title="" title=""><?= $max - 1 ?></a>
                    <a class="paginate_button <? if ($page == $max) {
                                                    echo 'current';
                                                } ?>" onclick="show_user_content('<?= $max ?>')" aria-controls="basic-1" data-dt-idx="6" tabindex="0" data-bs-original-title="" title=""><?= $max ?></a>
                </span>
                <a class="paginate_button next <? if ($page == $max) {
                                                    echo 'disabled';
                                                } ?>" <? if ($page == $max) {
                                                                    echo 'style = "display:none;"';
                                                                } ?> onclick="show_user_content('<?= $page + 1 ?>')" aria-controls="basic-1" data-dt-idx="7" tabindex="0" id="basic-1_next" data-bs-original-title="" title="">Next</a>
            <? endif; ?>

        </div>


    </div>
</div>