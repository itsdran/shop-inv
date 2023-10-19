<?php
	$itemDetailsSql = 'SELECT itemName, itemNumber FROM item';
	$itemDetailsStatement = $conn->prepare($itemDetailsSql);
	$itemDetailsStatement->execute();
	
	if($itemDetailsStatement->rowCount() > 0) {
		while($row = $itemDetailsStatement->fetch(PDO::FETCH_ASSOC)) {
			echo '<option>' . $row['itemNumber'] . '. ' . $row['itemName'] . '</option>';
		}
	}
	$itemDetailsStatement->closeCursor();
?>