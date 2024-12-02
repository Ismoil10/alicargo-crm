<!--<div class="modal fade" id="print" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">-->

<!--<div id="" class="modal hide fade in" data-keyboard="false" data-backdrop="static">-->


<div id="print" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-bs-keyboard="false" data-bs-backdrop="static">


  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="filterModalLabel">PRINT</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" id="print_form" method="post">
          <div class="mb-3">
            <div class="col" style="display: flex;">
		
			<?
			$inputs =[
		
            'print_sana'=>[
      		'label_name'=>'Sana',
     		'type'=>'input',
      		'attr' => [
      		'type'=>'date',
      		'class'=>'form-control',
      		]                
      		],       
			
            'ex'=>[
      		'label_name'=>'EX',
     		'type'=>'input',
      		'attr' => [
      		'type'=>'text',
      		'class'=>'form-control',
      		]                
      		],         

			'id'=>[
      		'label_name'=>'ID',
     		'type'=>'input',
      		'attr' => [
      		'type'=>'text',
      		'class'=>'form-control',
      		]                
      		],		

			'ism'=>[
      		'label_name'=>'Ism',
     		'type'=>'input',
      		'attr' => [
      		'type'=>'text',
      		'class'=>'form-control',
      		]                
      		],		

			'tel'=>[
      		'label_name'=>'Tel',
     		'type'=>'input',
      		'attr' => [
      		'type'=>'text',
      		'class'=>'form-control',
      		]                
      		],
				
			'manzil'=>[
      		'label_name'=>'Manzil',
     		'type'=>'textarea',
      		'attr' => [
      		'type'=>'text',
      		'class'=>'form-control',
      		]                
      		],			
			
			'kg'=>[
      		'label_name'=>'Kg',
     		'type'=>'input',
      		'attr' => [
      		'type'=>'text',
      		'class'=>'form-control',
      		]                
      		],
			
			'tovar_soni'=>[
      		'label_name'=>'Tovar soni',
     		'type'=>'input',
      		'attr' => [
      		'type'=>'text',
      		'class'=>'form-control',
      		]                
      		],
			
			];
			
			$form_content = [
			'100 col-md-6 mb-3'=>'print_sana',
			'150 col-md-6 mb-3'=>'ex',
            '200 col-md-12 mb-3'=>'id',					
            '300 col-md-6 mb-3'=>'ism',					
            '400 col-md-6 mb-3'=>'tel',					
            '500 col-md-12 mb-3'=>'manzil',					
            '600 col-md-6 mb-3'=>'kg',					
            '700 col-md-6 mb-3'=>'tovar_soni',					
			];
			
			?>		
  
			  
			<div class="row">
            <?foreach ($form_content as $k2=>$v2):?>
			
			<?if (!is_array($v2)):?>
			<?$cl = explode('#',$k2);?>
			<div class="<?=$cl[0]?>" id="<?=$cl[1]?>">
			<?if (isset($inputs[$v2])):?>
			<?$attr = '';?>
			<?foreach ($inputs[$v2]['attr'] as $k3=>$v3){$attr = $attr.' '.$k3.'="'.$v3.'"';}?>		
			<?if ($inputs[$v2]['type']=='select'):?>
			<label class="form-label"><?=$inputs[$v2]['label_name']?></label>	
			<select  name="<?=$v2?>" <?=$attr?>>			
			<option></option>
			<?foreach ($inputs[$v2]['data'] as $k4=>$v4):?>
			<option value="<?=$k4?>"><?=$v4?></option> 
			<?endforeach?>			
			</select>
			<?elseif ($inputs[$v2]['type']=='textarea'):?>
			<label class="form-label"><?=$inputs[$v2]['label_name']?></label>
			<textarea class="form-control" name="<?=$v2?>" <?=$attr?>></textarea>
			<?elseif ($inputs[$v2]['type']=='input'):?>
			<label class="form-label"><?=$inputs[$v2]['label_name']?></label>
            <input name="<?=$v2?>" <?=$attr?>>				
			<?endif?>
		    <?elseif (strpos ($k2,'ui')==true):?>	
            <?=$ui[$v2]?> 			
			<?endif;?>			
			</div> 
			
			<?endif?>			
			<?endforeach?>			
            </div>	

			  
            </div>
          </div>
      </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
        <button type="submit" name="print_submit" class="btn btn-primary" >PRINT</button>
      </div>
	          </form>

    </div>
  </div>
</div>




