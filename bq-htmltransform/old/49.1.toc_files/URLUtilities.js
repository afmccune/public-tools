// $Id: $
// Copyright (c) 2010 Serials Solutions. All rights reserved.

function replaceParamAndReload(param, value) {
   var oldURL = document.location.href;
   var newURL = '';
   if (oldURL.indexOf(param) > 0) {
	   newURL = oldURL.replace(new RegExp(param + "=[^&]+", ""), param + "=" + value);
   } else {
	   if (oldURL.indexOf("?") > 0) {
		   newURL = oldURL + "&" + param + "=" + value;
	   }
	   else {
		   newURL = oldURL + "?" + param + "=" + value;
	   }
   }
   location.href = newURL;
} 

function resultsSortByReload(htmlSelect, param, value, previousValue) {
   var oldURL = document.location.href;
   var newURL = '';
   
   //replace the B parameter with an empty string so it goes back to the first page when switching
   //between sort by types
   if (oldURL.indexOf("&B=") > 0) {
	   newURL = oldURL.replace(new RegExp("&B=[^&]+", ""), "");
   }
   else {
	   newURL = oldURL;
   }
   
   if (newURL.indexOf(param) > 0) {
	   newURL = newURL.replace(new RegExp(param + "=[^&]+", ""), param + "=" + value);
   } else {
	   if (newURL.indexOf("?") > 0) {
		   newURL = newURL + "&" + param + "=" + value;
	   }
	   else {
		   newURL = newURL + "?" + param + "=" + value;
	   }
   }
   
   htmlSelect.value = previousValue;
   location.href = newURL;
}





