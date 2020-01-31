<form id="form" class="container" method="post" action="add_picture" >
    <?php if (isset($upload_error)) { ?>
    <div class="row alert alert-danger"><?=$upload_error?></div>
    <?php } ?>

    <!-- The Cropper.js library requires the manipulated image to be in a div -->
    <div class="row">
        <div id="cropArea" class="col-xs-10 col-xs-offset-1 form-group">
            <img id="image" style="height:auto; width:100%;" />
        </div>
    </div>
    <div class="hidden">
        <img id="canvas" width="360" height="360" />
    </div>
    <div class="row">
        <!-- Hidden file button, on which a click is simulated when user is clicking on one of the visible buttons -->
        <input id="imageInput" name="original_file" type="file" accept="image/*" class="btn hidden" />
        
        <div class="col-sm-6 form-group">
            <!-- Two buttons to differentiate taking a new picture or importing an existing one -->
            <input id="cameraImport" type="button" value="<?= $this->lang->line("field_take_photo"); ?>" class="btn btn-default" />
            <input id="imageImport" type="button" value="<?= $this->lang->line("field_import_photo"); ?>" class="btn btn-default" />
        </div>

        <!-- Hidden field used to store the cropped image -->
        <input id="croppedFile" name="cropped_file" type="hidden" />
        
        <div class="col-sm-6 form-group">
            <!-- Save / cancel Buttons -->
            <input type="submit" value="<?= $this->lang->line('field_validate_photo'); ?>" class="btn btn-success" />
            <a href="<?= $_SESSION['picture_callback'] ?>" class="btn btn-danger"><?= $this->lang->line('btn_cancel'); ?></a>
        </div>
    </div>
</form>

<link href="<?=base_url("assets/css/cropper/cropper.css");?>" rel="stylesheet">
<script src="<?=base_url("assets/js/external/cropper/cropper.js");?>" type="module"></script>

<script>
// Get every HTML element required for the code
var rawImage = document.getElementById("image");
var btnImageInput = document.getElementById("imageInput");
var btnCameraImport = document.getElementById("cameraImport");
var btnImageImport = document.getElementById("imageImport");
var croppedFileInput = document.getElementById("croppedFile");
var canvas = document.getElementById("canvas");
var form = document.getElementById("form");

// Initialization a void Cropper and a croppedImage, for later use
var cropper = null;
var croppedImage = null;

// Define image upload dimensions
const IMAGE_UPLOAD_WIDTH = <?= IMAGE_UPLOAD_WIDTH; ?>;
const IMAGE_UPLOAD_HEIGHT = <?= IMAGE_UPLOAD_HEIGHT; ?>;

//
function reSelectPhoto(event)
{
    var path = "<?= isset($_SESSION['POST']['image']) && !empty($_SESSION['POST']['image'])? $_SESSION['POST']['image'] : "" ?>";
    
    if(path !== ""){
        image.src = "<?= base_url("uploads/images/".$_SESSION['POST']['image'])?>";
        btnImageInput.name = path;
        setCropper();
    }
}

// Show the photo taken with the user's camera / imported from the user's files
function showPhoto(origin){
    var reader = new FileReader();
    var file;
    
    reader.onload = setPhoto;
    
    file = imageInput.files[0];
    
    reader.readAsDataURL(file);
}

// Set the photo taken with the user's camera / imported from the user's files
function setPhoto(event){
    rawImage.src = event.target.result;
    
    setCropper(event);
}

// Setup events for every button
btnCameraImport.addEventListener("click",clickInput);
btnImageImport.addEventListener("click",clickInput);
window.addEventListener("load",reSelectPhoto);

btnImageInput.addEventListener("change", showPhoto);

form.addEventListener("submit", cropImage);

// Setup a Cropper with a 1:1 aspect ratio
function setCropper(event){
    
    if(cropper !== null){
        cropper.destroy();
    }
    
    cropper = new Cropper(image, {
        aspectRatio : 1,
        autoCropArea: 1.0,
        preview: '.img-preview',
        minCanvasWidth: IMAGE_UPLOAD_WIDTH,
        minCanvasHeight: IMAGE_UPLOAD_HEIGHT,
        movable: false,
        rotatable: false,
        scalable: false,
        viewMode: 1
    });
}

// Simulate a click on the hidden input with the matching image's source
function clickInput(){
    if(event.target.id == btnCameraImport.id){
        btnImageInput.setAttribute("capture", "camera");
        btnImageInput.click();
    }else if(event.target.id == btnImageImport.id){
        btnImageInput.removeAttribute("capture");
        btnImageInput.click();
    }
}


// Convert the cropped image into a new image
function cropImage(event){
    if(cropper !== null){
        croppedImage = cropper.getCroppedCanvas({width: IMAGE_UPLOAD_WIDTH, height: IMAGE_UPLOAD_HEIGHT, imageSmoothingQuality: "high"});
        canvas.src = croppedImage.toDataURL("image/png");
        croppedFileInput.files[0] = canvas;
        
        return false;
    }
}
</script>
