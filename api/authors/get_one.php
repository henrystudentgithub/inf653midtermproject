<?php
	header('Content-Type: application/json');

	include_once '../../config/Database.php';
	include_once '../../models/Author.php';

	$database = new Database();
	$db = $database->connect();

	$authors = new Authors($db);

	$authors->id = isset($_GET['id']) ? $_GET['id'] : die();

	$authors->get_one();

	if ($authors->author != null) {
		// author exists
		$author_arr = array(
			'id' => $authors->id,
			'author' => $authors->author
		);
		// show the author
		echo json_encode($author_arr);
	} else {
		echo json_encode(
			// author is not found
			array('message' => 'author_id Not Found')
		);
	}
?>
