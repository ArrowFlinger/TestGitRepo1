<?php	
	$array=array();
	foreach($product_results as $product_result)
	{ 
		
		$array=array('id'=>$product_result['product_id'],"element" =>'auc_'.$product_result['product_id'],'element2'=>'auction_'.$product_result['product_id'],"Message" => $error,"Success" => $success, "Bid_count"=>$user_bid_count,"last_bidders"=>$product_result['lastbidder_userid'],"current_price" => $product_result['current_price']); 
		
	}
	echo json_encode($array);
	?>
