//alert("here");
//alert(location.pathname);


/*
 * This function is used when adding new comment
 */
function reply(threadId, username , image) {

    //clear textarea
    alert("here");
    var textElm = document.getElementsByClassName("replyText")[0];
    var text = textElm.value;
    textElm.value = '';

    //ajax request
    $.post("/zend_project/public/reply/savereply",
            {
                thread_id: threadId,
                body: text
            },
    function (data, status) {
        var reply = jQuery.parseJSON(data);
        $("#replies").append("<div id='" + reply['replyId'] + "'" + " class='reply' >" +
                "<br><br>Posted by: <label>" + username +"</label>"+ //username
                "<img src='"+image+"' >" + //image
                reply['Date'] + "<br/>" +
                "<p>" + reply['body'] + "</p>" + // echo "<br>".$reply['body'];
                "<button onclick='edit(this)'>Edit</button>" +
                "<button onclick='deleteReply(this)'>Delete</button></div>"

                );
    });
}





//on edit
function edit(elem) {
    alert("there");

    var parDiv = elem.closest('div'); // this gets the closest div parent

    var repId = parDiv.id; // this gets the parent classes.
    console.log(repId);

    //get paragraph inside div
    var str = "#" + repId + ">p";
    var text =$(str).text();
    
    str = "#" + repId + ">img";
    var img = "'" + $(str)[0].src+"'";
    
    var str = "#" + repId + ">label";
    console.log ($(str));
    var name = "'"+ $(str)[0].innerHTML+"'";
    
    

    var textElm = document.getElementsByClassName("replyText")[0].cloneNode();
    parDiv.innerHTML = '';
    textElm.innerHTML = text;
    parDiv.appendChild(textElm);
    var funcString  = "editReply(this,"+ img+","+name+")";
    alert(funcString);
    
    parDiv.innerHTML += "<button onclick=\""+funcString+"\" >Edit</button>";
}


function editReply(elm , img , name) {    //update reply with ajax

    var newReply = elm.previousSibling.value;
    var parDiv = elm.closest('div'); // this gets the closest div parent
    var repId = parDiv.id; // this gets the parent classes.

    //ajax request
    $.post("/zend_project/public/reply/updatereply",
            {
                id: repId,
                body: newReply
            },
    function (data, status) {

        parDiv.innerHTML = "<br><br>Posted by: <label>"+ name +"</label> "+ //username
                "<img src="+img+" >" + //image
                "<label> Edited </label>" +
                getCurrentDATETIME() + "<br/>" +
                "<p>" + newReply + "</p>" +
                "<button onclick='edit(this)'>Edit</button>" +
                "<button onclick='deleteReply(this)'>Delete</button>";
    });
}


function deleteReply(elm) {

    alert("here");

    var parDiv = elm.closest('div'); // this gets the closest div parent
    var repId = parDiv.id; // this gets the parent classes.

    //ajax request
    $.post("/zend_project/public/reply/deletereply",
            {
                id: repId,
            },
            function (data, status) {

                parDiv.remove();
            });

}


function getCurrentDATETIME() {

    var currentdate = new Date();

    var month = currentdate.getMonth() + 1;
    if (month < 10)
        month = "0" + month;

    var day = currentdate.getDate();
    if (day < 10)
        day = "0" + day;

    var min = currentdate.getMinutes();
    if (min < 10)
        min = "0" + min;

    var second = currentdate.getSeconds();
    if (second < 10)
        second = "0" + second;

    var hour = currentdate.getHours();
    if (hour < 10)
        hour = "0" + hour;


    var datetime = currentdate.getFullYear() + "-"
            + month + "-"
            + day + " "
            + hour + ":"
            + min + ":"
            + second;


    return datetime;

}


//------------------------------------------------------------------------------
function editThread(elem,username , imgsrc) {

    var parDiv = $("#thread")[0];


    var textArea = document.getElementsByClassName("replyText")[0];
    var titleElm = textArea.cloneNode();
    titleElm.placeholder ='Add title..';
    titleElm.rows = "1";
    titleElm.innerHTML = $('#thread > h1').text();


    var textElm = textArea.cloneNode();
    textElm.placeholder ='Add thread body..';

    textElm.cols = "70";

    textElm.innerHTML = $('#thread > p').text();

    parDiv.innerHTML = 'Thread title:';
    parDiv.appendChild(titleElm);

    parDiv.innerHTML += '<br/>';

    parDiv.appendChild(textElm);
    var funcString  = "editThreadAjax(this,\""+ username+"\",\""+imgsrc+"\")";

    parDiv.innerHTML += "<button id='" + elem.name + "' onclick='"+funcString+"' >Edit</button>";


}

