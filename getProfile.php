<?php
require 'dbLogin.php';

function getRowFromDb( $id ) {
	try {
		$dbLogin = dbLogin();
    $db = new PDO( $dbLogin[ 'dsn' ], $dbLogin[ 'user' ], $dbLogin[ 'pass' ] );
		$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		$stmt = $db->prepare( "SELECT * FROM profiles WHERE id='" . $id . "' LIMIT 1" );
		$stmt->execute(); 
		$row = $stmt->fetch();
	} catch ( PDOException $e ) {
		die( 'Could not connect to the database:<br/>' . print_r($e) );
	}

  return $row;
}

$postdata = file_get_contents( 'php://input' );
$request = json_decode( $postdata );
$id = $request->id;

$Row = getRowFromDb( $request->id );
echo json_encode( $Row );
?>