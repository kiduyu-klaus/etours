<?php include('includes/header.php'); 

    include('includes/function.php');
	include('language/language.php');  


	if(isset($_POST['places_search']))
	 {
		 
		
		$places_qry="SELECT * FROM tbl_places,tbl_category WHERE tbl_places.p_cat_id= tbl_category.cid and   tbl_places.place_name like '%".addslashes($_POST['place_name'])."%' ORDER BY tbl_places.p_id DESC";  
							 
		$result=mysqli_query($mysqli,$places_qry);
		
		 
	 }
	 else
	 {
	 
							$tableName="tbl_places";		
							$targetpage = "manage_places.php"; 	
							$limit = 12; 
							
							$query ="SELECT COUNT(*) as num FROM tbl_places
                  					  LEFT JOIN tbl_category ON tbl_places.p_cat_id= tbl_category.cid";
							$total_pages = mysqli_fetch_array(mysqli_query($mysqli,$query));
							$total_pages = $total_pages['num'];
							 
							
							$stages = 3;
							$page=0;
							if(isset($_GET['page'])){
							$page = mysqli_real_escape_string($mysqli,$_GET['page']);
							}
							if($page){
								$start = ($page - 1) * $limit; 
							}else{
								$start = 0;	
								}	
							
							
						 $places_qry="SELECT * FROM tbl_places
							LEFT JOIN tbl_category ON tbl_places.p_cat_id= tbl_category.cid
						 ORDER BY tbl_places.p_id DESC LIMIT $start, $limit";
							 
							$result=mysqli_query($mysqli,$places_qry);
							
	 }
	if(isset($_GET['place_id']))
	{
		Delete('tbl_place_gallery','place_id='.$_GET['place_id'].'');  
		 
		$img_res=mysqli_query($mysqli,'SELECT * FROM tbl_places WHERE p_id=\''.$_GET['place_id'].'\'');
		$img_row=mysqli_fetch_assoc($img_res);
			
		if($img_row['place_image']!="")
		{
			unlink('images/'.$img_row['place_image']);
			unlink('images/thumb/'.$img_row['place_image']);
			 
		}	

		Delete('tbl_places','p_id='.$_GET['place_id'].'');
		
		$_SESSION['msg']="12";
		header( "Location:manage_places.php");
		exit;
	}
	
	//Active and Deactive status
	if(isset($_GET['status_deactive_id']))
	{
		$data = array('place_status'  =>  '0');
		
		$edit_status=Update('tbl_places', $data, "WHERE p_id = '".$_GET['status_deactive_id']."'");
		
		 $_SESSION['msg']="14";
		 header( "Location:manage_places.php");
		 exit;
	}
	if(isset($_GET['status_active_id']))
	{
		$data = array('place_status'  =>  '1');
		
		$edit_status=Update('tbl_places', $data, "WHERE p_id = '".$_GET['status_active_id']."'");
		
		$_SESSION['msg']="13";
		 header( "Location:manage_places.php");
		 exit;
	}
	
	
?>


 <div class="row">
      <div class="col-xs-12">
        <div class="card mrg_bottom">
          <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title">Manage Places</div>
            </div>
            <div class="col-md-7 col-xs-12">              
                  <div class="search_list">
                    <div class="search_block">
                      <form  method="post" action="">
                        <input class="form-control input-sm" placeholder="Search place..." aria-controls="DataTables_Table_0" type="search" name="place_name" required>
                        <button type="submit" name="places_search" class="btn-search"><i class="fa fa-search"></i></button>
                      </form>  
                    </div>
                    <div class="add_btn_primary"> <a href="add_place.php">Add Place</a> </div>
                  </div>
                  
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="row mrg-top">
            <div class="col-md-12">
               
              <div class="col-md-12 col-sm-12">
                <?php if(isset($_SESSION['msg'])){?> 
               	 <div class="alert alert-success alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                	<?php echo $client_lang[$_SESSION['msg']] ; ?></a> </div>
                <?php unset($_SESSION['msg']);}?>	
              </div>
            </div>
          </div>
          <div class="col-md-12 mrg-top">
            <div class="row">
              <?php 
            $i=0;
            while($row=mysqli_fetch_array($result))
            {         
        ?>
              <div class="col-lg-3 col-sm-6 col-xs-12">
                <div class="block_wallpaper">
                  <div class="wall_category_block">
                    <h2><?php echo $row['category_name'];?></h2>              
                  </div>
                  <div class="wall_image_title">
                     <p><?php echo stripslashes($row['place_name']);?></p>
                    <ul>
                      
                      <li><a href="javascript:void(0)" data-toggle="tooltip" data-tooltip="<?php echo $row['place_total_rate'];?> Rating"><i class="fa fa-star"></i></a></li>

                      <li><a href="edit_place.php?place_id=<?php echo $row['p_id'];?>" data-toggle="tooltip" data-tooltip="Edit"><i class="fa fa-edit"></i></a></li>
                      <li><a href="manage_places.php?place_id=<?php echo $row['p_id'];?>" data-toggle="tooltip" data-tooltip="Delete" onclick="return confirm('Are you sure you want to delete this place?');"><i class="fa fa-trash"></i></a></li>

                      <?php if($row['place_status']!="0"){?>
                      <li><div class="row toggle_btn"><a href="manage_places.php?status_deactive_id=<?php echo $row['p_id'];?>" data-toggle="tooltip" data-tooltip="ENABLE"><img src="assets/images/btn_enabled.png" alt="wallpaper_1" /></a></div></li>

                      <?php }else{?>
                      
                      <li><div class="row toggle_btn"><a href="manage_places.php?status_active_id=<?php echo $row['p_id'];?>" data-toggle="tooltip" data-tooltip="DISABLE"><img src="assets/images/btn_disabled.png" alt="wallpaper_1" /></a></div></li>
                  
                      <?php }?>

                    </ul>
                  </div>
                  <span><img src="images/<?php echo $row['place_image'];?>" /></span>
                </div>
              </div>
          <?php
            
            $i++;
              }
        ?>     
         
       
      </div>
          </div>
          <div class="col-md-12 col-xs-12">
            <div class="pagination_item_block">
              <nav>

              	<?php if(!isset($_POST["places_search"])){ include("pagination.php");}?>                 
              </nav>
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>
    </div>     



<?php include('includes/footer.php');?>                  