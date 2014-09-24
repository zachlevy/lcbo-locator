<?php

$root = "http://lcboapi.com";
$products = explode(",", $_GET['products']);

$locations = array();

// for each product
foreach ($products as $product) {
  $url = $root . "/products/" . $product . "/stores?per_page=100";
  $locations = getInventory($url, $product, $locations);
}

// get the inventory from lcboapi
function getInventory ($url, $product, $locations) {
  $json_stores = file_get_contents($url);
  $stores = json_decode($json_stores, TRUE);
  $locations = addLocations($stores, $product, $locations);
  return $locations;
}

// add the locations to the locations array
function addLocations ($stores, $product, $locations) {
  // for each location for product
  for ($i = 0; $i <= count($stores["result"]) - 1; $i++) {
    if ($stores["result"][$i + 1]["quantity"] == null) {
      continue;
    }
    $found = FALSE;
    // go through each existing location
    foreach ($locations as $key => $existing_location) {
      $location["name"] = $stores["result"][$i + 1]["name"];
      if ($location["name"] == $existing_location["name"]) {
        $found = TRUE;
        $locations[$key]["quantity-" . $product] = $stores["result"][$i + 1]["quantity"];
      }
    }
    if ($found == FALSE) {
      $location["id"] = count($locations) + 1;
      $location["lat"] = $stores["result"][$i + 1]["latitude"];
      $location["lng"] = $stores["result"][$i + 1]["longitude"];
      $location["address"] = $stores["result"][$i + 1]["address_line_1"];
      $location["address2"] = $stores["result"][$i + 1]["address_line_2"];
      $location["city"] = $stores["result"][$i + 1]["city"];
      $location["state"] = "ON";
      $location["postal"] = $stores["result"][$i + 1]["postal_code"];
      $location["phone"] = $stores["result"][$i + 1]["telephone"];
      $location["quantity-" . $product] = $stores["result"][$i + 1]["quantity"];
      array_push($locations, $location);
    }
  }
  return $locations;
}

// checks through all locations and makes any missing products 0
function checkEmpties ($locations, $products) {
  foreach ($locations as $key => $location) {
    foreach ($products as $product) {
      if (isset($locations[$key]["quantity-" . $product])) {
        
      } else {
        $locations[$key]["quantity-" . $product] = 0;
      }
    }
  }
  return $locations;
}

$locations = checkEmpties($locations, $products);

$json_locations = json_encode($locations);

echo $json_locations;

?>