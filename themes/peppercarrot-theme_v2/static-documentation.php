<?php
include(dirname(__FILE__).'/header.php');
include(dirname(__FILE__).'/lib-parsedown.php');

// Setup
$repositoryURL = "https://framagit.org/peppercarrot/documentation";
$currentpage = "?static14/documentation";
$datapath = "data/documentation/";
$wikitheme = "wikidoc";
$wikiicons = "_b";

include(dirname(__FILE__).'/lib-wiki.php');

include(dirname(__FILE__).'/footer.php'); 
?>
