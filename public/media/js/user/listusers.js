function ban(elm){
 
    var ban;
    var id = elm.parentNode.parentNode.id;
    if (elm.innerHTML=='Ban user') 
        ban = 1;
    else
        ban = 0;

    //ajax request
    $.post("/zend_project/public/user/ban",
            {
                id: id,
                status: ban
            },
    function (data, status) {

        if (ban==1){
            elm.innerHTML='Unban user';
            elm.className="btn btn-lg btn-success";
        }else{
            elm.innerHTML='Ban user';
            elm.className="btn btn-lg btn-danger";
        }
    });
    
}




function makeAdmin(elm){
 
    var admin;
    var id = elm.parentNode.parentNode.id;
    if (elm.innerHTML=='Make admin') 
        admin = 1;
    else
        admin = 0;

    //ajax request
    $.post("/zend_project/public/user/makeadmin",
            {
                id: id,
                status: admin
            },
    function (data, status) {

    if (admin==1) 
        elm.innerHTML='Make normal user';
    else
        elm.innerHTML='Make admin';

    });
    
}



function deleteUser(elm){
 
    var parentRow = elm.parentNode.parentNode;
    var id = parentRow.id;

   
    //ajax request
    $.post("/zend_project/public/user/deleteuser",
            {
                id: id
            },
    function (data, status) {
        parentRow.remove();
    });
    
    
}

function Edit(elm){
    
    var loc = window.location.href;
    var n = loc.lastIndexOf('/');
    loc = loc.substring(0 ,n);
    var id = elm.parentNode.parentNode.id;
    window.location.href = loc+ "/edit/id/"+id;
    
 };