function editThreadAjax(elm, username , imgsrc) {

    alert("ok");
    var elms = document.getElementsByTagName("textarea");
    console.log(elms);
    var threadTitle = elms[0].value;
    alert(elms[0].value + "ppp");
    var newThread = elms[1].value;

    var parDiv = $('#thread')[0];
    var threadId = elm.id;
    console.log(threadTitle);
    alert("okkk");

    //ajax request

    data = "id=" + threadId + "&title= " + threadTitle + "&body=" + newThread;
    $.ajax({
        type: "POST",
        url: "/zend_project/public/thread/updatethread",
        data: data,
        success: function (msg) {
            var funcString  = "editThread(this,\""+ username+"\",\""+imgsrc+"\")";
            parDiv.innerHTML = "<br><br>Posted by: <label>" + username +"</label>"+ //username
                    "<img src='"+imgsrc+"' >" + //image
                    getCurrentDATETIME() + "<br/>" +
                    "<h1>" + threadTitle + "</h1>" +
                    "<p>" + newThread + "</p>" +
                    "<button name='" + threadId + "' onclick='"+funcString+"'>Edit</button>" +
                    "<button  name='" + threadId + "' onclick='deleteThread(this)'>Delete</button>";
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            parDiv.innerHTML = "An error occurred, please try again later.";
        }
    });

}




/*
 * This function is used when adding new comment
 */
function reply(threadId, username , image, profpic) {

    //clear textarea
    alert("here");
    var textElm = document.getElementsByClassName("replyText")[0];
    var text = textElm.value;
    textElm.value = '';

    //ajax request
    $.post("/zend_project/public/reply/savereply",
            {
                thread_id: threadId,
                body: text
            },
    function (data, status) {
        var reply = jQuery.parseJSON(data);
        $("#replies").append("<div id='" + reply['replyId'] + "' class='replyDiv' >"
        + "<img src=" + profpic + " >"  //image
                
        +"<span class='label label-default' style='font-size:30px;'> <label>" + username + "</label></span>"  //username
        + "<br><label class='date'> "+ reply['Date']+"</label>"
        + "<br><p>" + reply['body'] + "</p></div>");

       var str = "#replies> #"+reply['replyId'] ;
    if (image!=0){
        $(str)[0].innerHTML+= "<div class='sig' ><img style='width: 160px;height: 160px;' src=" + image +  " ></div>" ; //image
        }
         $(str)[0].innerHTML+= "<button class='editcomment' onclick='edit(this)'>Edit</button>"
        + "<button class='deletecomment' onclick='deleteReply(this)'>Delete</button></div>";

                
    });
}



//on edit
function edit(elem) {

    alert ("here");
    var parDiv = elem.closest('div'); // this gets the closest div parent

    var repId = parDiv.id; // this gets the parent classes.
    
    
    
    var str = "#" + repId + ">.editcomment";
    $(str)[0].style.visibility='hidden';
    
    
    var str = "#" + repId + ">.deletecomment";
    $(str)[0].style.visibility='hidden';
    

    var str = "#" + repId + ">p";
    var text =$(str).text();
    var pElm = $(str)[0];
    
    
    
    var textElm = document.getElementsByClassName("replyText")[0].cloneNode();
    pElm.innerHTML = '';
    textElm.innerHTML = text;
    pElm.appendChild(textElm);

    
    pElm.innerHTML += "<button onclick=editReply(this) >Done editing</button>";
}


