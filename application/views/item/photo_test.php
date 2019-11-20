<div class="container">
    <div clas="row">
        <form>
            <h6>Prendre une photo</h6>
            <input id="camera" type="file" accept="image/*" capture="camera" onchange="showPhoto()" />
            <h6>Importer une photo</h6>
            <input id="camera" type="file" accept="image/*" onchange="showPhoto()" />
            <img id="image" width="360" height="360" />
            <div id="selection" hidden></div>
        </form>
    </div>
</div>
<script src="<?=base_url("assets/js/photo.js");?>" type="text/javascript"></script>
<style>
    #selection {
        border: 1px dotted #000;
        position: absolute;
    }
</style>