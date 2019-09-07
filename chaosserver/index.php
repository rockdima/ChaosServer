<?php

if(isset($_GET['action']) && $_GET['action'] == 'response') {
	require_once 'server.php';

	$s = new Server;
	$s->response();
}
