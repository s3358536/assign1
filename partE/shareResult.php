<?php

require_once('session.php');
require_once('twitterConnection.php');
require_once('MiniTemplator.class.php'); 

function generateSharePage() {
  $t = new MiniTemplator;
  $ok = $t->readTemplateFromFile("shareResult_template.htm");
  if (!ok) die ("MiniTemplator.readTemplateFromFile failed.");
  $t->setVariable("urlBackPage", $_SERVER['HTTP_REFERER']);
  sendTwitter("");

  $t->generateOutput();
}

generateSharePage();

?>