function editReply(elm) {    //update reply with ajax

    var newReply = elm.previousSibling.value;
    var repId = elm.closest('div').id; // this gets the closest div parent
    
    var str = "#" + repId + ">p";
    var pElm = $(str)[0];
    
    var str = "#" + repId + ">.date";
    var dateElm = $(str)[0];
    
    //ajax request
    $.post("/zend_project/public/reply/updatereply",
            {
                id: repId,
                body: newReply
            },
    function (data, status) {
        dateElm.innerHTML = getCurrentDATETIME();
        elm.previousSibling.remove();
        elm.remove;      
        pElm.innerHTML = newReply;
        
        var str = "#" + repId + ">.editcomment";
        $(str)[0].style.visibility='visible';
    
    
        var str = "#" + repId + ">.deletecomment";
        $(str)[0].style.visibility='visible';
        
        var str = "#" + repId + ">.edited";
        
        
        if (!$(str)[0]) {
            alert ("cmdcn");
            var editedd = document.createElement('label');
            editedd.innerHTML = 'Edited';
            editedd.className = 'edited';
            dateElm.parentNode.insertBefore(editedd, dateElm);
            
         }
    });
}


function deleteReply(elm) {

    var parDiv = elm.closest('.replyDiv'); // this gets the closest div parent
    var repId = parDiv.id; // this gets the parent classes.

    //ajax request
    $.post("/zend_project/public/reply/deletereply",
            {
                id: repId,
            },
            function () {

                parDiv.remove();
            });

}


function getCurrentDATETIME() {

    var currentdate = new Date();

    var month = currentdate.getMonth() + 1;
    if (month < 10)
        month = "0" + month;

    var day = currentdate.getDate();
    if (day < 10)
        day = "0" + day;

    var min = currentdate.getMinutes();
    if (min < 10)
        min = "0" + min;

    var second = currentdate.getSeconds();
    if (second < 10)
        second = "0" + second;

    var hour = currentdate.getHours();
    if (hour < 10)
        hour = "0" + hour;


    var datetime = currentdate.getFullYear() + "-"
            + month + "-"
            + day + " "
            + hour + ":"
            + min + ":"
            + second;


    return datetime;

}


//------------------------------------------------------------------------------
function editThread(elem) {
    
    $("#editbtn")[0].style.visibility = 'hidden';

    var parDiv = $("#thread")[0];


    var thHeader = $('#thread > h1');
    var thBody= $('#thread > p');

    var textArea = document.getElementsByClassName("replyText")[0];
    var titleElm = textArea.cloneNode();
    titleElm.placeholder ='Add title..';
    titleElm.rows = "1";
    titleElm.innerHTML = thHeader.text().trim();
    
    
    thHeader[0].innerHTML = '' ;


    var textElm = textArea.cloneNode();
    textElm.placeholder ='Add thread body..';
    textElm.cols = "70";

    textElm.innerHTML = thBody.text();
    thBody[0].innerHTML = '' ;
    thBody[0].appendChild(titleElm);
    thBody[0].innerHTML+='<br>';
    thBody[0].appendChild(textElm);

    thBody[0].innerHTML += "<br><button id='" + elem.name + "' onclick='editThreadAjax(this)' >Done editing</button>";


}

function editThreadAjax(elm) {

    console.log(elm.previousSibling.previousSibling);
    var title = elm.previousSibling.previousSibling.previousSibling.previousSibling;
    var body = elm.previousSibling.previousSibling;
    
    var bodyText = body.value;
    

    var thHeader = $('#thread > h1')[0];
    var thBody = $('#thread > p')[0];

    var threadId = elm.id;
    
   
    //ajax request
    data = "id=" + threadId + "&title= " + title.value + "&body=" + bodyText;
    $.ajax({
        type: "POST",
        url: "/zend_project/public/thread/updatethread",
        data: data,
        success: function (msg) {
            alert("ok");
            thHeader.innerHTML=title.value;
            thBody.innerHTML = bodyText;
            $("#editbtn")[0].style.visibility = 'visible';

            
           
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            parDiv.innerHTML = "An error occurred, please try again later.";
        }
    });

}


function deleteThread(elm) {

    alert("here");

    var parDiv = $("#thread")[0];
    var thrId = elm.name; // this gets the parent classes.
    alert(thrId);
    //ajax request
    $.post("/zend_project/public/thread/deletethread",
            {
                id: thrId
            },
            function (data, status) {

                window.location.href = 'zend_project/public/thread/pageRemoved';
            });

    data = "id=" + thrId;
    $.ajax({
        type: "POST",
        url: "/zend_project/public/thread/updatethread",
        data: data,
        success: function (msg) {
                window.location.href = '/zend_project/public/thread/threadRemoved';

        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            parDiv.innerHTML = "An error occurred, please try again later.";
            alert(XMLHttpRequest.responseText);
        }
    });


}

