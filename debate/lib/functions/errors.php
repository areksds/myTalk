<?php 

function error_alert($message) {
	echo "<div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\" style=\"text-align: left;\">" . $message . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>";
}

?>