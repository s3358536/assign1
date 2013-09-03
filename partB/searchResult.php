<?php 
  require_once('dbConnection.php');
?>

<?php include "header.php" ?>

<?php include "search_partial.php" ?>

<?php
  
  if ($condition != -1) {
    $result = searchWine($condition);
    echo "<h1>Search Result</h1>";
    echo "<table border=\"1\">";
    echo "<tr>";
    echo "<th>Wine Name</th>";
    echo "<th>Grape Varieties</th>";
    echo "<th>Year</th>";
    echo "<th>Winery</th>";
    echo "<th>Region</th>";
    echo "<th>Cost</th>";
    echo "<th>Available</th>";
    echo "<th>Sold</th>";
    echo "<th>Sales Revenue</th>";
    echo "</tr>";
    if (count($result) == 0) {
      echo "<tr><td colspan=\"9\">No record is found.</td></tr>";
    } else {
      foreach ($result as $record) {
        echo "<tr>";
        foreach ($record as $field) {
          echo "<td>".$field."</td>";
        }
        echo "</tr>";
      }
      echo "</table>";
    }
  }
?>

<?php include "footer.php" ?>
