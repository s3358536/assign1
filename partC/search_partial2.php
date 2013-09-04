<?php
  require_once('dbConnection.php');
  require_once('validation.php');
  $regions = getRegion();
  $grapeVarieties = getGrapeVariety();
  $wineYearMinMax = getWineYearMinMax();
  if (isset($_GET['wineName']) && $_GET['wineName'] != "") {
    $wineName = $_GET['wineName'];
    $errWineName = validateText($_GET['wineName'], 30);
    if ($errWineName == "") {
      $condition = addWineNameCondition($_GET['wineName'], "");
    } else {
      $condition = -1;
    }
  }
  if (isset($_GET['wineryName']) && $_GET['wineryName'] != "") {
    $wineryName = $_GET['wineryName'];
    $errWineryName = validateText($_GET['wineryName'], 30);
    if ($errWineryName == "" && $condition != -1) {
      $condition = addWineryNameCondition($_GET['wineryName'], $condition);
    } else {
      $condition = -1;
    }
  }
  if (isset($_GET['region']) && $_GET['region'] != "") {
    $selectedRegion = $_GET['region'];
    if ($condition != -1) {
      if ($_GET['region'] != "All") {
        $condition = addRegionCondition($_GET['region'], $condition);
      }
    } else {
      $condition = -1;
    }
  }
  if (isset($_GET['grapeVariety']) && $_GET['grapeVariety'] != "") {
    $selectedGrapeVariety = $_GET['grapeVariety'];
    if ($condition != -1) {
      if ($_GET['grapeVariety'] != "All") {
        $condition = addGrapeVarietyCondition($_GET['grapeVariety'], $condition);
      }
    } else {
      $condition = -1;
    }
  }
  if (isset($_GET['yearFrom']) && isset($_GET['yearTo']) && ($_GET['yearFrom'] != "" || $_GET['yearTo'] != "")) {
    $yearFrom = $_GET['yearFrom'];
    $yearTo = $_GET['yearTo'];
    $errYearRange = validateRange($_GET['yearFrom'],$_GET['yearTo'], "Year From", "Year To");
    if ($errYearRange == "" && $condition != -1) {
      $condition = addYearRangeCondition($_GET['yearFrom'], $_GET['yearTo'], $condition);
    } else {
      $condition = -1;
    }
  }
  if (isset($_GET['minInStock']) && $_GET['minInStock'] != "") {
    $minInStock = $_GET['minInStock'];
    $errMinInStock = validateNum($_GET['minInStock'], 0, 9999);
    if ($errMinInStock == "" && $condition != -1) {
      $condition = addMinInStockCondition($_GET['minInStock'], $condition);
    } else {
      $condition = -1;
    }
  }
  if (isset($_GET['minOrdered']) && $_GET['minOrdered'] != "") {
    $minOrdered = $_GET['minOrdered'];
    $errMinOrdered = validateNum($_GET['minOrdered'], 0, 9999);
    if ($errMinOrdered == "" && $condition != -1) {
      $condition = addMinOrderedCondition($_GET['minOrdered'], $condition);
    } else {
      $condition = -1;
    }
  }
  if (isset($_GET['minCost']) && $_GET['minCost'] != "") {
    $minCost = $_GET['minCost'];
    $errMinCost = validateDecimalNum($_GET['minCost'], 2, 0, 999999);
    if ($errMinCost == "" && $condition != -1) {
      $condition = addMinCostCondition($_GET['minCost'], $condition);
    } else {
      $condition = -1;
    }
  }
  if (isset($_GET['maxCost']) && $_GET['maxCost'] != "") {
    $maxCost = $_GET['maxCost'];
    $errMaxCost = validateDecimalNum($_GET['maxCost'], 2, 0, 999999);
    if ($errMaxCost == "" && isset($_GET['minCost']) && $_GET['minCost'] != "") {
      $errMaxCost = validateRange($_GET['minCost'],$_GET['maxCost'], "Min. Cost", "Max. Cost");
    }
    if ($errMaxCost == "" && $condition != -1) {
      $condition = addMaxCostCondition($_GET['maxCost'], $condition);
    } else {
      $condition = -1;
    }
  }
