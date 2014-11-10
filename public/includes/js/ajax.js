var API = {};

API.GET = function(url, query, success, error) {
	var r = new XMLHttpRequest();
	r.open("GET", "/ajax.php"+url+"?"+this._BuildQueryString(query), true);
	r.onreadystatechange = function () {
		if (r.readyState != 4) return;
		if ((r.status >= 200) && (r.status < 300))
		{
			success && success(JSON.parse(r.responseText));
		}
		else
		{
			error && error(JSON.parse(r.responseText))
		}
	};
	r.send();
};

API._BuildQueryString = function(query) {
	var query = query || {}, string = [];
	for(var p in query) string.push(p+"="+query[p]);
	return string.join("&");
};

API.POST = function(url, data, success, error) {
	var data = data || {},
		r = new XMLHttpRequest();
	r.open("POST", "/ajax.php"+url, true);
	r.onreadystatechange = function () {
		if (r.readyState != 4) return;
		// console.log(r, r.responseText);
		if ((r.status >= 200) && (r.status < 300))
		{
			success && success(JSON.parse(r.responseText));
		}
		else
		{
			error && error(JSON.parse(r.responseText))
		}
	};
	r.send(JSON.stringify(data));
};