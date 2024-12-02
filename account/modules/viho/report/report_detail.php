 <?//echo '<pre>'; print_r($_POST); echo '</pre>';?>
 
<?
if (isset($_POST['update_gen_info'])):
$q[] = db::query("UPDATE `vd_project_list` SET NAME = '$_POST[project_name]',WELCOME_TEXT = '$_POST[welcome_text]' WHERE ID='$_GET[item_id]'");
?>
<script>
$(document).ready(function () {

formData = new FormData();
formData.append('project_id','<?=$_GET['item_id']?>');

js_ajax_post('projects/send_message.php',formData).done(function (data){

//$('#js_add_item_content').html(data);	

alert('Подождите ... идет рассылка!');	
	
});	

});
</script>
<?
//LocalRedirect('/account/projects/detail/'.$_SESSION['item_id']); 
//header ('Location:/account/projects/detail/'.$_SESSION['item_id']);
endif;
?>

<?
if (isset($_POST['del_item'])){

	$q['del'] = db::query("DELETE FROM `vd_project_items`  WHERE ID = '$_POST[del_item_id]'");	
	LocalRedirect('index.php');

}  
?> 
  

 <?if (isset($_GET['item_id'])) {$_SESSION['item_id'] = $_GET['item_id'];}?>
 
 <?if ($_POST['update']=='content') {header ('Location:/account/projects/detail/'.$_SESSION['item_id'].'#content');}?>
 
 
 <?$vd_project_list = db::arr_s("SELECT * FROM `vd_project_list` WHERE ID='$_GET[item_id]'");?>
 
 <? //echo "<pre>"; print_r($_POST); echo "</pre>";  ?>
 <? //echo "<pre>"; print_r($_POST); echo "</pre>";  ?>
 <? //echo "<pre>"; print_r($vd_project_list); echo "</pre>";  ?>

		<div class="container-fluid">
            <div class="page-header">
              <div class="row">
                <div class="col-sm-6">
                  <h3>Video BOT</h3>
                  
                </div>
                <div class="col-sm-6">
                  <!-- Bookmark Start-->
                  <div class="bookmark">
                    <ul>
                     
                      <li style="padding-right: 40px"><a href="https://t.me/videoevobot"><i class="bookmark-search" data-feather="at-sign"></i>videoevobot</a>
                       
                      </li>
                    </ul>
                  </div>
                  <!-- Bookmark Ends-->
                </div>
              </div>
            </div>
          </div>
<div class="container-fluid credit-card payment-details">
            <div class="row">
              <!-- Individual column searching (text inputs) Starts-->
              <div class="col-xxl-12 box-col-12">
                <div class="card">
                  <div class="card-header pb-0">
                    <h5>Общая информация </h5>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-7">
                        <form class="theme-form mega-form" method="POST" action="#">
						
                          <div class="mb-3">
						  	<label>Названия проекта</label>
                            <input class="form-control" type="text"  name="project_name" value="<?=$vd_project_list['NAME']?>">
                          </div>                

						  <div class="mb-3">
						  	<label>Текст приветствия</label>
                            <input class="form-control" type="text"  name="welcome_text" value="<?=$vd_project_list['WELCOME_TEXT']?>">
                          </div>
						  
						  <div class="mb-3">
						  	<label>URL приглашения</label>
                            <input class="form-control" type="text"  value="https://t.me/InovaWedding_bot?start=<?=$vd_project_list['KEY']?>" readonly >
                          </div>
						  
						  <div class="col-12">
                        	<button class="btn btn-primary " type="submit" name="update_gen_info" title="">Сохранить</button>
                      	  </div> 
						  
						  
                       
                        </form>
                      </div>
                      <div class="col-md-5 text-center"><img class="img-fluid" src="<?=$vd_project_list["QR_LINK"]?>" alt=""></div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Individual column searching (text inputs) Ends-->             

			  <!-- Individual column searching (text inputs) Starts-->
              <div class="col-xxl-12 box-col-12">
                <div class="card" id="content">
                  <div class="card-header">
                    <div class = "row">
						<div class = "col-lg-6 col-md-6 col-sm-6 col-12"> <h5 class = "d-inline-block">Контент</h5></div>
						<div class = "col-lg-6 col-md-6 col-sm-6 col-12 d-flex justify-content-md-end">
						<span class = "d-inline-block">
			
  							
						<button type="button" class="btn btn-outline-primary-2x" data-bs-toggle="modal" data-original-title="test" data-bs-target="#add_item"><i class="fa fa-plus"></i>	Добавить</button> 	
						
						<form action="" method="POST" style="display:inline-block;">
						<input  type="hidden" name="update" value="content">
						<button type="submit" class="btn btn-outline-secondary-2x" ><i class="fa  fa-refresh"></i>&nbsp;</button>                
						</form>
						 
						</span>
						</div>
					</div>
                  </div>
                  <div class="card-body">
                    <div class="row">
                    <div class="table-responsive">
                      <table class="display" id="basic-1">
                        <thead>
	                        
                          <tr>
                            <th>ID</th>
                            <th>MESSAGE_ID</th>
                            <th>ACTION</th>
                            
                          </tr>
                          
                        </thead>
                        
                        <tbody>
	                        
	                      <?
		                      $sql = db::arr("SELECT * FROM `vd_project_items` WHERE PROJECT_ID='$_GET[item_id]' ");		                      
		                      
		                      foreach ($sql as $v):
	                      ?>
                          <tr>
                            <td><?=$v['ID']?></td>
                            <td><?=$v['MESSAGE_ID']?></td>                 
                            <td>
							
											
							<button onclick="send_item('<?=$v['ID']?>')" class = "btn btn-sm btn-success" style="margin-right: 5px;"> <i class = "fa fa-eye"></i>&nbspПосмотреть</button>
							
							
							<button class = "btn bnt-sm btn-danger" onclick="delete_item('<?=$v['ID']?>')"> <i class = "fa fa-trash"></i>&nbspУдалить</button>
							
							</td>                            
                          </tr>
                          
                          <? endforeach;?>
                          
                        </tbody>
                      </table>
                    </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Individual column searching (text inputs) Ends-->			  
			  
			  
			  <!-- Individual column searching (text inputs) Starts-->
              <div class="col-xxl-12 box-col-12">
                <div class="card">
                  <div class="card-header pb-0">
                    <h5>Просмотры </h5>
                  </div>
                  <div class="card-body">
                    <div class="row">
                    <div class="table-responsive">
                      <table class="display" id="basic-2">
                        <thead>
	                        
                          <tr>
                            <th>ID</th>
                            <th>CREATED_DATE</th>
                            <th>NAME</th>                                              
                            <th>PHONE_NUMBER</th>
                            <!--<th>ACTION</th>-->
                            
                          </tr>
                          
                        </thead>
                        
                        <tbody>
	                        
	                      <?
		                      $sql = db::arr("SELECT * FROM `vd_project_users` WHERE PROJECT_ID='$_GET[item_id]' ");		                      
		                      
		                      foreach ($sql as $v):
	                      ?>
                          <tr>
                            <td><?=$v['ID']?></td>
                            <td><?=$v['CREATED_DATE']?></td>
                            <td><?=$v['NAME']?></td>                           
                            <td><?=$v['PHONE_NUMBER']?></td>                           
                           
						   <?/*
                            <td>							
							<button class = "btn bnt-sm btn-danger" onclick="delete_item('<?=$v['ID']?>')"> <i class = "fa fa-trash"></i>&nbspУдалить</button>							
							</td>
							*/?>							
							
                          </tr>
                          
                          <? endforeach;?>
                          
                        </tbody>
                      </table>
                    </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Individual column searching (text inputs) Ends-->
			  
			  
         
            </div>
          </div>
          
          <!-- Container-fluid Ends-->
 
