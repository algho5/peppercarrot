<?php
include(dirname(__FILE__).'/header.php');
include(dirname(__FILE__).'/lib-parsedown.php');

// Setup
$repositoryURL = "https://framagit.org/peppercarrot/wiki";
$currentpage = "?static8/wiki";
$datapath = "data/wiki/";

include(dirname(__FILE__).'/lib-wiki.php');

include(dirname(__FILE__).'/footer.php'); 
?>
