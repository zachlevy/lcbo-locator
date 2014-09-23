<?php

$root = "http://lcboapi.com";
$query = "/products/372078/stores?per_page=100";

$url = $root . $query;

$json_stores = file_get_contents($url);

$stores = json_decode($json_stores, TRUE);

$locations = array();

for ($i = 0; $i <= count($stores["result"]) - 1; $i++) {
  $location["id"] = $i;
  $location["name"] = $stores["result"][$i + 1]["name"];
  $location["lat"] = $stores["result"][$i + 1]["latitude"];
  $location["lng"] = $stores["result"][$i + 1]["longitude"];
  $location["address"] = $stores["result"][$i + 1]["address_line_1"];
  $location["address2"] = $stores["result"][$i + 1]["address_line_2"];
  $location["city"] = $stores["result"][$i + 1]["city"];
  $location["state"] = "ON";
  $location["postal"] = $stores["result"][$i + 1]["postal_code"];
  $location["phone"] = $stores["result"][$i + 1]["telephone"];
  $location["quantity"] = $stores["result"][$i + 1]["quantity"];
  
  array_push($locations, $location);
}

$json_locations = json_encode($locations);

echo $json_locations;

?>