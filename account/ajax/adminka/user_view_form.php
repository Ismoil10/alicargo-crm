<?//require $_SERVER["DOCUMENT_ROOT"].'/core/backend.php';?>
<?require $_SERVER["DOCUMENT_ROOT"].'/bot/db.php';?>
<?require $_SERVER["DOCUMENT_ROOT"].'/bot/class.php';?>

<?
	$tg_users = db::arr_s("SELECT * FROM `tg_users` WHERE ID='$_POST[USER_ID]'");
?>

	<div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="add_item">Murojatlar - <?=$tg_users['CODE'];?></h5>
          <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
		<form method = "post">
        <div class="modal-body">
	    <div class="container-fluid bd-example-row">
			
			<input type="hidden" name="user_id" value="<?=$tg_users['ID'];?>">
			<input type="hidden" name="chat_id" value="<?=$tg_users['CHAT_ID'];?>">
			
          <div class="row">
            <div class="col-md-6">
	            <div class = "mb-3">
					<label class="form-label">FIO</label>
					<div class="input-group">			
						<input value="<?=$tg_users['ISM_FAMILIYA'];?>" type = "text" class="form-control" name="ism_edit" required>
						<span class="input-group-text"> <input name="ism_otkaz" type="checkbox"> </span>
					</div>
				</div>
	        </div>
            <div class="col-md-6 ml-auto">
	            <div class = "mb-3">
					<label class="form-label">TELEFON RAQAM</label>
					<div class="input-group">			
						<input value="<?=$tg_users['PHONE'];?>" type = "text" class="form-control" name = "raqam_edit" required>
						<span class="input-group-text"> <input name="raqam_otkaz" type="checkbox"> </span>
					</div>
				</div>	            
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-12">
	            <div class = "mb-3">
					<label class="form-label">ADRES</label>
					<div class="input-group">			
						<input value="<?=$tg_users['ADRES'];?>" type = "text" class="form-control" name = "adres_edit" required>
						<span class="input-group-text"> <input name="adres_otkaz" type="checkbox"> </span>
					</div>
				</div>
	        </div>
          </div>
          
          <div class="row">
            <div class="col-md-6">
	            <div class = "mb-3">
					<label class="form-label">PASSPORT_1 </label> <span class="input-group-text"> <input name="p1_otkaz" type="checkbox"> </span>
					<div class="input-group">			
						<img src="<?=bot::getFile($tg_users['P_PHOTO_1'])?>" width="100%">
					</div>
				</div>
	        </div>
	        <div class="col-md-6">
	            <div class = "mb-3">
					<label class="form-label">PASSPORT_2</label> <span class="input-group-text"> <input name="p2_otkaz" type="checkbox"> </span>
					<div class="input-group">			
						<img src="<?=bot::getFile($tg_users['P_PHOTO_2'])?>" width="100%">
					</div>
				</div>
	        </div>
			<div class="col-md-6">
				<div class = "mb-3">
					<label class="form-label">TO`LOV SKRINSHOT</label> <span class="input-group-text"> <input name="pay_otkaz" type="checkbox"> </span>
					<div class="input-group">			
						<img src="<?=bot::getFile($tg_users['OPLATA_PHOTO'])?>" width="100%">
					</div>
				</div>
			</div>
	        <div class="col-md-6">
	            <div class = "mb-3">
					<label class="form-label">SKLAD SKRINSHOT</label> <span class="input-group-text"> <input name="app_otkaz" type="checkbox"> </span>
					<div class="input-group">			
						<img src="<?=bot::getFile($tg_users['APP_PHOTO'])?>" width="100%">
					</div>
				</div>
	        </div>
          </div> <!--*/?>-->		  
		  <div class="row">
			<div class="col-md-2">
				  <div class = "mb-3">
					  <label class="form-label">TIL</label> 
					  <div class="input-group">			
						  <input value="<?=$tg_users['LANG'];?>" type = "text" class="form-control" disabled>
					  </div>
				  </div>
			  </div>
			<div class="col-md-10">
				<div class = "mb-3">
					<label class="form-label">IZOH</label> 
					<div class="input-group">			
						<input type = "text" class="form-control" name = "otkaz_comment">
					</div>
				</div>
			</div>
		  </div>
          
        </div>

		
		</div>
        <div class="modal-footer">
		
		<!--         
          <button class="btn btn-primary" name = "approve_button" type="submit">Подтвердить</button>
	  -->
          <button class="btn btn-danger" name = "reject_button" type="submit">Отклонить</button>
        
		  <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Закрыть окно</button>
        </div>
		</form>
      </div>
    </div>
	
	
<script>
	
	$(document).ready(function (){
	
	var boxes = $('[type=checkbox]');
	
	boxes.on('change', function () {
		$('[name=reject_button]').prop('disabled', !boxes.filter(':checked').length);
	}).trigger('change');
	
	});
		
</script>