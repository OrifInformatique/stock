var selection = document.getElementById("selection");
var image = document.getElementById("image");
var x1 = 0, y1 = 0, x2 = 0, y2 = 0;

// Show the photo taken with the user's camera
function showPhoto(origin){
    var reader = new FileReader();
    var file;
    
    reader.onload = setPhoto;
    
    if(origin === "camera"){
        file = this.camera.files[0];
    }else if(origin === "import"){
        file = this.import.files[0];
    }else{
        console.log("Erreur ! : Composent no found");
    }
    
    reader.readAsDataURL(file);
}

// Set the photo taken with the user's camera
function setPhoto(event){
    document.getElementById("image").src = event.target.result;
}

$(document).ready(function () {
        $('img#image').imgAreaSelect({
            aspectRatio: "1:1",
            handles: true,
            //onSelectStart: beginSelect,
            //onSelectChange: changeSelect,
            //onSelectEnd: endSelect
        });
});