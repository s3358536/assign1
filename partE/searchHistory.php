<?php

require_once('session.php');
require_once('MiniTemplator.class.php'); 

function generateHistoryPage() {
  $t = new MiniTemplator;
  $ok = $t->readTemplateFromFile("searchHistory_template.htm");
  if (!ok) die ("MiniTemplator.readTemplateFromFile failed.");
  $t->setVariable("urlBackPage", "index.php");
  if ($_SESSION['wineHistList'] == null) {
    $t->addBlock("resultNoRow");
  } else {
    $wineHistList = $_SESSION['wineHistList'];
    foreach ($wineHistList as $record) {
      foreach ($record as $field) {
        $t->setVariable("field", $field);
        $t->addBlock("resultCol");
      }
      $t->addBlock("resultRow");
    }
  }
  $t->addBlock("resultLayout");
  $t->generateOutput();
}

generateHistoryPage();

?>