<script>
$(document).ready(function () {
	
send_item = function (id) {

$('[name=send_item_id]').val(id);	
$('#send_item').modal("show");	
	
}

delete_item  = function (id) {
    $('[name=del_item_id]').val(id);
    $('#del_item').modal("show");
}


js_send_item = function () {

phone = $('[name=send_item_phone]').val();	
item_id = $('[name=send_item_id]').val();


formData = new FormData();
formData.append('phone',phone);
formData.append('item_id',item_id);
formData.append('project_id','<?=$_SESSION['item_id']?>');

js_ajax_post('projects/send_item.php',formData).done(function (data){

$('#js_send_item_content').html(data);	
	
	
});	

}

js_add_item = function () {

phone = $('[name=add_item_phone]').val();	
formData = new FormData();
formData.append('phone',phone);
formData.append('project_id','<?=$_SESSION['item_id']?>');


js_ajax_post('projects/add_item.php',formData).done(function (data){

$('#js_add_item_content').html(data);	
	
	
});	

}
	
	
	
	
});
</script>
 


<!--  START ADD MODAL  -->

 <div class="modal fade" id="add_item" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="add_item">Добавить</h5>
          <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
	
        <div class="modal-body">
		
		<div class = "mb-3">
			<label class="form-label">PHONE_NUMBER</label>
			<div class="input-group">			
				<input type = "text" class="form-control" name = "add_item_phone" required>
			</div>
		</div>		
		
		<div class = "mb-3" id="js_add_item_content">
					

		</div>
		
		</div>
        <div class="modal-footer">          
          <button class="btn btn-secondary" onclick="js_add_item()" name = "add_item" type="button">Отправить</button>
		  <button class="btn btn-primary" type="button" data-bs-dismiss="modal">Закрыть</button>
        </div>
		
      </div>
    </div>
</div>
<!-- END ADD MODAL  --> 


<div class="modal fade" id="send_item" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="add_item">Отправить</h5>
          <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
		
        <div class="modal-body">
		
		<div class = "mb-3">
			<label class="form-label">PHONE_NUMBER</label>
			<div class="input-group">			
				<input type = "text" class="form-control" name = "send_item_phone" required>
			</div>
		</div>
		
		<input type="hidden" name="send_item_id">
		
		<div class = "mb-3" id="js_send_item_content">
					

		</div>
		
		
		
		</div>
        <div class="modal-footer">          
          <button class="btn btn-secondary" onclick="js_send_item()" name = "add_item" type="button">Отправить</button>
		  
		  <button class="btn btn-primary" type="button" data-bs-dismiss="modal">Закрыть</button>
        </div>
	
      </div>
    </div>
</div>
<!-- END ADD MODAL  -->
	 
	
<!--  START DELETE MODAL  -->

 <div class="modal fade" id="del_item" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="del_item">Удалить</h5>
          <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
		<form method = "post">
        <div class="modal-body">
			<p style="text-align:center; font-size: 16px; margin-bottom: 0px !important; margin-top:10px;">Вы действительно хотите удалить этот элемент ?</p>
		<input type = "hidden" name = "del_item_id">
		</div>
        <div class="modal-footer">          
          <button class="btn btn-secondary" name = "del_item" type="submit">Удалить</button>
		  <button class="btn btn-primary" type="button" data-bs-dismiss="modal">Закрыть</button>
        </div>
		</form>
      </div>
    </div>
</div>

<!-- END DELETE MODAL  -->
	


     
        
<? //require('modules/viho/projects/projects_js.php');?>
<? //require('modules/viho/projects/projects_modals.php');?> 
          
          
          