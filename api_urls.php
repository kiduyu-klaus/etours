<?php include("includes/header.php");

   if( isset($_SERVER['HTTPS'] ) ) {  

    $file_path = 'https://'.$_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']).'/api.php';
  }
  else
  {
    $file_path = 'http://'.$_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']).'/api.php';
  }
?>
<div class="row">
      <div class="col-sm-12 col-xs-12">
     	 	<div class="card">
		        <div class="card-header">
		          Example API urls
		        </div>
       			    <div class="card-body no-padding">
         		
         			 <pre>
                <code class="html">
                <br><b>API URL</b>&nbsp; <?php echo $file_path;?>    

			     <br><b>Home</b>(Method: get_home)
                <br><b>All Places</b>(Method: get_all_places)(Parameter:page)
                <br><b>Latest Places</b>(Method: get_latest_places)
                <br><b>Category List</b>(Method: get_category)
                <br><b>Places list by Cat ID</b>(Method: get_place_by_cat_id)(Parameter:cat_id,page)
                <br><b>Single Place</b>(Method: get_single_place)(Parameter:place_id,user_lat,user_long)
                <br><b>Search Place</b>(Method: get_search_place)(Parameter:search_text)
                <br><b>Nearby Place</b>(Method: get_nearby_place)(Parameter:cat_id,user_lat,user_long,distance_limit)
                <br><b>Rating</b>(Method: place_ratings)(Parameter:post_id,user_id,rate,ip,message)
        				<br><b>User Register</b>(Method: user_register)(Parameter:name,email,password,phone)
                <br><b>User Login</b>(Method: user_login)(Parameter:email,password)
        				<br><b>User Profile</b>(Method: user_profile)(Parameter:user_id)
                <br><b>User Profile Update</b>(Method: user_profile_update)(Parameter:user_id,name,email,password,phone)
                <br><b>Forgot Password</b>(Method: forgot_pass)(Parameter:user_email)
                <br><b>App Details</b>(Method: get_app_details)
				</code> 
             </pre>
       		
       				</div>
          	</div>
        </div>
</div>
    <br/>
    <div class="clearfix"></div>
        
<?php include("includes/footer.php");?>       
