

/*
 * This function is used when adding new comment
 */
function reply(threadId, username , image, profpic) {

    //clear textarea

    var textElm = document.getElementsByClassName("replyText")[0];
    var text = textElm.value;
    textElm.value = '';
    if ((text.trim())==''){
        return;
    }
    
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
                
        +"<span style='font-size:30px;'> <label>" + username + "</label></span>"  //username
        + "<br><label class='date'> "+ reply['Date']+"</label>"
        + "<br><p>" + reply['body'] + "</p></div>");

       var str = "#replies> #"+reply['replyId'] ;
    if (image!=0){
        $(str)[0].innerHTML+= "<div class='sig' ><img style='width: 160px;height: 160px;' src=" + image +  " ></div>" ; //image
        }
         $(str)[0].innerHTML+= "<button  class='btn btn-lg btn-success editcomment'  onclick='edit(this)' style='margin-left:85% !important'>Edit</button>"
        + "<button class='btn btn-lg btn-danger deletecomment'  onclick='deleteReply(this)'>Delete</button></div>";

                
    });
}



//on edit
function edit(elem) {

    
    var parDiv = elem.closest('div'); // this gets the closest div parent

    var repId = parDiv.id; // this gets the parent classes.
    
    
    
    var str = "#" + repId + ">.editcomment";
    $(str)[0].style.visibility='hidden';
    
    
    var str = "#" + repId + ">.deletecomment";
    $(str)[0].style.visibility='hidden';
    

    var str = "#" + repId + ">p";
    var text =$(str).text();
    var pElm = $(str)[0];
    
    
    
    var textElm = document.createElement('textarea');
    textElm.placeholder = 'add reply .. ';
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

    var titleElm = document.createElement('textarea');
    titleElm.placeholder ='Add title..';
    titleElm.rows = "1";
    titleElm.innerHTML = thHeader.text().trim();
    
    
    thHeader[0].innerHTML = '' ;


    var textElm = document.createElement('textarea');
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
    var date = $('#thread > .date')[0];

    var threadId = elm.id;
    
   
    //ajax request
    data = "id=" + threadId + "&title= " + title.value + "&body=" + bodyText;
    $.ajax({
        type: "POST",
        url: "/zend_project/public/thread/updatethread",
        data: data,
        success: function (msg) {
            thHeader.innerHTML=title.value;
            thBody.innerHTML = bodyText;
            $("#editbtn")[0].style.visibility = 'visible';
            date.innerHTML = getCurrentDATETIME();
            
           
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            parDiv.innerHTML = "An error occurred, please try again later.";
        }
    });

}

