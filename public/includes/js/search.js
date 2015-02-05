/**
 * Created by matt on 18/12/14.
 */

// Get an XmlHttpRequest Object
function getXmlHttpRequestObject() {
    if (window.XMLHttpRequest) {
        return new XMLHttpRequest();
    } else if(window.ActiveXObject) {
        return new ActiveXObject("Microsoft.XMLHTTP");
    } else {
        alert("Your browser doesn't support search on this site - please upgrade to a newer one");
    }
}

// Called when keyup happens in the search box, starts the API request
function searchSuggest(searchBox) {
    var str = escape(document.getElementById(searchBox).value);
    API.GET
}