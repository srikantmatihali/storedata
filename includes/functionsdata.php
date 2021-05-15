<?php 
/*NOT REQUIRED FOR NOW. CAN BE USED LATER.*/

date_default_timezone_set('Asia/Kolkata');
require 'dbfunctions.php';
$site  = new dbfunctions();
$siteurl = $site->siteurl;

/*DB functions*/
class functionsdata{	 

	
	function categorydetails($value,$page){
				
	}	
	
	function productlisting($category,$page,$value){
		
	}
	
	function productdetails($productid){
		
	}
	
	function transactiondetail($productid){
		
	}
	
	function add_to_cart($userid,$productid){
		
	}
	
	function remove_to_cart($userid,$productid){
		
	}
	
	function cart_details($cartid){
		
	}
	
}
?>