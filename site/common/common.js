//日期函数
function getCurrentTime() {
	var create_time = new Date();
	var preString = "" + "0";

	var year = create_time.getFullYear();
	var month = String(parseInt(create_time.getMonth()) + 1);

	if (month.length < 2) {
		month = preString + month;
	}

	var day = String(create_time.getDate());
	if (day.length < 2) {
		day = preString + day;
	}
	
	var hour = String(create_time.getHours());
	if (hour.length < 2) {
		hour = preString + hour;
	}

	var min = String(create_time.getMinutes());
	if (min.length < 2) {
		min = preString + min;
	}

	var res = year + "-" + month + "-" + day + " " + hour + ":" + min;
	return res;
}

//读取 cookie
function loadCookie() {
	var myCookie = document.cookie;
	var splitedCookieContents = myCookie.split(";");
	var keysArr = ["name","password"];
	var resArr = [];
	for (var i = 0; i < keysArr.length; i++) {
		for (var j = 0; j < splitedCookieContents.length; j++) {
			var targetString = splitedCookieContents[j];
			if (targetString.search(keysArr[i]) != -1) {
				var targetArr = splitedCookieContents[j].split("=");
				var key = targetArr[0].trim();
				var value = targetArr[1].trim();
				resArr[key] = value;
				console.log(resArr);
				break;
			}
		}
	}
	return resArr;
}

//清理cookie
function deleteCookie(name) {
	document.cookie = name + '=; Path=/; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}


function getShortTime(completeTime) {
	return completeTime.substr(0,16);
}

// post/get like a form submit
function post(path, params, method) {
    method = method || "post"; // Set method to post by default if not specified.

    // The rest of this code assumes you are not using a library.
    // It can be made less wordy if you use one.
    var form = document.createElement("form");
    form.setAttribute("method", method);
    form.setAttribute("action", path);

    for(var key in params) {
        if(params.hasOwnProperty(key)) {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", params[key]);

            form.appendChild(hiddenField);
         }
    }

    document.body.appendChild(form);
    form.submit();
}