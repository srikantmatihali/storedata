<?php date_default_timezone_set('Asia/Kolkata');
/*DB functions*/
class dbfunctions{

	 public $siteurl = "http://localhost/storedata/";
	 public $title = '';
	 public $description = '';
	 public $tdescription = '';
	 public $appId = '';
	 
	
	// Function to connect db
	public function db_connect(){
		//staging 		
		$connection = mysqli_connect('localhost','root','');
		if(!$connection){
			return false;
		}			
		
		//staging 
		if(!mysqli_select_db($connection,'mydb')){  
			return false;
		}
		return $connection;
	}
	
	/*
	Query Executor for display function and returns result in array
    $query - sql query [even multiple query works]
	*/

	function basic_display($query){

    	$a = $this->db_connect();		

		$result = mysqli_query($a,$query) or die("query failed ".mysqli_error());

		$result = $this->db_results($result);

		return $result;	

	}	

	

	/*

	Basic Display

	$table - Table Name

	$Order - Order by which field

	$by - ASC or DESC0

	*/

	function display($table,$order,$by){		

		$a = $this->db_connect();
		$query = "SELECT * FROM $table ORDER BY $table.$order $by";
		$result = mysqli_query($a,$query) or die("query failed ".mysqli_error());
		$result = $this->db_results($result);

		return $result;

	}
	/*

	Display selected

	Need to upgrade this function with count

	$table - Table Name

	$where - Where Query

	*/

	

		function display_selected($table,$where){

		$a = $this->db_connect();

		$query = "SELECT * FROM $table $where";  

		$result = mysqli_query($a,$query)or die("query failed ".mysqli_error());

		$result = $this->db_results_assoc($result);

		return $result;



	}

	

	/*

	Result pop

	Required for display function

	*/

	function db_results($result){

	

		$res_array = array();

		for($count=0;$row = mysqli_fetch_array($result);$count++)

			{

				$res_array[$count] = $row;

			}

		return $res_array;

	}

	

	/*

	Universal Insert System

	*/

	//include("settings.php");

	function insert($info, $table) {

		$a = $this->db_connect();

   		if (!is_array($info)) { die("insert failed, info must be an array"); }

      	$sql = "INSERT INTO ".$table." (";

      	for ($i=0; $i<count($info); $i++) {

     		$sql .= key($info);

     		if ($i < (count($info)-1)) {

        		$sql .= ", ";

     		} else $sql .= ") ";

        next($info);

     }

     reset($info);

     $sql .= "VALUES (";

     for ($j=0; $j<count($info); $j++) {

        $sql .= "'".current($info)."'";

        if ($j < (count($info)-1)) {

           $sql .= ", ";

        } else $sql .= ") ";

        next($info);

     }

         //execute the query

     mysqli_query($a,$sql) or die("query failed ".mysqli_error($a));

         return mysqli_insert_id($a);

      } 

	  

	  /*

	  Basic update Function

	  

	  */

	  	function update_simple($table,$data,$where) {

		 $a = $this->db_connect();

		 $query = "UPDATE $table SET $data $where";

		 $result = mysqli_query($a,$query)or die("query failed ".mysqli_error($a));

		//$result = db_results($result);

		return $result;

      } 

	  

	   /*

	  Basic delete Function

	  

	  */

	  

	  function delete_simple($table,$where) {

		 $a = $this->db_connect();

		 $query = "DELETE FROM $table $where";

		 $result = mysqli_query($a,$query)or die("query failed ".mysqli_error());

		//$result = db_results($result);

		return $result;

      } 
      
      /*

					ACTION: Upload Files

					$filename = Passess the FILE ARRAY

					$uploaddir = DIRECTORY to upload the file

					$filter = To filter file type images, documents, videos, all

					*/

