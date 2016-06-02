<?php
/**
 * @file
 * Take the user when they return from Twitter. Get access tokens.
 * Verify credentials and redirect to based on response from Twitter.
 */

require_once('../../../mainfile.php');
$oauth_handler = xoops_getmodulehandler('oauth', 'twitterbomb');
@$oauth_handler->getAuthentication($_REQUEST);

?>