// http://stackoverflow.com/questions/1038727/how-to-get-browser-width-using-javascript-code

function getHeight() {
  if (self.innerHeight) {
    return self.innerHeight;
  }

  if (document.documentElement && document.documentElement.clientHeight) {
    return document.documentElement.clientHeight;
  }

  if (document.body) {
    return document.body.clientHeight;
  }
}

function getWidth() {
  if (self.innerHeight) {
    return self.innerWidth;
  }

  if (document.documentElement && document.documentElement.clientHeight) {
    return document.documentElement.clientWidth;
  }

  if (document.body) {
    return document.body.clientWidth;
  }
}

//

function checkDynamicCSS() {
    var currentWidth = getWidth();
    console.log(currentWidth < 500);
    if (currentWidth < 500) {
        console.log("fuck you");

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