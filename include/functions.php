<?php

	function mysqli_fetch_all($res) {
	   while($row = mysqli_fetch_array($res)) {
		   $return[] = $row;
	   }
	   return $return;
	}

?>
