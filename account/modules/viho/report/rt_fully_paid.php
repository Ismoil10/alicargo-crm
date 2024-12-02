<?
$seperate_month = explode("-" , $_SESSION["from_date"]);
if(is_numeric($seperate_month[1]) and !empty($seperate_month[1])){
    $month = $_SESSION["from_date"];
}else{
    $month = "2022-01";
    array_push($seperate_month, "01");
    
}
$data = db::arr("SELECT COUNT(ID) AS AMOUNT, FROM_VILOYAT as `FROM`, TO_CITY as `TO`
FROM `yonalish_log`
WHERE CREATED_DATE BETWEEN '$month-01' AND LAST_DAY('$month-1')
GROUP BY MONTH(CREATED_DATE), FROM_VILOYAT, TO_CITY");

$month_list = [
    "01" => "Yanvar oyi hisoboti",
    "02" => "Fevral oyi hisoboti",
    "03" => "Mart oyi hisoboti",
    "04" => "Aprel oyi hisoboti",
    "05" => "May oyi hisoboti",
    "06" => "Iyun oyi hisoboti",
    "07" => "Iyul oyi hisoboti",
    "08" => "Avgust oyi hisoboti",
    "09" => "Sentyabr oyi hisoboti",
    "10" => "Oktyabr oyi hisoboti",
    "11" => "Noyabr oyi hisoboti",
    "12" => "Dekabr oyi hisoboti",
];

?>




<div class="table-responsive">
    <h5>Yo'nalishlarda so'rovlarni qidirish hisoboti</h5>
    <span class="mb-3"><?=$month_list[$seperate_month[1]]?></span>
    <table class="display" id="basic-2">
    <thead>
        <tr>
            <th>SHAHARDAN</th>
            <th>SHAHARGA</th>
            <th>MIQDORI</th>
        </tr>
    </thead>
    <tbody>
        <?foreach($data as $data_value):?>
        <tr>
            <?$city_from = db::arr_s("SELECT * FROM `list_rayon` WHERE ID = $data_value[FROM]")?>
            <?$city_to = db::arr_s("SELECT * FROM `list_rayon` WHERE ID= $data_value[TO]")?>
            <td><?=$city_from["NAME"]?></td>
            <td><?=$city_to["NAME"]?></td>
            <td><?=$data_value["AMOUNT"]?> ta odam qidirgan</td>
        </tr>
        <?endforeach;?>
    </tbody>
    </table>
</div>