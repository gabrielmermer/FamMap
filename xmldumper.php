<?php

// database login info file
require("phpsqlajax_dbinfo.php");

// Start XML file, create parent node

$dom = new DOMDocument("1.0");

// echo "created DOMDocument";
// echo "<br>";

$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);

// Opens a connection to a MySQL server

$connection = mysqli_connect($_SERVER, $username, $password, $database);

// echo "<br>";
// echo $connection;

if (!$connection) {
  
  die('Not connected : ' . mysqli_error());
} else {
  // echo "Connected!";
  // echo "<br>";
}


// DON'T KNOW IF THE REST WORKS, GOTTA TEST IT OUT

// Select all the rows in the markers table

$query = "SELECT * FROM markers WHERE 1";
$result = mysqli_query($connection, $query);

if (!$result) {
  die('Invalid query: ' . mysqli_error());
} else {
  // echo "query selected";
}

// echo "query selected";



header("Content-type: text/xml");

// Iterate through the rows, adding XML nodes for each

while ($row = @mysqli_fetch_assoc($result)){
  // Add to XML document node
  $node = $dom->createElement("marker");
  $newnode = $parnode->appendChild($node);
  $newnode->setAttribute("id",$row['id']);
  $newnode->setAttribute("name",$row['name']);
  $newnode->setAttribute("address", $row['address']);
  $newnode->setAttribute("lat", $row['lat']);
  $newnode->setAttribute("lng", $row['lng']);
  $newnode->setAttribute("type", $row['type']);
}



echo $dom->saveXML();

// echo "saving doc";



// echo "script worked";
?>