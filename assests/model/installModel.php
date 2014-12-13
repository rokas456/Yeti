<?php
	/**
 * Created by PhpStorm.
 * User: RobertGabriel
 * Date: 02/10/14
 * Time: 23:57
 */

	// -- Class Name : installModel
	// -- Purpose : 
	// -- Created On : 
	class installModel{
        
        
		var $dbName;
		var $host ;
		var $userName;
		var $password;
		
        
        // -- Function Name : __construct
		// -- Params : None
		// -- Purpose : Starts Database Connection
		public
		function __construct() {
		}

        
        
        
		public
		function createDatabase(){
			$conn = mysql_connect($_SESSION['databaseHost'], $_SESSION['databaseUserName'], $_SESSION['databaseUserPass']);
			
			if(! $conn ){
				die('Could not connect: ' . mysql_error());
			}

			echo 'Connected successfully';
			echo $sql = 'CREATE Database ' .$_SESSION['databaseName'] ;
			$retval = mysql_query( $sql, $conn );
			
			if(! $retval ){
				die('Could not create database: ' . mysql_error());
			}

			echo "Database test_db created successfully\n";
			mysql_close($conn);
			$this->createTables();
		}

        
        
        
        
        
		public
		function createTables(){
			$conn = mysql_connect($_SESSION['databaseHost'], $_SESSION['databaseUserName'], $_SESSION['databaseUserPass']);
			
			if(! $conn ){
				die('Could not connect: ' . mysql_error());
			}

			$query_file = 'assests/sql/sql_query.txt';
			$fp    = fopen($query_file, 'r');
			$sql = fread($fp, filesize($query_file));
			fclose($fp);
			mysql_select_db($_SESSION['databaseName']);
			$retval = mysql_query( $sql, $conn );
			
			if(! $retval ){
				die('Could not create table: ' . mysql_error());
			}

			echo "Table Created";
			mysql_close($conn);
			$file = 'assests/settings/finished.ch';
			// Open the file to get existing content
			$current = file_get_contents($file);
			// Append a new person to the file
			$current .= "perfect";
			// Write the contents back to the file
			file_put_contents($file, $current);
			header('Location: http://www.google.ie');
		}

		public
		function cookies(){
			// Retrieving name session cookie
			$_SESSION['databaseName'] = $_POST["dName"];
			$_SESSION['databaseHost'] = $_POST["dHost"];
			$_SESSION['databaseUserName'] = $_POST["dUserName"];
			$_SESSION['databaseUserPass'] = $_POST["dpassword"];
		}

	}

	?>