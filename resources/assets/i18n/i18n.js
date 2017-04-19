var ua = navigator.userAgent.toLowerCase();
if(ua.indexOf("msie") > -1){//IE
	var language=navigator.browserLanguage.toLowerCase();
	insertJS();
}
else if(ua.indexOf("gecko") > -1){//FF
	var language=navigator.language.toLowerCase();
	insertJS();
}

function insertJS(){
	if(language.indexOf("en-us")>-1){
		document.writeln('<script type="text/javascript" src="en.js"></script>');
	}
	else if(language.indexOf("zh-cn")>-1){
		document.writeln('<script type="text/javascript" src="cn.js"></script>');
	}
}
