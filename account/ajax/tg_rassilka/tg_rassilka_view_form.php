<? require $_SERVER['DOCUMENT_ROOT'] . '/core/backend.php'; ?>

<?
$rassilka = db::arr_s("SELECT * FROM tg_rassilka WHERE ID = '$_POST[item_id]'");
?>



<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h4 class="modal-title" id="addModalLabel1">Jo'natma</h4>
      <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
      </button>
    </div>
    <form action="" method="post" id="addForm" enctype="multipart/form-data">
      <div class="modal-body">
        <div class="row">
          <? //echo '<pre>'; print_r($users); echo '</pre>';
          ?>
          <div class="col-sm-6 col-md-6 pc-bottom">
            <? $get_img = json_decode($rassilka['FILE_URL'], true); ?>
            <nav class="cs-img">
              <img class="img-fl" src="<?= $get_img['file'] ?>" alt="Product Thumnail">
            </nav>
          </div>
          <div class="col-sm-6 col-md-6 pc-bottom">
            <nav class="rectangle" style="max-height: 375px; overflow-y: auto;">
              <p>
                <span>
                  <b><?= $rassilka['TEXT']; ?></b>
                </span>
              </p>
            </nav>
          </div>
          <div class="card">
            <div class="card-body ">
			
            <div class="user_list_content"></div>
        
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Bekor qilish</button>
      </div>
    </form>
  </div>
</div>


<script>
$('document').ready(function (){

	
	
	
show_user_content= function(page_num,type){

//alert('test');	


if (type=='search'){	
keyword = $('[name=search_user]').val();}
else if (type=='first'){keyword='';
}else{
//keyword = '<?=$_SESSION['sklad_list_keyword']?>';
keyword = $('[name=search_user]').val();

}

var formData  = new FormData();
formData.append('rassilka_id','<?=$_POST['item_id']?>');
formData.append('keyword',keyword);
formData.append('page_num',page_num);

js_ajax_post('tg_rassilka/tg_rassilka_show_table.php',formData).done(function (data) {
//alert('test');
	
$('.user_list_content').html(data);});}

if ($('.user_list_content').html()==''){
	show_user_content(1,'first');
	
	}	
});
</script>

<!--  
  </div>
  <div class="col-sm-6 col-md-6" style="height: 550px; overflow-y: auto;"> 
-->

<style>
  .rectangle {
    border: 2px;
    padding: 10px;
    width: 360px;
    height: 375px;
    background-color: #F3F2F7;
    border-radius: 8px;
    margin-top: 20px;
    font-size: 16px;
  }

  .img-fl {
    margin-top: 20px;
    max-height: 375px;
    max-width: 375px;
    border-radius: 8px;
  }

  .pc-bottom {
    padding-bottom: 16px;
  }

  .td-custom {
    margin-left: 50px;
  }
</style>