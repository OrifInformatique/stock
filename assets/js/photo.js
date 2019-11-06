var canvas = document.getElementById('canvas');
var context = canvas.getContext('2d');
var video = document.getElementById('video');

if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia){
    navigator.mediaDevices.getUserMedia({video: true}).then(function(stream){
        video.srcObject = stream;
        video.play();
    });
}

document.getElementById("snap").addEventListener("click", function(){
   context.drawImage(video, 0,0, 360, 360); 
});

function showPhoto(){
    var reader = new FileReader();
    
    reader.onload = function (e) {
        document.getElementById("image").src = e.target.result;
    };
    
    reader.readAsDataURL(this.result[0]);
}