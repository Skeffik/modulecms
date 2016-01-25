<?
$uri = "";
if (array_key_exists("QUERY_STRING", $_SERVER)) {
  $uri = $_SERVER["QUERY_STRING"];
}
header("Location: ".$uri);
?>