var selection = document.getElementById("selection");
var image = document.getElementById("image");
var x1 = 0, y1 = 0, x2 = 0, y2 = 0;

// Setup mouse events
//image.onmousedown = beginSelect;
//image.touchstart = beginSelect;
//image.onmousemove = changeSelect;
//image.touchmove = changeSelect;
//image.onmouseup = endSelect;
//image.touchend = endSelect;

//image.addEventListener("mousedown", beginSelect, false);
//image.addEventListener("touchstart", beginSelect, false);
//image.addEventListener("mousemove", changeSelect, false);
//image.addEventListener("touchmove", changeSelect, false);
//image.addEventListener("mouseleave", endSelect, false);
//image.addEventListener("touchcancel", endSelect, false);
//image.addEventListener("mouseup", endSelect, false);
//image.addEventListener("touchend", endSelect, false);

// Show the selection div and setup it's first point
function beginSelect(e){
    selection.hidden = 0;
    
    if(e.touches === undefined){
        x1 = e.pageX;
        y1 = e.pageY;
    }else{
        x1 = e.touches[0].pageX;
        y1 = e.touches[0].pageY;
    }
    calculateSelection();
    console.log("Event début | x : " + x1 + " y : " + y1);
}

// Update in real time the selection div's last point
function changeSelect(e){
    if(e.touches === undefined){
        x2 = e.pageX;
        y2 = e.pageY;
    }else{
        x2 = e.touches[0].pageX;
        y2 = e.touches[0].pageY;
    }
    calculateSelection();
    console.log("Event millieu | x : " + x2 + " y : " + y2);
}

// Hide the selection
function endSelect(e){
    selection.hidden = 1;
    console.log("Event fin");
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

$(document).ready(function () {
        $('img#image').imgAreaSelect({
            aspectRatio: "1:1",
            handles: true,
            //onSelectStart: beginSelect,
            //onSelectChange: changeSelect,
            //onSelectEnd: endSelect
        });
});