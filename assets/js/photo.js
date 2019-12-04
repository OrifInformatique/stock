var selection = document.getElementById("selection");
var image = document.getElementById("image");
var btnCamera = document.getElementById("camera");
var btnImport = document.getElementById("import");
var cropper = null;

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
    document.getElementById("image").src = event.target.result;
    
    setChopper(event);
}

btnCamera.addEventListener("change", showPhoto);

btnImport.addEventListener("change", showPhoto);

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