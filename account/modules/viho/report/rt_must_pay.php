<?
$data = db::arr("SELECT  COUNT(ID) AS AMOUNT, CREATED_DATE AS `DATE`
FROM    `tg_users`
WHERE   CREATED_DATE >= '$_SESSION[from_date]-01-01' 
AND     CREATED_DATE <= curdate()
GROUP BY YEAR(CREATED_DATE), Month(CREATED_DATE);");
$data_list = [];
foreach($data as $value){
    $date = new DateTime($value["DATE"]);
    $date->modify('first day of this month');
    array_push($data_list, ["date"=>$date->format('m'), "value"=>$value["AMOUNT"]]);
}

$month_list = [
    "01" => "Yanvar oyi",
    "02" => "Fevral oyi",
    "03" => "Mart oyi",
    "04" => "Aprel oyi",
    "05" => "May oyi",
    "06" => "Iyun oyi",
    "07" => "Iyul oyi",
    "08" => "Avgust oyi",
    "09" => "Sentyabr oyi",
    "10" => "Oktyabr oyi",
    "11" => "Noyabr oyi",
    "12" => "Dekabr oyi",
];


?>


<div class="table-responsive">
    <h5>Foydalanuvchilarning o'sish hisoboti</h5>
    <table class="display" id="basic-2">
    <thead>
        <tr>
            <th>OY</th>
            <th>MIQDORI</th>
        </tr>
    </thead>
    <tbody>
        <?foreach($data_list as $data_value):?>
        <tr>
            <td><?=$month_list[$data_value["date"]]?></td>
            <td><?=$data_value["value"]?> ta odam ro'yhatdan o'tgan</td>
        </tr>
        <?endforeach;?>
    </tbody>
    </table>
</div>