<?php

require_once('MiniTemplator.class.php'); 
require_once('dbConnection.php');
require_once('search_partial.php');

function generateResultPage($condition) {
  $t = new MiniTemplator;
  $ok = $t->readTemplateFromFile("searchResult_template.htm");
  if (!ok) die ("MiniTemplator.readTemplateFromFile failed.");
  if ($condition != -1) {
    $result = searchWine($condition);
    if (count($result) == 0) {
      $t->addBlock("resultNoRow");
    } else {
      $wineHistList = $_SESSION['wineHistList'];
      foreach ($result as $record) {
        foreach ($record as $field) {
          $t->setVariable("field", $field);
          $t->addBlock("resultCol");
        }
        $t->addBlock("resultRow");
        $wineRecord = null;
        $wineRecord[] = date("d/m/y H:m");
        $wineRecord[] = $record[0];
        $wineHistList[] = $wineRecord;
      }
      if (isset($_SESSION['session']) && $_SESSION['session'] == true) {
        $_SESSION['wineHistList'] = $wineHistList;
      }
    }
    $t->addBlock("resultLayout");
  }
  $t->generateOutput();
}

generateResultPage($condition);

?>
