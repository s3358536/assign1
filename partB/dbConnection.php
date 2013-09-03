<?php
  require_once('db.php');

  function connectDB() {
    if (!$dbconn = @mysql_connect(DB_HOST, DB_USER, DB_PW)) {
      echo "Could not connect to mysql on " . DB_HOST . "\n";
      exit;
    }
    if (!@mysql_select_db(DB_NAME, $dbconn)) {
      echo "Could not access database " . DB_NAME . "\n";
      echo mysql_error() . "\n";
      exit;
    }
    return $dbconn;
  }

  function closeDB($dbconn) {
    mysql_close($dbconn);
  }

  function searchWine($condition) {
    $conn = connectDB();
    $sql = "SELECT w.wine_name, group_concat(gv.variety separator ', ') AS grape_varieties, w.year, wy.winery_name, ";
    $sql = $sql . "r.region_name, inv.cost, inv.on_hand, IFNULL(i.sold, 0) AS sold, IFNULL(i.rev, 0) AS rev ";
    $sql = $sql . "FROM wine w LEFT OUTER JOIN (SELECT wine_id, price, SUM(qty) AS sold , SUM(price) AS rev FROM items GROUP BY wine_id) i ";
    $sql = $sql . "ON w.wine_id = i.wine_id, wine_variety wv, grape_variety gv, winery wy, region r, inventory inv ";
    $sql = $sql . "WHERE w.winery_id = wy.winery_id ";
    $sql = $sql . "AND wy.region_id = r.region_id ";
    $sql = $sql . "AND w.wine_id = wv.wine_id ";
    $sql = $sql . "AND wv.variety_id = gv.variety_id ";
    $sql = $sql . "AND w.wine_id = inv.wine_id ";
    $sql = $sql . $condition;
    $sql = $sql . "GROUP BY w.wine_id ";
    $sql = $sql . "ORDER BY w.wine_name, gv.variety, w.year, wy.winery_name, r.region_name;";    
    $result = @mysql_query($sql);
    while ($row = @mysql_fetch_row($result)) {
      $records[] = $row;
    }
    closeDB($conn);
    return $records;
  }

  function addWineNameCondition($value, $condition) {
    $condition = $condition . "AND wine_name LIKE '%".$value."%' ";
    return $condition;
  }
  
  function addWineryNameCondition($value, $condition) {
    $condition = $condition . "AND winery_name LIKE '%".$value."%' ";
    return $condition;
  }

  function addRegionCondition($value, $condition) {
    $condition = $condition . "AND region_name LIKE '%".$value."%' ";
    return $condition;
  }

  function addGrapeVarietyCondition($value, $condition) {
    $condition = $condition . "AND variety LIKE '%".$value."%' ";
    return $condition;
  }

  function addYearRangeCondition($min, $max, $condition) {
    $condition = $condition . "AND year >= ".$min." AND year <= ".$max." ";
    return $condition;
  }
  
  function addMinInStockCondition($value, $condition) {
    $condition = $condition . "AND on_hand >= ".$value." ";
    return $condition;
  }
  
  function addMinOrderedCondition($value, $condition) {
    $condition = $condition . "AND sold >= ".$value." ";
    return $condition;
  }
  
  function addMinCostCondition($value, $condition) {
    $condition = $condition . "AND cost >= ".$value." ";
    return $condition;
  }
  
  function addMaxCostCondition($value, $condition) {
    $condition = $condition . "AND cost <= ".$value." ";
    return $condition;
  }
  
  function getRegion() {
    $conn = connectDB();
    $sql = "SELECT region_name FROM region ORDER BY region_name;";
    $result = @mysql_query($sql);
    while ($row = @mysql_fetch_row($result)) {
      $records[] = $row;
    }
    closeDB($conn);
    return $records;
  }
   
  function getGrapeVariety() {
    $conn = connectDB();
    $sql = "SELECT variety FROM grape_variety ORDER BY variety;";
    $result = @mysql_query($sql);
    while ($row = @mysql_fetch_row($result)) {
      $records[] = $row;
    }
    closeDB($conn);
    return $records;
  }
  
  function getWineYearMinMax() {
    $conn = connectDB();
    $sql = "SELECT MIN(year), MAX(year) FROM wine;";
    $result = @mysql_query($sql);
    while ($row = @mysql_fetch_row($result)) {
      $records[] = $row[0];
      $records[] = $row[1];
    }
    closeDB($conn);
    return $records;
  }
?>
