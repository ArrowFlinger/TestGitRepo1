<?php	
	
	foreach($product_results as $product_result)
	{ 
		
		$array=array('id'=>$product_result['product_id'],"element" =>'auc_'.$product_result['product_id'],'element2'=>'auction_'.$product_result['product_id'],"Message" => $error, "Bid_count"=>$user_bid_count,"last_bidders"=>$product_result['lastbidder_userid'],"current_price" => $product_result['current_price'],"lat" => $product_result['latitude'],"lng" => $product_result['longitude']); 
		
	}
	echo $callback."(".json_encode($array).")";
	?>
