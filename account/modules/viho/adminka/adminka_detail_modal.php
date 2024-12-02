<?


$month_text = ['01.'=> 'янв','02.'=>'фев','03.'=>'март','04.'=>'апр','05.'=>'май','06.'=>'июн','07.'=>'июл','08.'=>'авг','09.'=>'сент','10.'=>'окт','11.'=>'ноя','12.'=>'дек'];

$year = date('Y');
$month = date('m');

if ($month==12){
$dates = new DatePeriod(new DateTime(($year).'-1'), new DateInterval('P1M'), new DateTime(date(($year+1).'-1')));	
}else{
$dates = new DatePeriod(new DateTime(($year-1).'-'.($month+1)), new DateInterval('P1M'), new DateTime(date($year.'-'.($month+1))));
}
$date_strings_ok = array_map(function($d) { return $d->format('m.Y'); }, iterator_to_array($dates));


$date_arr =array_combine($date_strings_ok, $date_strings_ok); ;
foreach ($month_text as $k2=>$v2){$date_arr = str_replace($k2,$v2.'.',$date_arr);}

//$yrmon = explode('.', $str);

if(isset($_POST['filterSubmit'])){

$_SESSION['year_month'] = $_POST['date'];

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
                <? //echo '<pre>'; print_r($date_arr); echo '</pre>'; ?>
                <form action="" id="filterForm" method="post">
                    <div class="select mb-3">
                        <select class="form-select" name="date" style="width: 200px;">
                        <option value="0">None</option>
                        <? foreach($date_arr as $k => $v): ?>
                            <option value="<?=$k?>"><?=$v?></option>
                        <? endforeach; ?>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
                <button type="submit" class="btn btn-primary" form="filterForm" name="filterSubmit">Filter</button>
            </div>
        </div>
    </div>
</div>