<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="filterModalLabel">Filter</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" id="filterForm" method="post">
          <div class="mb-3">
            <div class="col" style="display: flex;">
              <div class="form-group m-t-15 m-checkbox-inline mb-0">
                <div class="checkbox checkbox-dark">
                  <input id="inline-1" type="checkbox" name="takens" <?if(isset($_SESSION["filter_pochta"]) and $_SESSION["filter_pochta"]=="AND (az.PICKUP_DATE IS NOT NULL OR az.POCHTA_PHOTO IS NOT NULL)"){echo "checked";}?>>
                  <label for="inline-1">Faqat Olib ketilganlar</label>
                </div>
                <div class="checkbox checkbox-dark">
                  <input id="inline-2" type="checkbox" name="all" <?if(isset($_SESSION["filter_pochta"]) and $_SESSION["filter_pochta"]==""){echo "checked";}?>>
                  <label for="inline-2">Barchasi</label>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
        <button type="submit" class="btn btn-primary" form="filterForm" name="filterTable">Filter</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade bd-example-modal-lg" tabindex="-1" id="shippedModal" role="dialog" aria-labelledby="shippedModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="shippedModalLabel">Zakaz Yetkazib Berildi</h4>
				<button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form action="" id="shippedForm" method="post">
					<div class="mb-3">
          <p>Haqiqatan ham buyurtma holatini <b>YETKAZILDI </b> ga oʻzgartirmoqchimisiz?</p>
						<input type="hidden" name="order_id">
					</div>
				</form>
			</div>
			<div class="modal-footer">				
				<button class="btn btn-secondary" type="button" data-bs-dismiss="modal" >Yo'q</button>
				<button class="btn btn-primary" type="submit" form="shippedForm" name="shippedSubmite" >Ha</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-lg" tabindex="-1" id="infoModal" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">

</div>
<div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cartModalLabel">Карзина</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table">
          <tbody>
            <?//$cart_list = db::arr("SELECT az.*, tg.ADRES, tg.PHONE, tg.ISM_FAMILIYA FROM `ac_zakaz` AS az INNER JOIN `tg_users` AS tg ON tg.CODE=az.CLIENT_CODE WHERE az.DELIVERY_TYPE='pochta' AND az.PAID=1 AND CART=1 AND POCHTA_PHOTO IS NULL");
            if($cart_list != "empty"):
            foreach($cart_list as $v):?>
              <tr>
                <td><?=$v['LAST_MODIFIED']?></td>
                <td><?=$v['ID']?></td>
                <td><?=$v['CLIENT_CODE']?></td>
                <td><?=$v['ADRES']?></td>     
                <td><?=$v['PHONE']?></td>     
                <td><?=$v['WEIGHT']?></td>  
                <td><?=$v["SHELF"]?></td>
                <td><form action="" method="post">
                  <button class="btn btn-danger" name="remove_from_cart" value="<?=$v['ID']?>"><i class="fa fa-trash"></i></button>
                </form></td>   
              </tr>
            <?endforeach;?>
            <?else:
            echo "Нет Данных";
            endif;?>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Закрить</button>
        <!-- <button type="button" class="btn btn-primary"></button> -->
      </div>
    </div>
  </div>
</div>

<?
if(isset($_POST["remove_from_cart"]) and is_numeric($_POST["remove_from_cart"])){
  $update = db::query("UPDATE `ac_zakaz` SET CART=0 WHERE ID='$_POST[remove_from_cart]'");
  LocalRedirect("index.php");
}
if(isset($_POST["shippedSubmite"])){
  $now = date("Y-m-d H:i:s");
  $sql = "UPDATE `ac_zakaz` SET `TAKEN`='1', `PICKUP_DATE`='$now' WHERE ID='$_POST[order_id]'";
	$update = db::query($sql);

  if($update["stat"] == "success"){
    LocalRedirect("index.php");
  }
}

if(isset($_POST["filterTable"])){
  if($_POST["takens"] == "on"){
    $sql = "AND (az.PICKUP_DATE IS NOT NULL OR az.POCHTA_PHOTO IS NOT NULL)";
  }else if($_POST["all"] == "on"){
    $sql = "";
  }else{
    $sql = "AND az.PICKUP_DATE IS NULL AND az.POCHTA_PHOTO IS NULL";
  }
  $_SESSION["filter_pochta"] = "$sql";
  LocalRedirect("index.php");
}
?>

<?require "pochta_js.php";?>