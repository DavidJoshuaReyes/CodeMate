    
function checkLoginStatus(){
    var loggedin = document.getElementById('logInStatus').textContent;
    var notice = document.getElementById('status');
    if( loggedin === "no" ){
        notice.innerHTML = "Invalid username & password";
        notice.className = "";
    } else {
        notice.setAttribute("class", "hidden");
    }
}    

function testthis(){
    console.log('test');
}