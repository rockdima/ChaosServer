<?php

/**
* Server mode changer
*
*/

require_once 'server.php';

class ModeChanger extends Server {

	function __construct() {
		parent::__construct();
	}

	/**
	* Get current mode
	* @return string 
	*/
	public function getMode(): string {
		return $this->_mode['current'];
	}

	/**
	* Sets a new mode
	*/
	public function newMode(string $newMode) {
		$this->setMode($newMode);
	}
}

$mode_changer = new ModeChanger;

//if post request, change to a new mode
if(isset($_POST['new_mode']) && $_POST['new_mode'] != '') {
	$mode_changer->newMode($_POST['new_mode']);
}

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Server mode changer</title>
		<style>
			body * {font-family:calibri;}
			.main {width:30%;margin:0 auto;}
			h1 {text-align: center;}
			.modes {display: flex; justify-content: space-between;}
			.modes button {width:30%}
		</style>
	</head>
	<body>
		<div class="main">
			<h1 class="current_mode"><u>Current mode:</u> <?= $mode_changer->getMode() ?></h1>
			<form method="post" class="modes">
				<button type="submit" name="new_mode" value="normal">normal</button>
				<button type="submit" name="new_mode" value="degraded">degraded</button>
				<button type="submit" name="new_mode" value="failure">failure</button>
			</form>
		</div>
	</body>
</html>