					function upload_simple_files($filename,$uploaddir,$filter){

							//FILE TYPES FILTER

							$ftype1 = array("png","jpg","jpeg","gif","JPEG");

							$ftype2 = array("txt","doc","pdf","xml","xls","docx");

							$ftype3 = array("mp4","avi","mp3","3gb","fla","swf");

							$ftype4 = array("png","jpg","jpeg","gif","txt","doc","pdf","xml","xls","docx","mp4","avi","mp3","3gb","fla","swf");

							

							//UPLOAD DIRECTORY TO BE PASSED

							$filelocation = $uploaddir;				

							//print_r($filename[0]); die();

							

							//GRAB EXTENSION AND VALID THE FILTER MODE

						    $extension = findexts($filename[0]['name']);	 

							$randomname = rand(0,99999999999999);

							$newfilename = $randomname.".".$extension;



							//FILTER VALIDATION

							if($filter == "images"){   

							//$f = in_array($extension,$ftype1); print_r($f); die();                   

								if(in_array($extension,$ftype1)){									

											 $flag = 1;  

		                                     

											}

											else

											{

											$flag = 0;	

											}

							}

							else

							if($filter == "documents"){

								if(in_array($extension,$ftype2)){

											$flag = 1;

											}

											else

											{

											$flag = 0;	

											}

							}

							else

							if($filter == "videos"){

								if(in_array($extension,$ftype3)){

											$flag = 1;

											}

											else

											{

											$flag = 0;	

											}

								

							}

							else

							if($filter == "all"){

								if(in_array($extension,$ftype4)){

											$flag = 1;

											}

											else

											{

											$flag = 0;	

											}

							}

							else

							{

							$message = "FILTER MODE NOT SELECTED";

							return $message;

							}

							//echo $newfilename;

							//die();

							

							$target_path = $filelocation.$newfilename;   

							if($flag==1){ //print_r($filename); echo $target_path; die();

						    	if(
						    		move_uploaded_file($filename[0]['tmp_name'], $target_path)){ 

								  //echo "HERE";

								  //die();

								  //echo $target_path;

								  $message = $newfilename;

								   return $message;

							     }

							    else

							    {

									//echo $filename;

									//die();

									$error = "No File Selected";

									return $error; 	

								}

							}

							else

							{

								$message = "Invalid File type. Please upload supported file types";

								return $message;

							}

						

					}

					

					//TO FIND FILE EXTENSION

					function findexts ($filename) { 

					$filename = strtolower($filename) ;

					$exts = @split("[/\\.]", $filename) ; 

					$n = count($exts)-1; 

					$exts = $exts[$n]; 

					return $exts;

					}
					
	function display_selected_assoc($table,$fields,$where){

		$a = $this->db_connect();
		$query = "SELECT $fields FROM $table $where"; 
		//echo $query;
		$result = mysqli_query($a,$query)or die("query failed ".mysqli_error());

		

		//$result = mysqli_fetch_array($result);

		$result = $this->db_results_assoc($result);

		return $result;

 	}

 	//result by using assoc
 	function db_results_assoc($result){
		$res_array = array();
		for($count=0;$row = mysqli_fetch_assoc($result);$count++)
			{
				$res_array[$count] = $row;
			}
		return $res_array;
	}

	//PROTECT FROM SQL ATTACK
	function escape_data($data) { 
		$a = $this->db_connect();
		//global $dbc; // Database connection.	
		// Strip the slashes if Magic Quotes is on:
		//if (get_magic_quotes_gpc()) 
		$data = stripslashes($data);	
		// Apply trim() and mysqlii_real_escape_string():
		return mysqli_real_escape_string($a,trim($data));		

	} // End of the escape_data() function.


	function db_display_selected($table,$fields,$where){
			$a = $this->db_connect();

			$query = "SELECT $fields FROM $table $where"; 
	//echo $query;
			$result = mysqli_query($a,$query)or die("query failed ".mysqli_error());

			$result = mysqli_fetch_array($result);
			//print_r($result);
			//$result = db_results_assoc($result);
			return $result;
	}

