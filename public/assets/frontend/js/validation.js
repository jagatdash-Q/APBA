function checkvalidmail(usermail) {
    var validmail = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    if (usermail != '' && usermail.match(validmail)) {
        return true;
    } else {
        return false;
    }
}

function checkPassword(userpass){
    var pass = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{6,12}$/;
    if (userpass != '' && userpass.match(pass)) {
        return true;
    } else {
        return false;
    }
}