<? require $_SERVER["DOCUMENT_ROOT"] . '/core/backend.php'; ?>
<?

$user_id = $_POST['user_id'];

$adminka = db::arr_s("SELECT * FROM tg_users WHERE ID = '$user_id'");

/*if ($select_admin != 'empty') {
    echo json_encode($select_admin);
}*/
?>

<ul class="list-group list-group-flush">
    <li class="list-group-item pl-0"><b>Kod: </b> <?=$adminka['CODE']?></li>
    <li class="list-group-item pl-0"><b>Sana: </b> <?=$adminka['CREATE_DATE']?></li>
    <li class="list-group-item pl-0"><b>Ism Familiya: </b> <?=$adminka['ISM_FAMILIYA']?></li>
    <li class="list-group-item pl-0"><b>Manzil: </b> <?=$adminka['ADRES']?></li>
    <li class="list-group-item pl-0"><b>Tel. raqami: </b> <?=$adminka['PHONE']?></li>
</ul>