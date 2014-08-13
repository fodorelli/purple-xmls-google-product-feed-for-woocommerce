<?php

	/********************************************************************
	Version 2.0
		Get a feed
		Copyright 2014 Purple Turtle Productions. All rights reserved.
		license	GNU General Public License version 3 or later; see GPLv3.txt
	By: Keneto 2014-07-01
	********************************************************************/

	require_once dirname(__FILE__) . '/../../../../../../wp-load.php';

	function safeGetPostData($index) {
		if (isset($_POST[$index]))
			return $_POST[$index];
		else
			return '';
	}

	$requestCode = safeGetPostData('provider');
	$local_category =	safeGetPostData('local_category');
	$remote_category = safeGetPostData('remote_category');
	$file_name = safeGetPostData('file_name');
	$feedIdentifier = safeGetPostData('feed_identifier');
	$saved_feed_id = safeGetPostData('feed_id');

	$output = new stdClass();
	$output->url = '';

	if (strlen($requestCode) * strlen($local_category) == 0) {
		$output->errors = 'Error: error in AJAX request. Insufficient data';
		echo json_encode($output);
		return;
	}

	if (strlen($remote_category) == 0) {
		$output->errors = 'Error: Insufficient data. Please fill in "' . $requestCode . ' category"';
		echo json_encode($output);
		return;
	}
	
	require_once dirname(__FILE__) . '/../../../cart-product-wpincludes.php';

	// Check if form was posted and select task accordingly
	$dir = PFeedFolder::uploadRoot();
	if (!is_writable($dir)) {
		$output->errors = "Error: $dir should be writeable";
		echo json_encode($output);
		return;
	}
	$dir = PFeedFolder::uploadFolder();
	if (!is_dir($dir)) {
		mkdir($dir);
	}
	if (!is_writable($dir)) {
		$output->errors = "Error: $dir should be writeable";
		echo json_encode($output);
		return;
	}

	$providerFile = 'feeds/' . strtolower($requestCode) . '/feed.php';

	if (!file_exists(dirname(__FILE__) . '/../../' . $providerFile)) {
	  $output->errors = 'Error: Provider file not found.';
		echo json_encode($output);
	  return;
	}

	require_once dirname(__FILE__) . '/../../' . $providerFile;

	//Load form data
	$file_name = sanitize_title_with_dashes($file_name);
	if ($file_name == '')
		$file_name = 'feed' . rand(10, 1000);

	$saved_feed = null;
	if ( (strlen($saved_feed_id) > 0) && ($saved_feed_id > -1) ) {
		require_once dirname(__FILE__) . '/../../data/savedfeed.php';
		$saved_feed = new PSavedFeed($saved_feed_id);
	}

	$providerClass = 'P' . $requestCode . 'Feed';
	$x = new $providerClass;
	if (strlen($feedIdentifier) > 0)
	  $x->activityLogger = new PFeedActivityLog($feedIdentifier);
	$x->getFeedData($local_category, $remote_category, $file_name, $saved_feed);

	if ($x->success)
		$output->url = PFeedFolder::uploadURL() . $x->providerName . '/' . $file_name . '.' . $x->fileformat;
	$output->errors = $x->getErrorMessages();

	echo json_encode($output);

?>