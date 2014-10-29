/**
 * Increases the opacity of the given element by 2% every 1ms until the opacity is one.
 *@param {String} elem Contains the id of the element for which the opacity is being increased.
 *@param {Number} num The integer value signifying the percentage opacity of the element.
 */
function fadeIn(elem, num) {
    document.getElementById(elem).style.filter = "alpha(opacity=" + num + ")";
    document.getElementById(elem).style.opacity = num/50;
    if (num < 50) {
        window.setTimeout(function(){fadeIn(elem, num+1)},1);
    }
}

/**
 * Decreases the opacity of the given element by 2% every 1ms until the opacity is zero.
 *@param {String} elem Contains the id of the element for which the opacity is being decreased.
 *@param {Number} num The integer value signifying the percentage opacity of the element.
 */
function fadeOut(elem, num) {
    document.getElementById(elem).style.filter = "alpha(opacity=" + num + ")";
    document.getElementById(elem).style.opacity = num/50;
    if (num > 0) {
        window.setTimeout(function(){fadeOut(elem, num-1)},1);
    }
}

/**
 * Changes the info button text and style. Begins the fade sequence to hide the info div.
 */
function hideInfo() {
    document.getElementById("btnInfo").innerHTML = "?";
    fadeOut("infoContainer", 50);
    document.getElementById("btnInfo").className = document.getElementById("btnInfo").className.replace(/\bbtn-danger\b/, "btn-info");
}

/**
 * Changes the info button text and style. Begins the fade sequence to show the info div.
 */
function showInfo() {
    document.getElementById("btnInfo").innerHTML = "X";
    fadeIn("infoContainer", 0);
    document.getElementById("btnInfo").className = document.getElementById("btnInfo").className.replace(/\bbtn-info\b/, "btn-danger");
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