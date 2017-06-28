<?php
require 'dbLogin.php';

function getAllRowsFromDb() {
	try {
		$dbLogin = dbLogin();
    $db = new PDO( $dbLogin[ 'dsn' ], $dbLogin[ 'user' ], $dbLogin[ 'pass' ] );
		$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		$stmt = $db->prepare( "SELECT * FROM profiles" );
		$stmt->execute(); 
		$rows = $stmt->fetchAll();
	} catch ( PDOException $e ) {
		die( 'Could not connect to the database:<br/>' . print_r($e) );
	}
  
  return $rows;
}

function getGlobalScriptFromRows() {
  $Rows = getAllRowsFromDb();
  $Profile = $Rows[ 0 ];
  $script = '<script> var ProfileIds = [';
  $cnt = 0;
  
  foreach ( $Rows as $Row ) {
    $cnt = $cnt + 1;
    $comma = ( $cnt < count( $Rows ) ? ',' : '' );
    $script = $script . '{ id: ' . $Row[ 'id' ] . ' }' . $comma;
  }
  
  $script = $script . ']; ';
  $script = $script . 'var InitialProfile = {';
  $script = $script . 'id: ' . $Profile[ 'id' ] . ', ';
  $script = $script . 'firstName: "' . str_replace( array("\r\n", "\n", "\r"), ' ', addslashes( $Profile[ 'first_name' ] ) ) . '", ';
  $script = $script . 'lastName: "' . str_replace( array("\r\n", "\n", "\r"), ' ', addslashes( $Profile[ 'last_name' ] ) ) . '", ';
  $script = $script . 'imgFileName: "' . str_replace( array("\r\n", "\n", "\r"), ' ', addslashes( $Profile[ 'img_file_name' ] ) ) . '", ';
  $script = $script . 'graduationYear: "' . str_replace( array("\r\n", "\n", "\r"), ' ', addslashes( $Profile[ 'graduation_year' ] ) ) . '", ';
  $script = $script . 'clubs: "' . str_replace( array("\r\n", "\n", "\r"), ' ', addslashes( $Profile[ 'clubs' ] ) ) . '", ';
  $script = $script . 'futurePlans: "' . str_replace( array("\r\n", "\n", "\r"), ' ', addslashes( $Profile[ 'future_plans' ] ) ) . '", ';
  $script = $script . 'quote: "' . str_replace( array("\r\n", "\n", "\r"), ' ', addslashes( $Profile[ 'quote' ] ) ) . '"';
  $script = $script . '};</script> ';
  
  return $script;
}
?>