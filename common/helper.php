<?php

require_once('DBConnection.php'); 

/** Escapes HTML for output */
function escape($html) {
    return htmlspecialchars($html, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
}

/** Escapes special characters for the data **/
function mysql_escape($data){
	return htmlspecialchars(strip_tags(addslashes($data)));
}

?>