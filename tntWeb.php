<?php

if($_SERVER['REQUEST_METHOD']=='POST'){

		define('HOST', "mysql.hostinger.kr");
		define('USER', "u414143907_tnt");
		define('PW', "m2m3m5m2");
		define('DB', "u414143907_tnt");
		$con= mysqli_connect(HOST,USER,PW,DB) or die("Unable to Connect");

		date_default_timezone_set("Asia/Seoul");
		$RegisteredDate = date("Ymd");
		
		$dateStamp = $RegisteredDate;
		$timeStamp = date("H:i:s");

		$deviceID = $_POST['deviceID'];
		$powerValue =$_POST['powerValue'];

		$checker = 0;

		$tableChanger = "powerTable";

		if($deviceID == "1"){

			$tableChanger = "powerTable";

		}elseif($deviceID == "2"){

			$tableChanger = "powerTable2";

		}elseif($deviceID == "3"){

			$tableChanger = "powerTable3";

		}

		

		

		$sqlM = "SELECT * from $tableChanger";
	    $readyM = mysqli_query($con,$sqlM);
		while($rowG=mysqli_fetch_array($readyM, MYSQL_ASSOC)){

			if($rowG['dateStamp'] ==$dateStamp){

		         $checker = 1;
		         $powerValueJson = $rowG['powerValue'];
			}
				
		}		
	    
	    if($checker ==1){

	    	

	        $powerValueList = json_decode($powerValueJson,true);
			$powerValueCount = sizeof($powerValueList);			

            $Mover = array();
            $newEntry =array();
            $reTable = array();



            	for($i=0; $i<$powerValueCount; $i++){

            		$Mover['timeStamp'] = $powerValueList[$i]['timeStamp'];
            		$Mover['powerValue'] = $powerValueList[$i]['powerValue'];
            		$Mover['powerConsumed'] = $powerValueList[$i]['powerConsumed'];
			      			        			
			        $reTable[] = $Mover;
            				             
				}

					$newEntry['timeStamp'] = $timeStamp;
            		$newEntry['powerValue'] = $powerValue;

            		$previousTimeStamp = $powerValueList[$powerValueCount-1]['timeStamp'];
            		$previousPowerValue = $powerValueList[$powerValueCount-1]['powerValue'];
            		$previousPowerConsumed = $powerValueList[$powerValueCount-1]['powerConsumed'];

            		$calcA= strtotime($timeStamp) - strtotime($previousTimeStamp);
            		$calcB= $powerValue + $previousPowerValue;
            		$powerConsumedReady = $previousPowerConsumed + (($calcA*$calcB)/2)/3600;
            		$powerConsumed = $powerConsumedReady;

            		$newEntry['powerConsumed'] = $powerConsumed;
            		$reTable[] = $newEntry;			      		
					$newValueJson = json_encode($reTable);

				  $sql ="UPDATE $tableChanger SET powerValue=?, powerConsumed=? WHERE dateStamp=?";
				  $stmt = mysqli_prepare($con,$sql);
		  		  mysqli_stmt_bind_param($stmt,"sss",$newValueJson, $powerConsumed, $dateStamp);
		 	 	  mysqli_stmt_execute($stmt);
		  		  $check0 = mysqli_stmt_affected_rows($stmt);

	    }else if($checker==0){

	    		$sql0="INSERT INTO $tableChanger (dateStamp, powerValue, powerConsumed) VALUES (?,?,?)";
				$stmt0 = mysqli_prepare($con,$sql0);
				
	            $newEntry =array();
	            $reTable = array();            

						$newEntry['timeStamp'] = $timeStamp;
	            		$newEntry['powerValue'] = $powerValue;
	            		$newEntry['powerConsumed'] = "0";
	            		$reTable[] = $newEntry;	    

				
				$newValueJson = json_encode($reTable);
				$powerConsumed = "0";
				mysqli_stmt_bind_param($stmt0,"sss",$dateStamp, $newValueJson, $powerConsumed);
				mysqli_stmt_execute($stmt0);
				$check0 = mysqli_stmt_affected_rows($stmt0);

	    }
	

		if($powerConsumed !== ""){

			 $returnEntry =array();
			           
			 $returnEntry['deviceID'] = $deviceID;
	         $returnEntry['powerConsumed'] = (String) $powerConsumed;
	         
	         $newReturnValue = json_encode($returnEntry);
		     echo $newReturnValue;

		}else{
			echo "no";
		}

				mysqli_close($con);


}else{

		echo "Error";
	}


?>