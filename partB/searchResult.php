<?php 
  require_once('dbConnection.php');
?>

<?php include "header.php" ?>

<?php
  $result = searchAllWine();
  echo "<h1>Search Result</h1>";
  echo "<table border=\"1\">";
  echo "<tr>";
  echo "<th>Wine Name</td>";
  echo "<th>Grape Variety</td>";
  echo "<th>Year</td>";
  echo "<th>Winery</td>";
  echo "<th>Region</td>";
  echo "<th>Cost</td>";
  echo "<th>Available</td>";
  echo "<th>Sold</td>";
  echo "<th>Sales Revenue</td>";
  echo "</tr>";
  foreach ($result as $record) {
    echo "<tr>";
    foreach ($record as $field) {
      echo "<td>".$field."</td>";
    }
    echo "</tr>";
  }
  echo "</table>";
?>

<?php include "footer.php" ?>
