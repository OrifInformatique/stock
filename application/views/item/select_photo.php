<div class="container">
    <?php
        if (isset($upload_error)) {
            ?><div class="alert alert-danger"><?=$upload_error?></div><?php
        }
    ?>
    
    <form class="row" method="post" action="add_picture" >
        <!-- The Cropper.js library requires the image to be manipulated to be on a div -->
        <div id="cropArea" class="col-xs-9 col-sm-9">
            <img id="image" height="auto" width="100%" />
        </div>
        <div class="col-xs-3 col-sm-3">
            <img id="canvas" width="360" height="360" />
        </div>
        <div class="col-sm-12 col-xs-12 form-group">
            <h6 id="inputHeader"><?= $this->lang->line("field_take_photo"); ?></h6>
            <input id="cameraImport" name="original_file" type="file" accept="image/*" capture="camera" class="btn" />
            <input id="toggleImport" type="button" value="<?= $this->lang->line("field_import_photo") ?>" class="btn btn-default" />
            <input id="croppedFile" name="cropped_file" type="hidden" />
            <input type="submit" value="<?= $this->lang->line('field_validate_photo'); ?>" class="btn btn-success" />
            <a href="<?= $_SERVER['HTTP_REFERER'] ?>" class="btn btn-danger"><?= $this->lang->line('btn_cancel'); ?></a>
        </div>
    </form>
</div>
<link href="<?=base_url("assets/css/cropper/cropper.css");?>" rel="stylesheet">
<script src="<?=base_url("assets/js/external/cropper/cropper.js");?>" type="module"></script>
<script>
// Get every HTML element required for the code
var rawImage = document.getElementById("image");
var btnCameraImport = document.getElementById("cameraImport");
var btnToggleImport = document.getElementById("toggleImport");
var inputHeader = document.getElementById("inputHeader");
var cropArea = document.getElementById("cropArea");
var croppedFileInput = document.getElementById("croppedFile");
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
    
    setCropper(event);
}

// Setup events for every button
btnCameraImport.addEventListener("change", showPhoto);

btnToggleImport.addEventListener("click", changeInputButton);

// Setup a Cropper with a 1:1 aspect ratio
function setCropper(event){
    
    if(cropper !== null){
        cropper.destroy();
    }
    
    cropper = new Cropper(image, {
        aspectRatio : 1,
        preview: '.img-preview',
        minCropBoxWidth: IMAGE_UPLOAD_WIDTH,
        minCropBoxHeight: IMAGE_UPLOAD_HEIGHT,
        movable: false,
        rotatable: false,
        scalable: false,
        viewMode: 2,
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
        croppedFileInput.value = canvas.src;
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
        btnCameraImport.setAttribute("capture", "camera");
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