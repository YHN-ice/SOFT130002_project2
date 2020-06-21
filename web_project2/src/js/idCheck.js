function idCheck(id) {
    let button = document.getElementById('submit-button');
    let info = document.getElementById('tips');

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            let result = this.responseText;
            if (!result){
                button.disabled = false;
                info.innerHTML = "用户名未被使用过√"
            }
            else{
                button.disabled = true;
                info.innerHTML = '用户名已被使用x';
            }
        }
    };
    xmlhttp.open("GET", "registerResponse.php?id=" + id, true);
    xmlhttp.send();
}

function passwordCheck() {
    let password1st = document.getElementsByName('password')[0].value;
    let password2nd = document.getElementsByName('password-again')[0].value;
    if(password1st!=password2nd){
        document.getElementById('submit-button').disabled = true;
        document.getElementById('password-tips').innerHTML = "两次密码不相同x";
    }
    else{
        document.getElementById('submit-button').disabled = false;
        document.getElementById('password-tips').innerHTML = "两次密码相同√";
    }
}
