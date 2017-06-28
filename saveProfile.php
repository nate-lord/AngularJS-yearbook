<?php
require 'dbLogin.php';

function updateRowInDb( $Row ) {
	try {
		$dbLogin = dbLogin();
    $db = new PDO( $dbLogin[ 'dsn' ], $dbLogin[ 'user' ], $dbLogin[ 'pass' ] );
		$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		$sql = "UPDATE profiles SET first_name=?,last_name=?,graduation_year=?,clubs=?,future_plans=?,quote=? WHERE id=?";
		$query = $db->prepare( $sql );
		$query->execute( array( $Row->firstName, $Row->lastName, $Row->graduationYear, $Row->clubs, $Row->futurePlans, $Row->quote, $Row->id ) );
	} catch ( PDOException $e ) {
    echo( $e );
		die( 'Could not connect to the database:<br/>' . $e );
	}
}

$postdata = file_get_contents( 'php://input' );
$request = json_decode( $postdata );
$firstName = $request->firstName;
updateRowInDb( $request );

echo $firstName;
?>