<?php
	/*https://stackoverflow.com/questions/4964197/converting-a-number-base-10-to-base-62-a-za-z0-9*/
	function toBase($num, $b=62) {
		$base='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$r = $num  % $b ;
		$res = $base[$r];
		$q = floor($num/$b);
		while ($q) {
			$r = $q % $b;
			$q =floor($q/$b);
			$res = $base[$r].$res;
		}
		return $res;
	}
	
	function sendMessage($responseArray) {
		$array = [];
		if($responseArray[0] < 0) {
			$array['error'] = $responseArray[0];
		}
		else {
			$array['status'] = $responseArray[0];
		}
		$array['message'] = $responseArray[1];
		echo json_encode($array);
	}
?>