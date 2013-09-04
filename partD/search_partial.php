<?php

require_once('MiniTemplator.class.php');
require_once('dbConnection.php');
require_once('validation.php');

function generateSearchForm() {
  $t = new MiniTemplator;
  $ok = $t->readTemplateFromFile("search_partial_template.htm");
  if (!$ok) die ("MiniTemplator.readTemplateFromFile failed.");
  
  $regions = getRegion();
  $grapeVarieties = getGrapeVariety();
  $wineYearMinMax = getWineYearMinMax();
  if (isset($_GET['wineName']) && $_GET['wineName'] != "") {
    $wineName = $_GET['wineName'];
    $errWineName = validateText($_GET['wineName'], 30);
    $t->setVariable("wineName", $_GET['wineName']);
    $t->setVariable("errWineName", $errWineName);
    if ($errWineName == "") {
      $condition = addWineNameCondition($_GET['wineName'], "");
    } else {
      $condition = -1;
    }
  }
  if (isset($_GET['wineryName']) && $_GET['wineryName'] != "") {
    $wineryName = $_GET['wineryName'];
    $errWineryName = validateText($_GET['wineryName'], 30);
    $t->setVariable("wineryName", $_GET['wineryName']);
    $t->setVariable("errWineryName", $errWineryName);
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
  foreach ($regions as $region) {
    $t->setVariable("region", $region);
    if ($region == $selectedRegion) {
      $t->addBlock("regionOptionSelected");
    } else {
      $t->addBlock("regionOption");
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
  foreach ($grapeVarieties as $grapeVariety) {
    $t->setVariable("grapeVariety", $grapeVariety);
    if ($grapeVariety == $selectedGrapeVariety) {
      $t->addBlock("grapeVarietyOptionSelected");
    } else {
      $t->addBlock("grapeVarietyOption");
    }
  }
  if (isset($_GET['yearFrom']) && isset($_GET['yearTo']) && ($_GET['yearFrom'] != "" || $_GET['yearTo'] != "")) {
    $yearFrom = $_GET['yearFrom'];
    $yearTo = $_GET['yearTo'];
    $errYearRange = validateRange($_GET['yearFrom'],$_GET['yearTo'], "Year From", "Year To");
    $t->setVariable("errYearRange", $errYearRange);
    if ($errYearRange == "" && $condition != -1) {
      $condition = addYearRangeCondition($_GET['yearFrom'], $_GET['yearTo'], $condition);
    } else {
      $condition = -1;
    }
  }
  for ($i=$wineYearMinMax[0];$i<=$wineYearMinMax[1];$i++) {
    $t->setVariable("yearFrom", $i);
    if ($i == $yearFrom) {
      $t->addBlock("yearFromOptionSelected");
    } else {
      $t->addBlock("yearFromOption");
    }
    $t->setVariable("yearTo", $i);
    if ($i == $yearTo) {
      $t->addBlock("yearToOptionSelected");
    } else {
      $t->addBlock("yearToOption");
    }
  }
  if (isset($_GET['minInStock']) && $_GET['minInStock'] != "") {
    $minInStock = $_GET['minInStock'];
    $errMinInStock = validateNum($_GET['minInStock'], 0, 9999);
    $t->setVariable("minInStock", $_GET['minInStock']);
    $t->setVariable("errMinInStock", $errMinInStock);
    if ($errMinInStock == "" && $condition != -1) {
      $condition = addMinInStockCondition($_GET['minInStock'], $condition);
    } else {
      $condition = -1;
    }
  }
  if (isset($_GET['minOrdered']) && $_GET['minOrdered'] != "") {
    $minOrdered = $_GET['minOrdered'];
    $errMinOrdered = validateNum($_GET['minOrdered'], 0, 9999);
    $t->setVariable("minOrdered", $_GET['minOrdered']);
    $t->setVariable("errMinOrdered", $errMinOrdered);
    if ($errMinOrdered == "" && $condition != -1) {
      $condition = addMinOrderedCondition($_GET['minOrdered'], $condition);
    } else {
      $condition = -1;
    }
  }
  if (isset($_GET['minCost']) && $_GET['minCost'] != "") {
    $minCost = $_GET['minCost'];
    $errMinCost = validateDecimalNum($_GET['minCost'], 2, 0, 999999);
    $t->setVariable("minCost", $_GET['minCost']);
    $t->setVariable("errMinCost", $errMinCost);
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
    $t->setVariable("maxCost", $_GET['maxCost']);
    $t->setVariable("errMaxCost", $errMaxCost);
    if ($errMaxCost == "" && $condition != -1) {
      $condition = addMaxCostCondition($_GET['maxCost'], $condition);
    } else {
      $condition = -1;
    }
  }
  $t->generateOutput();
  return $condition;
}

$condition = generateSearchForm();

?>
