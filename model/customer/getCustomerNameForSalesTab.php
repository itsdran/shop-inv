<?php
	$itemDetailsSql = 'SELECT fullName, customerID FROM customer';
	$itemDetailsStatement = $conn->prepare($itemDetailsSql);
	$itemDetailsStatement->execute();
	
	if($itemDetailsStatement->rowCount() > 0) {
		while($row = $itemDetailsStatement->fetch(PDO::FETCH_ASSOC)) {
			echo '<option>' . $row['fullName'] . '</option>';
		}
	}
	$itemDetailsStatement->closeCursor();
?>