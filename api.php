<?php include("includes/connection.php");
 	  include("includes/function.php"); 
	   	  include("smtp_email.php");

	
	  if( isset($_SERVER['HTTPS'] ) ) 
	  {  

	    $file_path = 'https://'.$_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']).'/'; 	  
	  }
	  else
	  {
	    $file_path = 'http://'.$_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']).'/'; 	  
	  }
	
	
  function get_user_name($user_id)
	{
 		global $mysqli;

	 	$user_qry="SELECT * FROM tbl_users where id='".$user_id."'";
		$user_result=mysqli_query($mysqli,$user_qry);
		$user_row=mysqli_fetch_assoc($user_result);
 
		return $user_row['name'];
	 }
  
  function get_total_item($cat_id)
  { 
    global $mysqli;   

    $qry_places="SELECT COUNT(*) as num FROM tbl_places WHERE p_cat_id='".$cat_id."'";
     
    $total_places = mysqli_fetch_array(mysqli_query($mysqli,$qry_places));
    $total_places = $total_places['num'];
     
    return $total_places;

  }


  $get_method = checkSignSalt($_POST['data']);
	
   
  if($get_method['method_name']=="get_home")	
  {

		$jsonObj_2= array();	

       $cid=API_CAT_ORDER_BY;


	    $query2="SELECT cid,category_name,category_image FROM tbl_category ORDER BY tbl_category.".$cid."";
		$sql2 = mysqli_query($mysqli,$query2)or die(mysql_error());

		while($data2 = mysqli_fetch_assoc($sql2))
		{
			
			$row2['cid'] = $data2['cid'];
			$row2['category_name'] = $data2['category_name'];
			$row2['category_image'] = $file_path.'images/'.$data2['category_image'];
			$row2['category_image_thumb'] = $file_path.'images/thumbs/'.$data2['category_image'];
 			$row2['total_places'] = get_total_item($row2['cid']);

			array_push($jsonObj_2,$row2);
		
		}

            $row['cat_list']=$jsonObj_2; 

		    $set['Place_App'] = $row;
			header( 'Content-Type: application/json; charset=utf-8' );
		    echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE));
			die();
 
  }	  
 else if($get_method['method_name']=="get_all_places")		
  {
 
        $page_limit=10;
			
		$limit=($get_method['page']-1) * $page_limit;
		$jsonObj= array();	
	
	    $query="SELECT * FROM tbl_places
		LEFT JOIN tbl_category ON tbl_places.p_cat_id= tbl_category.cid 
		where tbl_places.place_status='1' ORDER BY tbl_places.p_id DESC LIMIT $limit,$page_limit";

		$sql = mysqli_query($mysqli,$query);

		while($data = mysqli_fetch_assoc($sql))
		{	
			 				 
				$row['p_id'] = $data['p_id'];
				$row['p_cat_id'] = $data['p_cat_id'];
				$row['place_name'] = $data['place_name'];
				$row['place_image'] = $file_path.'images/'.$data['place_image'];
				$row['place_thumb_image'] = $file_path.'images/thumb/'.$data['place_image'];
				$row['place_video'] = $data['place_video'];
				$row['place_description'] = $data['place_description'];
				$row['place_address'] = $data['place_address'];
				$row['place_email'] = $data['place_email'];
				$row['place_phone'] = $data['place_phone'];
				$row['place_website'] = $data['place_website'];
				$row['place_map_latitude'] = $data['place_map_latitude'];
				$row['place_map_longitude'] = $data['place_map_longitude'];
				$row['place_status'] = $data['place_status'];
				$row['place_rate_avg'] = $data['place_rate_avg'];
				$row['place_total_rate'] = $data['place_total_rate'];
 
				$row['cid'] = $data['cid'];
				$row['category_name'] = $data['category_name'];
				$row['category_image'] = $file_path.'images/'.$data['category_image'];
				

			array_push($jsonObj,$row);
		
			}

			$set['Place_App'] = $jsonObj;
		
			header( 'Content-Type: application/json; charset=utf-8' );
		    echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE));
			die();
 
	}