?>

<form id="search-form" action="searchResult.php" method="get">
  <h1>Wine Search</h1>
  <table border="1">
    <tr>
      <td>Wine Name</td>
      <td>
        <input type="text" name="wineName" value="<?php echo $_GET['wineName']; ?>" />
        <?php echo $errWineName; ?>
      </td>
    </tr>
    <tr>
      <td>Winery Name</td>
      <td>
        <input type="text" name="wineryName" value="<?php echo $_GET['wineryName']; ?>" />
        <?php echo $errWineryName; ?>
      </td>
    </tr>
    <tr>
      <td>Region</td>
      <td>
        <select name="region">
          <?php
            foreach ($regions as $region) {
              if ($region[0] == $selectedRegion) {
                echo "<option value=\"".$region[0]."\" selected=\"selected\">".$region[0]."</option>";
              } else {
                echo "<option value=\"".$region[0]."\">".$region[0]."</option>";
              }
            }
          ?>
        </select>
      </td>
    </tr>
    <tr>
      <td>Grape variety</td>
      <td>
        <select name="grapeVariety">
          <option value="All">All</option>
          <?php
            foreach ($grapeVarieties as $grapeVariety) {
              if ($grapeVariety[0] == $selectedGrapeVariety) {
                echo "<option value=\"".$grapeVariety[0]."\" selected=\"selected\">".$grapeVariety[0]."</option>";
              } else {
                echo "<option value=\"".$grapeVariety[0]."\">".$grapeVariety[0]."</option>";
              }
            }
          ?>
        </select>
      </td>
    </tr>
    <tr>
      <td>Year Range</td>
      <td>
        from
        <select name="yearFrom">
          <option value=""></option>
          <?php
            for ($i=$wineYearMinMax[0];$i<=$wineYearMinMax[1];$i++) {
              if ($i == $yearFrom) {
                echo "<option value=\"".$i."\" selected=\"selected\">".$i."</option>";
              } else {
                echo "<option value=\"".$i."\">".$i."</option>";
              }
            }
          ?>
        </select>
        to
        <select name="yearTo">
          <option value=""></option>
          <?php
            for ($i=$wineYearMinMax[0];$i<=$wineYearMinMax[1];$i++) {
              if ($i == $yearTo) {
                echo "<option value=\"".$i."\" selected=\"selected\">".$i."</option>";
              } else {
                echo "<option value=\"".$i."\">".$i."</option>";
              }
            }
          ?>
        </select>
        <?php echo $errYearRange; ?>
      </td>
    </tr>
    <tr>
      <td>In stock (Min.)</td>
      <td>
        <input type="text" name="minInStock" value="<?php echo $_GET['minInStock']; ?>" />
        <?php echo $errMinInStock; ?>
      </td>
    </tr>
    <tr>
      <td>Ordered (Min.)</td>
      <td>
        <input type="text" name="minOrdered" value="<?php echo $_GET['minOrdered']; ?>" />
        <?php echo $errMinOrdered; ?>
      </td>
    </tr>
    <tr>
      <td>Cost (Min.)</td>
      <td>
        <input type="text" name="minCost" value="<?php echo $_GET['minCost']; ?>" />
        <?php echo $errMinCost; ?>
      </td>
    </tr>
    <tr>
      <td>Cost (Max.)</td>
      <td>
        <input type="text" name="maxCost" value="<?php echo $_GET['maxCost']; ?>" />
        <?php echo $errMaxCost; ?>
      </td>
    </tr>
    <tr>
      <td colspan="2">
        <input type="submit" value="Search" />
      </td>
    </tr>
  </table>
</form>
