/*
GeoLine, Suhin. Version 0.0 for /stock/.
Coded in April 2017 by Daniel Meilland
License: CC0
Needs jQuery to work…
*/

function changeRegion() {
  location.href = "../view_" + $("#regions").val() + "s/";
}

function changeNew() {
  location.href = "../view_" + $("#regions").val() + "/";
}

function changeAction() {
  var action = $("#actions").val();
  if (action != "new") {
    location.href = "../" + action + "_" + $("#regions").val() + "/" + $("#rows").val();
  } else {
    location.href = "../" + action + "_" + $("#regions").val() + "/";
  }
}

function changeRow() {
  changeAction();
}
