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

  function searchAllWine() {
    connectDB();
    $sql = "SELECT w.wine_name, gv.variety, w.year, wy.winery_name, r.region_name, inv.cost, inv.on_hand, ";
    $sql = $sql . "IFNULL(i.sold, 0) AS sold, IFNULL(i.rev, 0) AS rev ";
    $sql = $sql . "FROM wine w, wine_variety wv, grape_variety gv, winery wy, region r, inventory inv LEFT OUTER JOIN ";
    $sql = $sql . "(SELECT wine_id, price, SUM(qty) AS sold , SUM(qty * price) AS rev FROM items GROUP BY wine_id) i ";
    $sql = $sql . "ON inv.wine_id = i.wine_id AND inv.cost = i.price ";
    $sql = $sql . "WHERE w.winery_id = wy.winery_id ";
    $sql = $sql . "AND wy.region_id = r.region_id ";
    $sql = $sql . "AND w.wine_id = wv.wine_id ";
    $sql = $sql . "AND wv.variety_id = gv.variety_id ";
    $sql = $sql . "AND w.wine_id = inv.wine_id ";
    $sql = $sql . "ORDER BY w.wine_name, gv.variety, w.year, wy.winery_name, r.region_name;";
    $result = @mysql_query($sql);
    while ($records[] = @mysql_fetch_row($result));
    return $records;
  }
?>
