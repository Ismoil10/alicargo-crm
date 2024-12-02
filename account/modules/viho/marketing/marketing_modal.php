<?

if(isset($_GET['item_id'])){
    $networks = ["telegram", "instagram", "facebook", "acquaintances"];
    if(in_array($_GET['item_id'], $networks)){
        $_SESSION['create_date'] = "";
        $_SESSION['social'] = $_GET['item_id'];
    }else{
        $_SESSION['create_date'] = "";
        $_SESSION['social'] = "";
    }
}

if(isset($_POST['filterSubmit'])){

$datef = $_POST['date_filter'];
$network = $_POST['network'];

if($datef != '' or $network != '' or $datef != '' and $network != ''){
    $_SESSION['create_date'] = $datef;
    $_SESSION['social'] = $network;
}else{
    $_SESSION['social'] = "";
    $_SESSION['create_date'] = "";
}

LocalRedirect("index.php");
}

?>
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="filterModalLabel">Filter</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <? //echo '<pre>'; print_r($_SESSION); echo '</pre>'; ?>
                <form action="" id="filterForm" method="post">
                    <div class="mb-3">
                        <input type="date" id="date_id" value="<?=$_SESSION['create_date']?>" class="form-control" name="date_filter">
                    </div>
                    <div class="select mb-3">
                        <select class="form-select" name="network" style="width: 200px;">
                            <option value="0">None</option>
                            <option value="telegram">Telegram</option>
                            <option value="instagram">Instagram</option>
                            <option value="facebook">Facebook</option>
                            <option value="acquaintances">Tanishlar</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
                <button type="submit" class="btn btn-primary" onsubmit="filterSubmit()" form="filterForm" name="filterSubmit">Filter</button>
            </div>
        </div>
    </div>
</div>
<script>
/*
$('document').ready(function() {

filterSubmit = function(date, network) {
    date = $('[name=date_filter]');
    network = $('[name=network]');
    formData = new FormData();
    formData.append('time', date);
    formData.append('social', network);
    js_ajax_post('marketing/marketing_table.php', formData).done(function(data) {
        $('.user_list_content').html(data);
    });
}

if ($('.user_list_content').html() == '') {
    show_user_content(1, 'first');

}
});*/
</script>
