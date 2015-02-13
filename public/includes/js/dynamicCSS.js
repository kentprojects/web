function getHeight() {
  if (self.innerHeight) {
    return self.innerHeight;
  }
  else if (document.documentElement && document.documentElement.clientHeight) {
    return document.documentElement.clientHeight;
  }
  else if (document.body) {
    return document.body.clientHeight;
  }
}

function getWidth() {
  if (self.innerHeight) {
    return self.innerWidth;
  }
  else if (document.documentElement && document.documentElement.clientHeight) {
    return document.documentElement.clientWidth;
  }
  else if (document.body) {
    return document.body.clientWidth;
  }
}

function checkDynamicCSS() {
    var currentWidth = getWidth();
    console.log(currentWidth < 500);
    if (currentWidth < 500) {
        reduceHeadings = document.getElementsByClassName('reduceHeading');
        for (var i = 0; i < reduceHeadings.length; i++) {
            reduceHeadings[i].style.fontSize="42px";
        }
    }
    else {
        reduceHeadings = document.getElementsByClassName('reduceHeading');
        for (var i = 0; i < reduceHeadings.length; i++) {
            reduceHeadings[i].style.fontSize="61px";
        }
    }
}

checkDynamicCSS();
window.onresize = function(event) {
    checkDynamicCSS();
};