var selection = document.getElementById("selection");
var rawImage = document.getElementById("image");
var btnCamera = document.getElementById("camera");
var btnImport = document.getElementById("import");
var btnCrop = document.getElementById("crop");
var canvas = document.getElementById("canvas");
var cropper = null;
var croppedImage = null;

// Show the photo taken with the user's camera
function showPhoto(origin){
    var reader = new FileReader();
    var file;
    
    reader.onload = setPhoto;
    
    if(origin.srcElement.id === "camera"){
        file = btnCamera.files[0];
    }else if(origin.srcElement.id === "import"){
        file = btnImport.files[0];
    }else{
        console.log("Error ! : Component not found");
    }
    
    reader.readAsDataURL(file);
}

// Set the photo taken with the user's camera
function setPhoto(event){
    rawImage.src = event.target.result;
    
    setChopper(event);
}

btnCamera.addEventListener("change", showPhoto);

btnImport.addEventListener("change", showPhoto);

btnCrop.addEventListener("click", cropImage);

function setChopper(event){
    cropper = new Cropper(image, {
        aspectRatio : 1,
        preview: '.img-preview',
        ready: chopperReady
    });
}

function chopperReady(event){
    console.log("Ready");
}

function cropImage(event){
   croppedImage = cropper.getCroppedCanvas({maxWidth: 360, maxHeight: 360});
   canvas.src = croppedImage;
}