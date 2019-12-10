<div class="container">
    <div clas="row">
        <form>
            <h6>Prendre une photo</h6>
            <input id="camera" type="file" accept="image/*" capture="camera" />
            <h6>Importer une photo</h6>
            <input id="import" type="file" accept="image/*" />
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
<script src="<?=base_url("assets/js/photo.js");?>" type="module"></script>
<style>
    /* Ensure the size of the image fit the container perfectly */
    image {
      display: block;
      
      /* This rule is very important, please don't ignore this */
      max-width: 100%;
    }
</style>