	//gets time from milliseconds
	function formatMilliseconds($milliseconds) {
		$seconds = floor($milliseconds / 1000);
		$minutes = floor($seconds / 60);
		$hours = floor($minutes / 60);
		//$milliseconds = $milliseconds % 1000;
		$seconds = $seconds % 60;
		$minutes = $minutes % 60;

		//$format = '%u:%02u:%02u.%03u';
		$format = '%u:%02u:%02u';
		$time = sprintf($format, $hours, $minutes, $seconds);
		return rtrim($time, '0');
	}

	//gets milliseconds from time.
	function getMilliSeconds($time){
		list($hours,$mins,$secs) = explode(':',$time);
		$seconds = mktime($hours,$mins,$secs) - mktime(0,0,0);
		return $seconds;
	}	

	//get ipaddress
	function getIpAddress(){
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}
	
	/**project functions**/
	function categorydetails(){
		
		$table = "category";
		$fields = ' idcategory,categoryname,description,level';
		$where = "WHERE status=1";
		$totalData = $this->display_selected_assoc($table,$fields,$where); 
		if(count($totalData)>0){
			$data['result'] = $totalData;
			$data['statuscode'] = 200;
			$data['message'] = "Success";
			
		}else{
			$data['result'] = array();
			$data['statuscode'] = 1003;
			$data['message'] = "Failure";
		}
		return json_encode($data);        
	}	
	
	function productlisting($category,$page,$per_page){

		$data['result'] = array();
		$data['statuscode'] = 404;
		$data['message'] = "Failure";

		$page = $this->escape_data($page);
		$category = $this->escape_data($category);
		$per_page = $this->escape_data($per_page);
		
		//pagination 
		$start = 0;
		if($page){
			$start = ($page - 1) * $per_page;
		}
		
		//pagination
		$fields = "COUNT(*)";
		$table = "product";
		$where = "WHERE status=1 AND catid=".$category;
		$total = $this->db_display_selected($table,$fields,$where);
		$overall_count = $total[0];//$prev = $page - 1;
		$next = $page+1;
		$lastpage = ceil($overall_count/$per_page);
		//pagination
		
		$fields = ' idproduct,sku,name,description,defaultimage,permalink,catid,quantity,price,discount';
		$where = $where." ORDER BY idproduct desc LIMIT ".$start.",".$per_page."";
		$totalData = $this->display_selected_assoc($table,$fields,$where); 
		if(count($totalData)>0){
			$data['result'] = $totalData;
			$data['error'] = 1;
			$data['next']  = $next;
			$data['lastpage']  = $lastpage;
			$data['page']  = $page;
		}else{			
			$data['statuscode'] = 1003;
			$data['message'] = "Empty Data";
		}
		return json_encode($data);
	}
	
	function productdetails($productid){
		$table = "product";
		$fields = ' idproduct,sku,name,description,defaultimage,permalink,catid,quantity,price,discount';
		$where = " where idproduct=".$productid;
		$totalData = $this->display_selected_assoc($table,$fields,$where);
		$dataCount = count($totalData);
		if($dataCount>0){
			
			$data['statuscode'] = 200;
			$data['message'] = "Success";
			$data['totalData'] = $totalData;			
		}else{			
			$data['statuscode'] = 1003;
			$data['message'] = "Empty Data";
		}
		return json_encode($data);	
	}
	
	
	function cart_products($productids){
		$array = implode("','",$productids);
		//echo $sql = "SELECT * FROM product WHERE idproduct IN ('".$array."')";
		$table = "product";
		$fields = ' idproduct,sku,name,description,defaultimage,permalink,catid,quantity,price,discount';
		$where = " WHERE idproduct IN ('".$array."')";
		$totalData = $this->display_selected_assoc($table,$fields,$where);
		$dataCount = count($totalData);
		if($dataCount>0){
			
			$data['statuscode'] = 200;
			$data['message'] = "Success";
			$data['totalData'] = $totalData;			
		}else{			
			$data['statuscode'] = 1003;
			$data['message'] = "Empty Data";
		}
		return json_encode($data);
	}
	
	/*
	* Listing of products.
	*/
	function transactiondetail($productid){
		
	}

	/**project functions**/
	
	
	

}

?>