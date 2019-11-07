var canvas = document.getElementById('canvas');
var context = canvas.getContext('2d');
var video = document.getElementById('video');
var selection = document.getElementById("selection");
var x1 = 0, y1 = 0, x2 = 0, y2 = 0;

// Record the camera's input and show it as a video
if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia){
    navigator.mediaDevices.getUserMedia({video: true}).then(function(stream){
        video.srcObject = stream;
        video.play();
    });
}

// Create a screenshot (360x360) of the camera when the snap button is pressed
document.getElementById("snap").addEventListener("click", function(){
   context.drawImage(video, 0,0, 360, 360); 
});

// Setup mouse events
onmousedown = beginSelect;
onmousemove = changeSelect;
onmouseup = endSelect;

// Show the selection div and setup it's first point
function beginSelect(e){
    selection.hidden = 0;
    x1 = e.clientX;
    y1 = e.clientY;
    calculateSelection();
}

// Update in real time the selection div's last point
function changeSelect(e){
    x2 = e.clientX;
    y2 = e.clientY;
    calculateSelection();
}

// Hide the selection
function endSelect(e){
    selection.hidden = 1;
}

// Draw the selection div
function calculateSelection(){
    var x3 = Math.min(x1, x2); // The first point's X position
    var x4 = Math.max(x1, x2); // The last point's X position
    var y3 = Math.min(y1, y2); // The first point's Y position
    var y4 = Math.max(y1, y2); // The last point's Y position
    
    selection.style.left = x3 + 'px';
    selection.style.top = y3 + 'px';
    selection.style.width = x4 - x3 + 'px';
    selection.style.height = y4 - y3 + 'px';
}

// Show the photo taken with the user's camera
function showPhoto(){
    var reader = new FileReader();
    
    reader.onload = setPhoto;
    
    reader.readAsDataURL(this.camera.files[0]);
}

// Set the photo taken with the user's camera
function setPhoto(event){
    document.getElementById("image").src = event.target.result;
}