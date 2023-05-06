function register() {
    username = document.getElementById("username").value;
    email = document.getElementById("email").value;
    password1 = document.getElementById("password1").value;
    password2 = document.getElementById("password2").value;

    if (ValidateEmail(email)) {
        if (password1 == password2) {
            document.getElementById("registerForm").submit();
        } else {
            alert("Die Passwörter stimmen nicht überein.")
        }
    } else {
        alert("Bitte gib eine gültige Email ein.")
    }
}

function login() {
    document.getElementById("loginForm").submit();
}

function updateSender() {
    document.getElementById("updateForm").submit();
}

function logout() {
    document.cookie.split(";").forEach(function(c) { document.cookie = c.replace(/^ +/, "").replace(/=.*/, "=;expires=" + new Date().toUTCString() + ";path=/"); });
    window.location.href = '../index.php';
}

function ValidateEmail(mail) 
{
 if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/.test(mail))
  {
    return (true);
  }

  return (false);
}

function removeAlert(element) {
    document.getElementById(element).remove();

    $.ajax({
        method: "POST",
        url: "include/removeAlert.php",
        data: {userid: getCookie("userid"), curid: element}
    })

    location.reload();
}

function updateAlert(element) {

    $.ajax({
        method: "POST",
        url: "include/updateAlert.php",
        data: {userid: getCookie("userid"), curid: element}
    })

    location.reload();
}

