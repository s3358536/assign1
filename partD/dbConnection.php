<?php
  require_once('db.php');

  function connectDB() {
    try {
      $dsn = DB_ENGINE.':host='.DB_HOST.';dbname='.DB_NAME;
      $dbconn = new PDO($dsn, DB_USER, DB_PW);
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
    return $dbconn;
  }

  function closeDB($dbconn) {
    $dbconn = null;
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
    try {
      foreach ($conn->query($sql) as $row) {
        $record = null;
        $record[] = $row['wine_name'];
        $record[] = $row['grape_varieties'];
        $record[] = $row['year'];
        $record[] = $row['winery_name'];
        $record[] = $row['region_name'];
        $record[] = $row['cost'];
        $record[] = $row['on_hand'];
        $record[] = $row['sold'];
        $record[] = $row['rev'];
        $records[] = $record;
      }
    } catch (PDOException $e) {
      echo $e->getMessage();
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
    try {
      foreach ($conn->query($sql) as $row) {
        $records[] = $row['region_name'];
      }
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
    closeDB($conn);
    return $records;
  }
   
  function getGrapeVariety() {
    $conn = connectDB();
    $sql = "SELECT variety FROM grape_variety ORDER BY variety;";
    try {
      foreach ($conn->query($sql) as $row) {
        $records[] = $row['variety'];
      }
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
    closeDB($conn);
    return $records;
  }
  
  function getWineYearMinMax() {
    $conn = connectDB();
    $sql = "SELECT MIN(year) AS min, MAX(year) AS max FROM wine;";
    try {
      foreach ($conn->query($sql) as $row) {
        $records[] = $row['min'];
        $records[] = $row['max'];
      }
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
    closeDB($conn);
    return $records;
  }
?>
