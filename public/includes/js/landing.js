var backgroundImages = ["includes/img/kentbusiness.jpg","includes/img/kenteye.jpg","includes/img/students.jpg"];
var counter = 0;
var infoFadeSpeed = 30;

/*
 * Preload all images contained in the 'backgroundImages' array into the preLoad array.
 */
var preLoad = [];
for (var i = 0; i < backgroundImages.length; i++) {
    preLoad[i] = new Image();
    preLoad[i].src = backgroundImages[i];
}

/**
 * Calls the function to change the background image every 7 seconds.
 */
window.setInterval(function(){
    changeBackgroundImage();
}, 7000);

/**
 * Calls the function to change the background image every 7 seconds.
 */
function changeBackgroundImage() {
    document.getElementById("slideshowFront").style.backgroundImage = "url('" + backgroundImages[counter] + "')";
    counter = (counter + 1) % backgroundImages.length;
    document.getElementById("slideshowFront").style.filter = "alpha(opacity='1')";
    document.getElementById("slideshowFront").style.opacity = 1;
    document.getElementById("slideshowBack").style.backgroundImage = "url('" + backgroundImages[counter] + "')";
    fadeOut("slideshowFront", 50, 50, 1000);
}

/**
 * Increases the opacity of the given element by 2% every 1ms until the opacity is one.
 *@param {String} elem Contains the id of the element for which the opacity is being increased.
 *@param {Number} num The integer value signifying the percentage opacity of the element.
 */
function fadeIn(elem, num, max, time) {
    document.getElementById(elem).style.filter = "alpha(opacity=" + num + ")";
    document.getElementById(elem).style.opacity = num/max;
    if (num < infoFadeSpeed) {
        window.setTimeout(function(){ fadeIn(elem, num+1, max, time) }, time / max);
    }
}

/**
 * Decreases the opacity of the given element by 2% every 1ms until the opacity is zero.
 *@param {String} elem Contains the id of the element for which the opacity is being decreased.
 *@param {Number} num The integer value signifying the percentage opacity of the element.
 */
function fadeOut(elem, num, max, time) {
    document.getElementById(elem).style.filter = "alpha(opacity=" + num + ")";
    document.getElementById(elem).style.opacity = num / max;
    if (num > 0) {
        window.setTimeout(function(){ fadeOut(elem, num-1, max, time) }, time / max);
    }
}

/**
 * Changes the info button text and style. Begins the fade sequence to hide the info div.
 */
function hideInfo() {
    document.getElementById("btnAbout").innerHTML = "About";
    fadeOut("infoContainer", infoFadeSpeed, infoFadeSpeed, infoFadeSpeed * 10);
    document.getElementById("btnAbout").className = document.getElementById("btnAbout").className.replace(/\bbtn-danger\b/, "btn-info");
}

/**
 * Changes the info button text and style. Begins the fade sequence to show the info div.
 */
function showInfo() {
    document.getElementById("btnAbout").innerHTML = "Close";
    fadeIn("infoContainer", 0, infoFadeSpeed, infoFadeSpeed * 10);
    document.getElementById("btnAbout").className = document.getElementById("btnAbout").className.replace(/\bbtn-info\b/, "btn-danger");
}

/**
 * Switches the opacity of the information div from 0 to 1 or from 1 to 0.
 */
function switchInfoVisibility() {
    if (document.getElementById("infoContainer").style.opacity == 0) {
        showInfo();
    }
    else {
        hideInfo();
    }
}