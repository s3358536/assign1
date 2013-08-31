<?php include "header.php" ?>
  <h1>Wine Search</h1>
  <table border="1">
    <tr>
      <td>Wine Name</td>
      <td><input type="text" name="wineName"></td>
    </tr>
    <tr>
      <td>Winery Name</td>
      <td><input type="text" name="wineName"></td>
    </tr>
    <tr>
      <td>Region</td>
      <td>
        <select name="region">
          <option value="region1">region1</option>
        </select>
      </td>
    </tr>
    <tr>
      <td>Grape variety</td>
      <td>
        <select name="region">
          <option value="variety1">variety1</option>
        </select>
      </td>
    </tr>
    <tr>
      <td>Year Range</td>
      <td>
        From
        <select name="yearFrom">
          <option value="1">1</option>
        </select>
        To
        <select name="yearTo">
          <option value="1">1</option>
        </select>
      </td>
    </tr>
    <tr>
      <td>In stock (Min.)</td>
      <td><input type="text" name="minInStock"></td>
    </tr>
    <tr>
      <td>Ordered (Min.)</td>
      <td><input type="text" name="minOrdered"></td>
    </tr>
    <tr>
      <td>Cost (Max.)</td>
      <td><input type="text" name="maxCost"></td>
    </tr>
    <tr>
      <td>Cost (Min.)</td>
      <td><input type="text" name="minCost"></td>
    </tr>
    <tr>
      <td colspan="2")>
        <input type="submit" value="Search" />
      </td>
  </table>
<?php include "footer.php" ?>
