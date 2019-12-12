<div class="container">
    <div clas="row">
        <form>
            <h6 id="inputHeader"><?= $this->lang->line("field_take_photo"); ?></h6>
            <input id="cameraImport" type="file" accept="image/*" capture="camera" />
            <input id="toggleImport" type="button" value="<?= $this->lang->line("field_import_photo") ?>">
            <!-- The Cropper.js library requires the image to be manipulated to be on a div -->
            <div>
                <img id="image" />
            </div>
            <img id="canvas" width="360" height="360"></img>
        </form>
    </div>
</div>
<link href="<?=base_url("assets/css/cropper/cropper.css");?>" rel="stylesheet">
<script src="<?=base_url("assets/js/external/cropper/cropper.js");?>" type="module"></script>
<script>
// Get every HTML element required for the code
var rawImage = document.getElementById("image");
var btnCameraImport = document.getElementById("cameraImport");
var btnToggleImport = document.getElementById("toggleImport");
var inputHeader = document.getElementById("inputHeader");
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
    
    file = cameraImport.files[0];
    
    reader.readAsDataURL(file);
}

// Set the photo taken with the user's camera / imported from the user's files
function setPhoto(event){
    rawImage.src = event.target.result;
    
    setChopper(event);
}

// Setup events for every button
btnCameraImport.addEventListener("change", showPhoto);

btnToggleImport.addEventListener("click", changeInputButton);

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

// Change the import button's behavoir between taking a picture or selecting one
function changeInputButton(event){
    const TAKE_IMAGE = "<?= $this->lang->line("field_take_photo"); ?>";
    const SELECT_IMAGE = "<?= $this->lang->line("field_import_photo") ?>";
    
    // Change to selection
    if(btnCameraImport.getAttribute("capture") === "camera"){
        btnCameraImport.removeAttribute("capture");
        btnToggleImport.value = TAKE_IMAGE;
        inputHeader.innerText = SELECT_IMAGE;
    }else{
    // Change to take
        btnCameraImport.setAttribute("capture","camera");
        btnToggleImport.value = SELECT_IMAGE;
        inputHeader.innerText = TAKE_IMAGE;
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