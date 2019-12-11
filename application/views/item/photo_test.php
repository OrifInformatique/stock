<div class="container">
    <div clas="row">
        <form>
            <h6>Prendre une photo</h6>
            <input id="camera" type="file" accept="image/*" capture="camera" />
            <h6>Importer une photo</h6>
            <input id="import" type="file" accept="image/*" />
            <!-- The Cropper.js library requires the image to be manipulated to be on a div -->
            <div>
                <img id="image" />
            </div>
            <input id="crop" type="button" value="Rogner">
            <img id="canvas" width="360" height="360"></img>
        </form>
    </div>
</div>
<link href="<?=base_url("assets/css/cropper/cropper.css");?>" rel="stylesheet">
<script src="<?=base_url("assets/js/external/cropper/cropper.js");?>" type="module"></script>
<script>
// Get every HTML element required for the code
var selection = document.getElementById("selection");
var rawImage = document.getElementById("image");
var btnCamera = document.getElementById("camera");
var btnImport = document.getElementById("import");
var btnCrop = document.getElementById("crop");
var canvas = document.getElementById("canvas");

// Initialization a void Cropper and a croppedImage, for later use
var cropper = null;
var croppedImage = null;

// Define image upload dimensions
const IMAGE_UPLOAD_WIDTH = <?= IMAGE_UPLOAD_WIDTH ?>;
const IMAGE_UPLOAD_HEIGHT = <?= IMAGE_UPLOAD_HEIGHT ?>;

// Show the photo taken with the user's camera / imported from the user's files
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

// Set the photo taken with the user's camera / imported from the user's files
function setPhoto(event){
    rawImage.src = event.target.result;
    
    setChopper(event);
}

// Setup events for every button
btnCamera.addEventListener("change", showPhoto);

btnImport.addEventListener("change", showPhoto);

btnCrop.addEventListener("click", cropImage);

// Setup a Cropper with a 1:1 aspect ratio
function setChopper(event){
    cropper = new Cropper(image, {
        aspectRatio : 1,
        preview: '.img-preview',
        movable: false,
        rotatable: false,
        scalable: false,
        zoomable: false,
        ready: cropperReady,
        cropmove: cropImage
    });
}

// Write a log on the console (Only for debugging purpose)
// Also setup the cropped image's printing
function cropperReady(event){
    console.log("Cropper ready");
    
    cropImage();
}

// Convert the cropped image into a new image
function cropImage(event){
    if(cropper !== null){
        croppedImage = cropper.getCroppedCanvas({width: IMAGE_UPLOAD_WIDTH, height: IMAGE_UPLOAD_HEIGHT, imageSmoothingQuality: "high"});
        canvas.src = croppedImage.toDataURL("image/png");
    }
}
</script>
<style>
    /* Ensure the size of the image fit the container perfectly */
    image {
      display: block;
      
      /* This rule is very important, please don't ignore this */
      max-width: 100%;
    }
</style>