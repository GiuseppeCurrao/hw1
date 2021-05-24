function fetchResponse(response) {
    if (!response.ok) return null;
    return response.json();
}

function checkName(event) {
    const input = event.currentTarget;
    
    if (formStatus[input.name] = input.value.length > 0) {
        input.parentNode.parentNode.classList.remove('errorj');
        document.querySelector(".name span").classList.add("hide");
        
    } else {
        input.parentNode.parentNode.classList.add('errorj');
        document.querySelector(".name span").classList.remove("hide");
    }
    checkForm();
}

function checkSurname(event) {
    const input = event.currentTarget;
    
    if (formStatus[input.name] = input.value.length > 0) {
        input.parentNode.parentNode.classList.remove('errorj');
        document.querySelector(".surname span").classList.add("hide");
        
    } else {
        input.parentNode.parentNode.classList.add('errorj');
        document.querySelector(".surname span").classList.remove("hide");
    }
    checkForm();
}

function jsonCheckCf(json) {
    if (formStatus.username = !json.exists) {
        document.querySelector('.cf').classList.remove('errorj');
        document.querySelector(".cf span").classList.add("hide");
    } else {
        document.querySelector('.cf span').textContent = "Questo codice fiscale è già registrato";
        document.querySelector(".cf span").classList.remove("hide");
        document.querySelector('.cf').classList.add('errorj');
    }
    checkForm();
}

function jsonCheckEmail(json) {
    if (formStatus.email = !json.exists) {
        document.querySelector('.email').classList.remove('errorj');
        document.querySelector('.email span').classList.add('hide');
    } else {
        document.querySelector('.email span').textContent = "Email già utilizzata";
        document.querySelector('.email').classList.add('errorj');
        document.querySelector('.email span').classList.remove('hide');
    }
    checkForm();
}

function checkCf(event) {
    const input = document.querySelector('.cf input');

    if(!/^[a-zA-Z0-9_]{1,16}$/.test(input.value)) {
        input.parentNode.parentNode.querySelector('span').textContent = "Inserire il codice fiscale in modo corretto";
        input.parentNode.parentNode.classList.add('errorj');
        document.querySelector(".cf span").classList.remove("hide");
        formStatus.username = false;
        checkForm();
    } else {
        fetch("check_cf.php?q="+encodeURIComponent(input.value)).then(fetchResponse).then(jsonCheckCf);
    }
}

function checkEmail(event) {
    const emailInput = document.querySelector('.email input');
    if(!/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(String(emailInput.value).toLowerCase())) {
        document.querySelector('.email span').textContent = "Email non valida";
        document.querySelector('.email').classList.add('errorj');
        document.querySelector('.email span').classList.remove('hide');
        formStatus.email = false;
        checkForm();
    } else {
        fetch("check_email.php?q="+encodeURIComponent(String(emailInput.value).toLowerCase())).then(fetchResponse).then(jsonCheckEmail);
    }
}

function checkPassword(event) {
    const passwordInput = document.querySelector('.password input');
    if (formStatus.password = passwordInput.value.length >= 8) {
        document.querySelector('.password').classList.remove('errorj');
        document.querySelector(".password span").classList.add("hide");
    } else {
        document.querySelector('.password').classList.add('errorj');
        document.querySelector(".password span").classList.remove("hide");
    }
    checkConfirmPassword();
    checkForm();
}

function checkConfirmPassword(event) {
    const confirmPasswordInput = document.querySelector('.confirm_password input');
    if (formStatus.confirmPassord = confirmPasswordInput.value === document.querySelector('.password input').value) {
        document.querySelector('.confirm_password').classList.remove('errorj');
        document.querySelector(".confirm_password span").classList.add("hide");
    } else {
        document.querySelector('.confirm_password').classList.add('errorj');
        document.querySelector(".confirm_password span").classList.remove("hide");

    }
    checkForm();
}

function checkForm() {
    document.getElementById('submit').disabled = !document.querySelector('.allow input').checked || 
    Object.keys(formStatus).length !== 7 || 
    Object.values(formStatus).includes(false);
}

const formStatus = {'upload': true};
document.querySelector('.name input').addEventListener('blur', checkName);
document.querySelector('.surname input').addEventListener('blur', checkSurname);
document.querySelector('.cf input').addEventListener('blur', checkCf);
document.querySelector('.email input').addEventListener('blur', checkEmail);
document.querySelector('.password input').addEventListener('blur', checkPassword);
document.querySelector('.confirm_password input').addEventListener('blur', checkConfirmPassword);
document.querySelector('.allow input').addEventListener('change', checkForm);

if (document.querySelector('.error') !== null) {
    checkUsername(); checkPassword(); checkConfirmPassword(); checkEmail();
    document.querySelector('.name input').dispatchEvent(new Event('blur'));
    document.querySelector('.surname input').dispatchEvent(new Event('blur'));
}