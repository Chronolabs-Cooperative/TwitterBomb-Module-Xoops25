<?php

include('header.php');

$oauth_handler = xoops_getmodulehandler('oauth', 'twitterbomb');

$oauth_handler->getTempAuthentication();

?>