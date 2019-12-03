<div class="container">
    <div clas="row">
        <form>
            <h6>Prendre une photo</h6>
            <input id="camera" type="file" accept="image/*" capture="camera" onchange="showPhoto('camera')" />
            <h6>Importer une photo</h6>
            <input id="import" type="file" accept="image/*" onchange="showPhoto('import')" />
            <img id="image" />
            <canvas id="canvas" width="360" height="360"></canvas>
        </form>
    </div>
</div>
<script src="<?=base_url("assets/js/jquery.imgareaselect.dev.js");?>" type="text/javascript"></script>
<script src="<?=base_url("assets/js/photo.js");?>" type="text/javascript"></script>
<script src="<?=base_url("assets/js/external/cropper/cropper.js");?>" type="module"></script>
<link rel="stylesheet" href="<?=base_url("assets/css/imgareaselect/imgareaselect-default.css");?>">
<link href="<?=base_url("assets/css/cropper/cropper.css");?>" rel="stylesheet">