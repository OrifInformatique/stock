var base_url = "http://localhost/stock/";

function changeRegion() {
  location.href = base_url + "admin/" + document.getElementById("regions") + "/";
}