else if($get_method['method_name']=="get_latest_places")		
	{
 
		$jsonObj= array();	
   
		$query="SELECT * FROM tbl_places
		LEFT JOIN tbl_category ON tbl_places.p_cat_id= tbl_category.cid 
		WHERE tbl_places.place_status='1' ORDER BY tbl_places.p_id DESC LIMIT 5";

		$sql = mysqli_query($mysqli,$query);

		while($data = mysqli_fetch_assoc($sql))
		{ 
				$row['p_id'] = $data['p_id'];
				$row['p_cat_id'] = $data['p_cat_id'];
				$row['place_name'] = $data['place_name'];
				$row['place_image'] = $file_path.'images/'.$data['place_image'];
				$row['place_thumb_image'] = $file_path.'images/thumb/'.$data['place_image'];
				$row['place_video'] = $data['place_video'];
				$row['place_description'] = $data['place_description'];
				$row['place_address'] = $data['place_address'];
				$row['place_email'] = $data['place_email'];
				$row['place_phone'] = $data['place_phone'];
				$row['place_website'] = $data['place_website'];
				$row['place_map_latitude'] = $data['place_map_latitude'];
				$row['place_map_longitude'] = $data['place_map_longitude'];
				$row['place_status'] = $data['place_status'];
				$row['place_rate_avg'] = $data['place_rate_avg'];
				$row['place_total_rate'] = $data['place_total_rate'];
 
				$row['cid'] = $data['cid'];
				$row['category_name'] = $data['category_name'];
				$row['category_image'] = $file_path.'images/'.$data['category_image'];
				
			array_push($jsonObj,$row);
		
		}

		$set['Place_App'] = $jsonObj;
		
			header( 'Content-Type: application/json; charset=utf-8' );
		     echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE));
			die();
 
	} 
 else if($get_method['method_name']=="get_nearby_place")		
	{
		  
		  $post_order_by=API_CAT_POST_ORDER_BY;
	
		  $cat_id=$get_method['cat_id'];		
 
		  $jsonObj= array();
		
			//$query="SELECT * FROM tbl_places,tbl_category WHERE tbl_places.place_status='1' AND tbl_places.p_cat_id= tbl_category.cid AND tbl_places.p_cat_id IN (".$cat_ids.") ORDER BY tbl_places.p_id ".$post_order_by."";


			$latitude = $get_method['user_lat'];
	        $longitude = $get_method['user_long'];

	        $distance_limit = $get_method['distance_limit'];

	        $earthRadius = '6371.0'; // In miles(3959)  
	        

	         $sql = mysqli_query($mysqli,"
	                SELECT p.*,c.*,
	                    ROUND(
	                        $earthRadius * ACOS(  
	                            SIN( $latitude*PI()/180 ) * SIN( place_map_latitude*PI()/180 )
	                            + COS( $latitude*PI()/180 ) * COS( place_map_latitude*PI()/180 )  *  COS( (place_map_longitude*PI()/180) - ($longitude*PI()/180) )   ) 
	                    , 1)
	                    AS distance                              
	                                      
	                FROM
	                    tbl_places p,tbl_category c
	                WHERE p.p_cat_id= c.cid AND  p.place_status='1' AND	p.p_cat_id IN (".$cat_id.")      
	                ORDER BY
	                    distance");
	       
	        

			while($data = mysqli_fetch_assoc($sql))
			{
			       
				if(round($data['distance']) <=$distance_limit)
				{
					$row['p_id'] = $data['p_id'];
					$row['p_cat_id'] = $data['p_cat_id'];
					$row['place_name'] = $data['place_name'];
					$row['place_image'] = $file_path.'images/'.$data['place_image'];
					$row['place_thumb_image'] = $file_path.'images/thumb/'.$data['place_image'];
					$row['place_video'] = $data['place_video'];
					$row['place_description'] = $data['place_description'];
					$row['place_address'] = $data['place_address'];
					$row['place_email'] = $data['place_email'];
					$row['place_phone'] = $data['place_phone'];
					$row['place_website'] = $data['place_website'];
					$row['place_map_latitude'] = $data['place_map_latitude'];
					$row['place_map_longitude'] = $data['place_map_longitude'];
					$row['place_status'] = $data['place_status'];
					$row['place_rate_avg'] = $data['place_rate_avg'];
					$row['place_total_rate'] = $data['place_total_rate'];

					$row['place_distance'] = $data['distance'].'Km'; 
    
    				$m  = $row['place_distance']*1000; // amount of "full" meters"
    				//$cm = $rkm % 100; // rest
    
    				$row['place_distance_m'] = $m.' MT'; 
	 
					$row['cid'] = $data['cid'];
					$row['category_name'] = $data['category_name'];
					$row['category_image'] = $file_path.'images/'.$data['category_image'];				     
    				   
      				 
    			    array_push($jsonObj,$row);
			 	}
			    
			   //array_push($jsonObj,$row); 
			    
			}

			$set['Place_App'] = $jsonObj;
			header( 'Content-Type: application/json; charset=utf-8' );
		     echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE));
			die();
		
	}	
  else if($get_method['method_name']=="get_place_by_cat_id")
	{
		  
		  $page_limit=10;
			
		  $limit=($get_method['page']-1) * $page_limit;
		
		  $post_order_by=API_CAT_POST_ORDER_BY;
	
		  $cat_id=$get_method['cat_id'];		

		 
		 $jsonObj= array();
		
		$query="SELECT * FROM tbl_places,tbl_category WHERE tbl_places.p_cat_id= tbl_category.cid and tbl_places.p_cat_id ='".$cat_id."' ORDER BY tbl_places.p_id ".$post_order_by." LIMIT $limit,$page_limit";


			$sql = mysqli_query($mysqli,$query);

			while($data = mysqli_fetch_assoc($sql))
			{
				 
				 
				$row['p_id'] = $data['p_id'];
				$row['p_cat_id'] = $data['p_cat_id'];
				$row['place_name'] = $data['place_name'];
				$row['place_image'] = $file_path.'images/'.$data['place_image'];
				$row['place_thumb_image'] = $file_path.'images/thumb/'.$data['place_image'];
				$row['place_video'] = $data['place_video'];
				$row['place_description'] = $data['place_description'];
				$row['place_address'] = $data['place_address'];
				$row['place_email'] = $data['place_email'];
				$row['place_phone'] = $data['place_phone'];
				$row['place_website'] = $data['place_website'];
				$row['place_map_latitude'] = $data['place_map_latitude'];
				$row['place_map_longitude'] = $data['place_map_longitude'];
				$row['place_status'] = $data['place_status'];
				$row['place_rate_avg'] = $data['place_rate_avg'];
				$row['place_total_rate'] = $data['place_total_rate'];
 
				$row['cid'] = $data['cid'];
				$row['category_name'] = $data['category_name'];
				$row['category_image'] = $file_path.'images/'.$data['category_image'];
				 
				array_push($jsonObj,$row);
			
			}

			$set['Place_App'] = $jsonObj;
			header( 'Content-Type: application/json; charset=utf-8' );
		    echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE));
			die();
 
		
	}	
    else if($get_method['method_name']=="get_single_place")
	{

		    $jsonObj= array();
		
			//$query="SELECT * FROM tbl_places,tbl_category WHERE tbl_places.place_status='1' AND tbl_places.p_cat_id= tbl_category.cid AND tbl_places.p_cat_id IN (".$cat_ids.") ORDER BY tbl_places.p_id ".$post_order_by."";


			$latitude = $get_method['user_lat'];
	        $longitude = $get_method['user_long'];

	        $earthRadius = '6371.0'; // In miles(3959)  
	        

	        $sql = mysqli_query($mysqli,"
	                SELECT p.*,c.*,
	                    ROUND(
	                        $earthRadius * ACOS(  
	                            SIN( $latitude*PI()/180 ) * SIN( place_map_latitude*PI()/180 )
	                            + COS( $latitude*PI()/180 ) * COS( place_map_latitude*PI()/180 )  *  COS( (place_map_longitude*PI()/180) - ($longitude*PI()/180) )   ) 
	                    , 1)
	                    AS distance                              
	                                      
	                FROM
	                    tbl_places p,tbl_category c
	                WHERE p.p_cat_id= c.cid AND  p.place_status='1' AND	p.p_id='".$get_method['place_id']."'                
	                ORDER BY
	                    distance");

			while($data = mysqli_fetch_assoc($sql))
			{
				 
				$row['p_id'] = $data['p_id'];
				$row['p_cat_id'] = $data['p_cat_id'];
				$row['place_name'] = $data['place_name'];
				$row['place_image'] = $file_path.'images/'.$data['place_image'];
				$row['place_thumb_image'] = $file_path.'images/thumb/'.$data['place_image'];
				$row['place_video'] = $data['place_video'];
				$row['place_description'] = $data['place_description'];
				$row['place_address'] = $data['place_address'];
				$row['place_email'] = $data['place_email'];
				$row['place_phone'] = $data['place_phone'];
				$row['place_website'] = $data['place_website'];
				$row['place_map_latitude'] = $data['place_map_latitude'];
				$row['place_map_longitude'] = $data['place_map_longitude'];
				$row['place_status'] = $data['place_status'];
				$row['place_rate_avg'] = $data['place_rate_avg'];
				$row['place_total_rate'] = $data['place_total_rate'];
				 
				$row['place_distance'] = $data['distance'].'Km'; 

				$m  = $row['place_distance']*1000; // amount of "full" meters"
				//$cm = $rkm % 100; // rest

				$row['place_distance_m'] = $m.' MT'; 

				$row['category_map_icon'] = $file_path.'images/'.$data['category_map_icon'];
				$row['cid'] = $data['cid'];
				$row['category_name'] = $data['category_name'];
				$row['category_image'] = $file_path.'images/'.$data['category_image'];
 				  

			$wall_query="SELECT * FROM tbl_place_gallery WHERE place_id='".$get_method['place_id']."'";

			$wall_sql = mysqli_query($mysqli,$wall_query);

			if($wall_sql->num_rows > 0)
		   {	
				while($wall_data = mysqli_fetch_assoc($wall_sql))
				{
					$row1['image_name'] = $file_path.'images/gallery/'.$wall_data['image_name'];
					 
					$row['gallery'][]=$row1;
				}

			}
			else
			{
				$row['gallery']=array();
			}
			  //Rating
		      $qry1="SELECT * FROM tbl_rating WHERE post_id='".$get_method['place_id']."'";
		      $result1=mysqli_query($mysqli,$qry1); 

		      if($result1->num_rows > 0)
		      {
		      		while ($user_rating=mysqli_fetch_array($result1)) {
 		      	
		 		      	$row3['id'] = $user_rating['id'];
		 		      	//$row3['place_id'] = $user_rating['place_id'];
		 		      	//$row3['user_id'] = $user_rating['user_id'];
 		 		      	$row3['user_name'] = get_user_name($user_rating['user_id']);
 		 		      	//$row3['ip'] =$user_rating['ip'];
 		 		      	$row3['rate'] =$user_rating['rate'];
		 		      	//$row3['dt_rate'] = date('d M Y',strtotime($user_rating['dt_rate']));
 		 		      	$row3['message'] = $user_rating['message'];

		 		      	$row['Ratings'][]= $row3;
				      }
		     
		      }
		      else
		      {	
		      		 
		      		$row['Ratings'][]= '';
		      }
			
				array_push($jsonObj,$row);
			
			}

		

			$set['Place_App'] = $jsonObj;
			header( 'Content-Type: application/json; charset=utf-8' );
		     echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE));
			die();


	
	}  
	
  else if($get_method['method_name']=="user_register")
	{
	
		$qry = "SELECT * FROM tbl_users WHERE email = '".$get_method['email']."'"; 

		$result = mysqli_query($mysqli,$qry);
		$row = mysqli_fetch_assoc($result);
		
		if($row['email']!="")
		{
			$set['Place_App'][]=array('msg' => "Email address already used!",'success'=>'0');
		}
		else
		{ 
 				$data = array(
				    'name'  => $get_method['name'],				    
					'email'  =>  $get_method['email'],
					'password'  =>  $get_method['password'],
					'phone'  =>  $get_method['phone'], 
					);		
 			 

			$qry = Insert('tbl_users',$data);									 
					 
				
			$set['Place_App'][]=array('msg' => "Register successflly...!",'success'=>'1');
					
		}
				 
		     header( 'Content-Type: application/json; charset=utf-8' );
		     echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE));
			  die();

		}
  else if($get_method['method_name']=="user_login")

	{
		
	    $email = $get_method['email'];
 		$password = $get_method['password'];

	    $qry = "SELECT * FROM tbl_users WHERE  email = '".$email."' and password = '".$password."'";
		$result = mysqli_query($mysqli,$qry);
		$num_rows = mysqli_num_rows($result);
 		$row = mysqli_fetch_assoc($result);
		
    if ($num_rows > 0)
		{ 
				if($row['status']==0)
				{
					$set['Place_App'][]=array('msg' =>'Your account blocked!','success'=>'0');
				}	
				else
				{
					$set['Place_App'][]=array('user_id' => $row['id'],'name'=>$row['name'],'email'=>$row['email'],'success'=>'1');
				} 
			     
 			 
		}		 
		else
		{
				 
 				$set['Place_App'][]=array('msg' =>'Login failed','success'=>'0');
 		}


	
		      header( 'Content-Type: application/json; charset=utf-8' );
		     echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE));
			  die();

	
	}
	
	 else if($get_method['method_name']=="user_profile")

	{
		
		$qry = "SELECT * FROM tbl_users WHERE id = '".$get_method['user_id']."'"; 
		$result = mysqli_query($mysqli,$qry);
		 
		$row = mysqli_fetch_assoc($result);
	  				 
	    $set['Place_App'][]=array('user_id' => $row['id'],'name'=>$row['name'],'email'=>$row['email'],'phone'=>$row['phone'],'success'=>'1');


	
 				header( 'Content-Type: application/json; charset=utf-8' );
		     echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE));
			  die();

	
	}
	
  else if($get_method['method_name']=="user_profile_update")
	{
		if($get_method['password']!="")
		{
			$user_edit= "UPDATE tbl_users SET name='".$get_method['name']."',email='".$get_method['email']."',password='".$get_method['password']."',phone='".$get_method['phone']."' WHERE id = '".$get_method['user_id']."'";	 
		}
		else
		{
			$user_edit= "UPDATE tbl_users SET name='".$get_method['name']."',email='".$get_method['email']."',phone='".$get_method['phone']."' WHERE id = '".$get_method['user_id']."'";	 
		}
   		
   		$user_res = mysqli_query($mysqli,$user_edit);	
	  				 
		$set['Place_App'][]=array('msg'=>'Updated','success'=>'1');

		    header( 'Content-Type: application/json; charset=utf-8' );
		     echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE));
			  die();

	
	}
	
  else if($get_method['method_name']=="forgot_pass")
  {
  		$host = $_SERVER['HTTP_HOST'];
		preg_match("/[^\.\/]+\.[^\.\/]+$/", $host, $matches);
        $domain_name=$matches[0];
         
	 	 
		$qry = "SELECT * FROM tbl_users WHERE email = '".$get_method['user_email']."'"; 
		$result = mysqli_query($mysqli,$qry);
		$row = mysqli_fetch_assoc($result);
		
		if($row['email']!="")
		{
 
			$to = $row['email'];
			$recipient_name=$row['name'];
			// subject
			$subject = '[IMPORTANT] '.APP_NAME.' Forgot Password Information';
 			
			$message='<div style="background-color: #f9f9f9;" align="center"><br />
					  <table style="font-family: OpenSans,sans-serif; color: #666666;" border="0" width="600" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF">
					    <tbody>
					      <tr>
					        <td colspan="2" bgcolor="#FFFFFF" align="center"><img src="http://'.$_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']).'/images/'.APP_LOGO.'" alt="header" /></td>
					      </tr>
					      <tr>
					        <td width="600" valign="top" bgcolor="#FFFFFF"><br>
					          <table style="font-family:OpenSans,sans-serif; color: #666666; font-size: 10px; padding: 15px;" border="0" width="100%" cellspacing="0" cellpadding="0" align="left">
					            <tbody>
					              <tr>
					                <td valign="top"><table border="0" align="left" cellpadding="0" cellspacing="0" style="font-family:OpenSans,sans-serif; color: #666666; font-size: 10px; width:100%;">
					                    <tbody>
					                      <tr>
					                        <td><p style="color: #262626; font-size: 28px; margin-top:0px;"><strong>Dear '.$row['name'].'</strong></p>
					                          <p style="color:#262626; font-size:20px; line-height:32px;font-weight:500;">Thank you for using '.APP_NAME.',<br>
					                            Your password is: '.$row['password'].'</p>
					                          <p style="color:#262626; font-size:20px; line-height:32px;font-weight:500;margin-bottom:30px;">Thanks you,<br />
					                            '.APP_NAME.'.</p></td>
					                      </tr>
					                    </tbody>
					                  </table></td>
					              </tr>
					               
					            </tbody>
					          </table></td>
					      </tr>
					      <tr>
					        <td style="color: #262626; padding: 20px 0; font-size: 20px; border-top:5px solid #52bfd3;" colspan="2" align="center" bgcolor="#ffffff">Copyright © '.APP_NAME.'.</td>
					      </tr>
					    </tbody>
					  </table>
					</div>';

			send_email($to,$recipient_name,$subject,$message);

			 	  
			$set['Place_App'][]=array('msg' => "Password has been sent on your mail!",'success'=>'1');
		}
		else
		{  	 
				
			$set['Place_App'][]=array('msg' => "Email not found in our database!",'success'=>'0');
					
		}

	   		header( 'Content-Type: application/json; charset=utf-8' );
		     echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE));
			  die();

  				}
       
	   else if($get_method['method_name']=="place_ratings")
		{
	      $ip = $get_method['ip'];
	      $post_id = $get_method['post_id'];
	      $user_id = $get_method['user_id'];
	      $therate = $get_method['rate'];
          $message = $get_method['message'];
	  
	      $query1 = mysqli_query($mysqli,"select * from tbl_rating where post_id = '$post_id' AND user_id = '$user_id'"); 
	      while($data1 = mysqli_fetch_assoc($query1)){
	        $rate_db1[] = $data1;
	      }
	      if(@count($rate_db1) == 0 ){
	      	 
	          
	  		$qry1="INSERT INTO tbl_rating (`post_id`,`user_id`,`rate`,`ip`,`message`) VALUES ('".$post_id."','".$user_id."','".$therate."','".$ip."','".$message."')"; 
            $result1=mysqli_query($mysqli,$qry1);  
	      
	          //Total rate result
	           
	        $query = mysqli_query($mysqli,"select * from tbl_rating where post_id  = '$post_id' ");
	               
	         while($data = mysqli_fetch_assoc($query)){
	                    $rate_db[] = $data;
	                    $sum_rates[] = $data['rate'];
	               
	                }
	        
	                if(@count($rate_db)){
	                    $rate_times = count($rate_db);
	                    $sum_rates = array_sum($sum_rates);
	                    $rate_value = $sum_rates/$rate_times;
	                    $rate_bg = (($rate_value)/5)*100;
	                }else{
	                    $rate_times = 0;
	                    $rate_value = 0;
	                    $rate_bg = 0;
	                }
	         
	        $rate_avg=round($rate_value); 
	        
		  $sql="update tbl_places set place_total_rate=place_total_rate + 1,place_rate_avg='$rate_avg' where p_id='".$post_id."'";
	      mysqli_query($mysqli,$sql);
	        
	      $total_rat_sql="SELECT * FROM tbl_places WHERE p_id='".$post_id."'";
	      $total_rat_res=mysqli_query($mysqli,$total_rat_sql);
	      $total_rat_row=mysqli_fetch_assoc($total_rat_res);
	    
	         
	        $set['Place_App'][]=array('msg' => "You have succesfully rated",'success'=>'1');
	        
	      }else{
	                
	 
	        $set['Place_App'][]=array('msg' => "You have already rated",'success'=>'0');
	      }

	         header( 'Content-Type: application/json; charset=utf-8' );
		     echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE));
			 die();

 			 }
	   else if($get_method['method_name']=="get_search_place")
		
		  {
		
		$jsonObj= array();	
   
		$query="SELECT * FROM tbl_places
		LEFT JOIN tbl_category ON tbl_places.p_cat_id= tbl_category.cid
		WHERE tbl_places.place_status='1' AND tbl_places.place_name like '%".addslashes($get_method['search_text'])."%' 
		ORDER BY tbl_places.place_name";

		$sql = mysqli_query($mysqli,$query);

		while($data = mysqli_fetch_assoc($sql))
		{
			$row['p_id'] = $data['p_id'];
				$row['p_cat_id'] = $data['p_cat_id'];
				$row['place_name'] = $data['place_name'];
				$row['place_image'] = $file_path.'images/'.$data['place_image'];
				$row['place_thumb_image'] = $file_path.'images/thumb/'.$data['place_image'];
				$row['place_video'] = $data['place_video'];
				$row['place_description'] = $data['place_description'];
				$row['place_address'] = $data['place_address'];
				$row['place_email'] = $data['place_email'];
				$row['place_phone'] = $data['place_phone'];
				$row['place_website'] = $data['place_website'];
				$row['place_map_latitude'] = $data['place_map_latitude'];
				$row['place_map_longitude'] = $data['place_map_longitude'];
				$row['place_status'] = $data['place_status'];
				$row['place_rate_avg'] = $data['place_rate_avg'];
				$row['place_total_rate'] = $data['place_total_rate'];


				$row['cid'] = $data['cid'];
				$row['category_name'] = $data['category_name'];
				$row['category_image'] = $file_path.'images/'.$data['category_image'];
				$row['category_image_thumb'] = $file_path.'images/thumbs/'.$data['category_image'];			
				
				

			array_push($jsonObj,$row);
		
		}

		$set['Place_App'] = $jsonObj;
		
		header( 'Content-Type: application/json; charset=utf-8' );
	    echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
		die();

	}
    
	
  else if($get_method['method_name']=="get_app_details")
	{
		  
		  $jsonObj= array();	

		$query="SELECT * FROM tbl_settings WHERE id='1'";
		$sql = mysqli_query($mysqli,$query)or die(mysqli_error());


		while($data = mysqli_fetch_assoc($sql))
		{
			 
			$row['package_name'] = $data['package_name'];
			$row['ios_bundle_identifier'] = $data['ios_bundle_identifier'];
			
			$row['app_name'] = $data['app_name'];
			$row['app_logo'] = $data['app_logo'];
			$row['app_version'] = $data['app_version'];
			$row['app_author'] = $data['app_author'];
			$row['app_contact'] = $data['app_contact'];
			$row['app_email'] = $data['app_email'];
			$row['app_website'] = $data['app_website'];
			$row['app_description'] = stripslashes($data['app_description']);
			$row['app_developed_by'] = $data['app_developed_by'];

			$row['app_privacy_policy'] = stripslashes($data['app_privacy_policy']);
 
			$row['publisher_id'] = $data['publisher_id'];
			$row['interstital_ad'] = $data['interstital_ad'];
			$row['interstital_ad_id'] = $data['interstital_ad_id'];
			$row['interstital_ad_click'] = $data['interstital_ad_click'];
  			$row['banner_ad'] = $data['banner_ad'];
 			$row['banner_ad_id'] = $data['banner_ad_id'];
 			
 			$row['publisher_id_ios'] = $data['publisher_id_ios'];
 			$row['app_id_ios'] = $data['app_id_ios'];
			$row['interstital_ad_ios'] = $data['interstital_ad_ios'];
			$row['interstital_ad_id_ios'] = $data['interstital_ad_id_ios'];
			$row['interstital_ad_click_ios'] = $data['interstital_ad_click_ios'];
 			$row['banner_ad_ios'] = $data['banner_ad_ios'];
 			$row['banner_ad_id_ios'] = $data['banner_ad_id_ios'];
 				
			array_push($jsonObj,$row);
		
		}



		   $set['Place_App'] = $jsonObj;
			header( 'Content-Type: application/json; charset=utf-8' );
		     echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE));
			die();
	
	}
  else if($get_method['method_name']=="get_category")
  {
  		$jsonObj= array();
		
		$cid=API_CAT_ORDER_BY;


		$query="SELECT cid,category_name,category_image FROM tbl_category ORDER BY tbl_category.".$cid." ASC";
		$sql = mysqli_query($mysqli,$query);

		while($data = mysqli_fetch_assoc($sql))
		{
			
			$row['cid'] = $data['cid'];
			$row['category_name'] = $data['category_name'];
			$row['category_image'] = $file_path.'images/'.$data['category_image'];
			$row['category_image_thumb'] = $file_path.'images/thumbs/'.$data['category_image'];
			 

			array_push($jsonObj,$row);
		
		}
		      $set['Place_App'] = $jsonObj;
			  
			 header( 'Content-Type: application/json; charset=utf-8' );
		     echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE));
			 die();
	
  }	  else
  {
  		$get_method = checkSignSalt($_POST['data']);
  }
		 
?>