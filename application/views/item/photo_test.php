<div class="container">
    <div clas="row">
        <form>
            <video id="video" width="360" height="360" autoplay></video>
            <button id="snap" onclick="return false">Photo</button>
            <canvas id="canvas" width="360" height="360"></canvas>
            <input id="camera" type="file" accept="image/*" capture="camera" onchange="showPhoto()" />
            <img id="image" />
        </form>
    </div>
</div>
<script src="<?=base_url("assets/js/photo.js");?>" type="text/javascript"></script>
<script>

</script>