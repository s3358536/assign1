<?php
  function validateText($text, $length) {
    $pattern = "/^[a-zA-Z\s]{0,".$length."}$/";
    if (!preg_match($pattern, $text)) {
      return "<div class=\"error\">Please input not more than ".$length." alphabet characters.</div>";
    }
    return "";
  }
  
  function validateNum($text, $min, $max) {
    $pattern = "/^[0-9]*$/";
    if (!preg_match($pattern, $text)) {
      return "<div class=\"error\">Please input a number.</div>";
    } else if ($text < $min || $text > $max) {
      return "<div class=\"error\">Please input a number between ".$min." and ".$max.".</div>";
    }
    return "";
  }
  
  function validateDecimalNum($text, $dec, $min, $max) {
    $pattern = "/^([0-9]+(.[0-9]{1,".$dec."}){0,1}){0,1}$/";
    if (!preg_match($pattern, $text)) {
      return "<div class=\"error\">Please input a number (or with ".$dec." decimal).</div>";
    } else if ($text < $min || $text > $max) {
      return "<div class=\"error\">Please input a number (or decimal) between ".$min." and ".$max.".</div>";
    }
    return "";
  }

  function validateRange($min, $max, $minName, $maxName) {
    if ($min == "" && $max != "") {
      return "<div class=\"error\">".$minName." is required.</div>";
    } else if ($min != "" && $max == "") {
      return "<div class=\"error\">".$maxName." is required.</div>";
    } else if ($min > $max) {
      return "<div class=\"error\">".$maxName." should be greater than or equal to ".$minName.".</div>";
    }
    return "";
  }
?>
