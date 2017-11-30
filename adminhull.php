<?php
/**
 * Created by PhpStorm.
 * User: agust
 * Date: 11/27/2017
 * Time: 6:36 PM
 */

$date = new DateTime();

?>
<div style="text-align: center;">
	<div class="container">
		<div class="aspect-ratio img-frame">
			<img src="adminimage.php?img=<?php echo $date->getTimestamp();?>" class="fit-img">
		</div>
	</div>
</div>





