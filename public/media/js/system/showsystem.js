function system(elem) {
    alert("ya raaab");
    var id = elem.id;
    var status;

    if (elem.innerHTML == "Close System") {
        status = 0;
    } else {
        status = 1;
    }


//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    var ajaxRequest = getXMLHttpRequest();
    
    ajaxRequest.open("GET", "/zend_project/public/system/changestatus?id=" + id + "&status=" + status);
    ajaxRequest.onreadystatechange = function () {
        alert(ajaxRequest.responseText);
        if (ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
            if (status == 0) {
                elem.innerHTML = "Open System";
            }
            else {
                elem.innerHTML = "Close System";
            }

        }
       
    }
     ajaxRequest.send();
}

function getXMLHttpRequest() {
    if (window.XMLHttpRequest) {
        var request = new XMLHttpRequest();
    }
    else {
        var request = new ActiveXObject("Microsoft.XMLHTTP");
    }
    return 	request;
}
