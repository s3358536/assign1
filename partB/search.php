<?php
  require_once('dbConnection.php');
  $regions = getRegion();
  $grapeVarieties = getGrapeVariety();
  $wineYearMinMax = getWineYearMinMax();
?>

<?php include "header.php"; ?>
  <form id="search-form" action="searchResult.php" method="get">
    <h1>Wine Search</h1>
    <table border="1">
      <tr>
        <td>Wine Name</td>
        <td><input type="text" name="wineName" /></td>
      </tr>
      <tr>
        <td>Winery Name</td>
        <td><input type="text" name="wineryName" /></td>
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
        </td>
      </tr>
      <tr>
        <td>In stock (Min.)</td>
        <td><input type="text" name="minInStock" /></td>
      </tr>
      <tr>
        <td>Ordered (Min.)</td>
        <td><input type="text" name="minOrdered" /></td>
      </tr>
      <tr>
        <td>Cost (Max.)</td>
        <td><input type="text" name="maxCost" /></td>
      </tr>
      <tr>
        <td>Cost (Min.)</td>
        <td><input type="text" name="minCost" /></td>
      </tr>
      <tr>
        <td colspan="2">
          <input type="submit" value="Search" />
        </td>
      </tr>
    </table>
  </form>
<?php include "footer.php"; ?>
