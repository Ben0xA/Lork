<?php
	require($_SERVER['DOCUMENT_ROOT'] . "/../config/lork/lork.php");

	if(isset($_POST['inprompt'])) {
        $_SESSION['txt'] = substr(strip_tags($_POST['inprompt']), 0, MAXSTRLEN);
        echo strip_tags($txt->getText(), ALLOWEDTAGS);
    }
    else {
    	echo "Invalid post";
    }
?>