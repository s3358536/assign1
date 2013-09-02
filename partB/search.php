<?php
  require_once('dbConnection.php');
  require_once('validation.php');
  $regions = getRegion();
  $grapeVarieties = getGrapeVariety();
  $wineYearMinMax = getWineYearMinMax();
  if (isset($_GET['wineName'])) {
    $wineName = $_GET['wineName'];
    $errWineName = validateText($_GET['wineName'], 30);
  }
  if (isset($_GET['wineryName'])) {
    $wineryName = $_GET['wineryName'];
    $errWineryName = validateText($_GET['wineryName'], 30);
  }
  if (isset($_GET['yearFrom']) && isset($_GET['yearTo'])) {
    $minInStock = $_GET['minInStock'];
    $errYearTo = compareMinMax($_GET['yearFrom'],$_GET['yearTo'], "Year From", "Year To");
  }
  if (isset($_GET['minInStock'])) {
    $minInStock = $_GET['minInStock'];
    $errMinInStock = validateNum($_GET['minInStock'], 0, 9999);
  }
  if (isset($_GET['minOrdered'])) {
    $minOrdered = $_GET['minOrdered'];
    $errMinOrdered = validateNum($_GET['minOrdered'], 0, 9999);
  }
  if (isset($_GET['minCost'])) {
    $minCost = $_GET['minCost'];
    $errMinCost = validateDecimalNum($_GET['minCost'], 2, 0, 999999);
  }
  if (isset($_GET['maxCost'])) {
    $maxCost = $_GET['maxCost'];
    $errMaxCost = validateDecimalNum($_GET['maxCost'], 2, 0, 999999);
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
              echo "<option value=\"".$region[0]."\">".$region[0]."</option>";
            }
          ?>
        </select>
      </td>
    </tr>
    <tr>
      <td>Grape variety</td>
      <td>
        <select name="grapeVariety">
          <?php
            foreach ($grapeVarieties as $grapeVariety) {
              echo "<option value=\"".$grapeVariety[0]."\">".$grapeVariety[0]."</option>";
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
          <?php
            for ($i=$wineYearMinMax[0];$i<=$wineYearMinMax[1];$i++) {
              echo "<option value=\"".$i."\">".$i."</option>";
            }
          ?>
        </select>
        to
        <select name="yearTo">
          <?php
            for ($i=$wineYearMinMax[0];$i<=$wineYearMinMax[1];$i++) {
              echo "<option value=\"".$i."\">".$i."</option>";
            }
          ?>
        </select>
        <?php echo $errYearTo; ?>
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
      <td>Cost (Max.)</td>
      <td>
        <input type="text" name="maxCost" value="<?php echo $_GET['maxCost']; ?>" />
        <?php echo $errMaxCost; ?>
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
      <td colspan="2">
        <input type="submit" value="Search" />
      </td>
    </tr>
  </table>
</form>
