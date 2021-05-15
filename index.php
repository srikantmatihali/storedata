<?php
require 'includes/dbfunctions.php';
$site  = new dbfunctions();
$siteurl = $site->siteurl;
$parameters=array('id'=>0,'permalink'=>0,'offset'=>0,'limit'=>5,'count'=>0);	
function uri_to_assoc($n){ //echo $n;die;	
		global $parameters; 
		global $response; //access the global variable
		$ct = preg_replace('/\/$/','',$n,1);
		$ct = preg_replace('/\//','',$ct,1);
		$final_url = explode('/',$ct); //exploed the url with /
		$final_url_count = count($final_url);
		$parameters['count']=$final_url_count;
		if($final_url_count>1)
		{
		$temp_key_array = array();
		$temp_value_array = array();
		$temp_array = array();
		for($i=2;$i<$final_url_count;$i = $i+2){ //only fetch the parameters key
		if(array_key_exists($final_url[$i], $parameters)) //Check whether parameter key present in config
		{		
			$temp_key_array[] .= $final_url[$i];
		}
		}
		//echo '<pre>';
		//print_r($temp_key_array);
		$j=0;
		for($i=3;$i<$final_url_count;$i = $i+2){ //only fetch the parameters key value			
			if(array_key_exists($temp_key_array[$j], $parameters)) //Check whether parameter key present in config
			{			 
			$parameters[$temp_key_array[$j]]=$final_url[$i];  //overide the config key value
			$temp_value_array[] .=$final_url[$i];
		}		
		$j++;
		}
		//echo count($temp_key_array).'<br/>';
		//echo count($temp_value_array).'<br/>';
		if(count($temp_key_array) != count($temp_value_array)) //pls check required parameter is empty
		{
		$response=201;
		}
		//print_r($temp_key_array);
		//print_r($temp_value_array);
		//echo 'bala'.$final_url[1];die;
		return $final_url[1];
		}		
}
$callback1	=	explode('?', $_SERVER['REQUEST_URI']);
$callback=$callback1[1]; 

if(isset($_GET['callback'])){
		

	$callback 	= 	$_GET['callback'];
	$request = 'callback=';
	$callback2	=	explode('&',$callback);
	$callback=$callback2[0]; 	
}


$url_server_path=str_replace($request,'',$_SERVER['REQUEST_URI']);
//echo $callback;die;*///die;//$url_server_path=str_replace($request,'',$_SERVER['REQUEST_URI']); //Get the current url
$url_server_path=$callback1[0];
/*echo '<pre>';print_r($_SERVER);die;
*/
$curent_file=uri_to_assoc($url_server_path); //call url to array function//echo $url_server_path;die;

$curent_file	=	explode('?', $curent_file); //print_r($curent_file);
$filename	=	$curent_file[0];
header('Content-Type: application/json');
switch($filename)
{

case 'category': 
		header('Content-Type: application/json');
		echo $site->categorydetails();
	break;

case 'productlisting': 	
		$catid = 1;
		$per_page = 1;
		$page = 1;		
		if($_GET){
			$catid = $_GET['catid'];
			$per_page = $_GET['limit'];
			$page = $_GET['page'];	
			echo $site->productlisting($catid,$page,$per_page);		
		}else{
			echo json_encode(array("message"=>"No Request","statuscode"=>404));
		}
		
	break;

case 'productdetail': 
		if($_GET){

			if(isset($_GET['id'])){
				$productid = $_GET['id'];
				echo $site->productdetails($productid);		
			}else{
			echo json_encode(array("message"=>"No Request","statuscode"=>404));
			}

		}
	break;

/** Handling adding to cart in sessions. 
 *  It can be handled using widgets or modules in different frameworks.
 *  Right now showing only demo of carts without using userid authentiation. 
 *  Inventory Management can be extended from here. I have done basic cart which will add infinite products and delete those products.
 * Its still incomplete. More work is to be done. This is the core module.
 */
case 'addcart':
		
		if($_GET){
			
			if(!isset($_SESSION)){ session_start();}			
			date_default_timezone_set('Asia/Kolkata');

			if(isset($_GET['id'])){
				$id = $_GET['id'];
				
				//Creating Session Carts.
				if(empty($_SESSION['cart'])){

					$_SESSION['total'] = "1";
					$_SESSION['cart'][$id]=array ('id'=>$id, 'quantity'=>1);

				}else{

					//if cart is present.
					if(in_array($id,$_SESSION['cart'][$id]))
					{ 						
						$_SESSION['cart'][$id]['quantity']++;
					}
					else
					{
						if(isset($_GET['id'])){
							$_SESSION['cart'][$id]=array('id'=>$id, 'quantity'=>1);
							$_SESSION['total']++;
						}
					}
					//snippet to check if cart is present.

				}//end session carts

				echo json_encode(array("message"=>"Added to Cart","statuscode"=>200));


			}else{
			echo json_encode(array("message"=>"No Request","statuscode"=>404));
			}

		}
		break;
/** Its still incomplete. More work is to be done. This is the core module.*/
case 'removeproduct':

		if($_GET){
			
			if(!isset($_SESSION)){ session_start();}			
			date_default_timezone_set('Asia/Kolkata');

			if(isset($_GET['id'])){
				$id = $_GET['id'];
				unset($_SESSION['cart'][$id]);
				$_SESSION['total']--;	
				echo json_encode(array("message"=>"Removed from cart","statuscode"=>200));	

			}else{
			echo json_encode(array("message"=>"No Request","statuscode"=>404));
			}

		}		
		break;

/**
 * Display of products in cart. Frontend can be used to display count and others on cart.
 * Its still incomplete. More work is to be done. This is the core module.
 */
case 'cartproducts':
		
		if(!isset($_SESSION)){ session_start();}			
		date_default_timezone_set('Asia/Kolkata');

		if(isset($_SESSION['cart'])){

			$total=sizeof($_SESSION['cart']);
			$productids = array();
			if($total>0){
				foreach($_SESSION['cart'] as $value)
				{
					array_push($productids,$value['id']);
				}

				//call function to display product Items
				echo $site->cart_products($productids);

			}else{
				echo json_encode(array("message"=>"No Request","statuscode"=>404));	
			}

		}else{
			echo json_encode(array("message"=>"No Request","statuscode"=>404));
		}		
		break;

case 'checkout':
		break;

case 'transactions':
		break;

case 'trackshipment':
		break;
default:
		echo "error";
		break;
}
die;