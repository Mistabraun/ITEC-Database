const loginForm = document.getElementById("login-form")
const registerForm = document.getElementById("register-form")

const email = document.getElementById("email")
const password = document.getElementById("password")
const verifyPassword = document.getElementById("verify-password")
const error = document.getElementById("error")

// hard-coded user detail for testing demo purposes.
localStorage.setItem("user@mail.com", "user123")

const REGISTER_API = "api/register.php"
const LOGIN_API = "api/login.php"

const authenticate = (data) => { 
    fetch(LOGIN_API, {
        method : "POST",
        headers : {
            'Content-Type' : 'application/json'
        },
        body : data
    }).then(data => {
        console.log("successful")
    })
    

}

const register = (data) => {
    // alert("dapat na tatawag to.") 
    fetch(REGISTER_API, {
        method: "POST",
        headers: {
            'Content-Type' : 'application/json'
        },
        body : data
    }).then(data => {
        console.log("successful")
        // window.location = "/shop.html"
    })
}

const onError = (message, form) => { 
    email.focus()

    if (message) { 
        error.innerText = message
    }

    if (form) { 
        form.reset()
    }
    error.style.display = "inline"
}

if (loginForm) {

    loginForm.addEventListener("submit", (event) => {
        event.preventDefault()

        const formData = new FormData(loginForm);

        const dataObject = Object.fromEntries(formData.entries());
        const jsonString = JSON.stringify(dataObject);

        authenticate(jsonString)

    })
    
}

if (registerForm) {

    registerForm.addEventListener("submit", (event) => {
        event.preventDefault()
        
        const formData = new FormData(registerForm);
    
        const dataObject = Object.fromEntries(formData.entries());
        const jsonString = JSON.stringify(dataObject);

        let passwordValue = password.value

        if (passwordValue !== verifyPassword.value) {
            onError("The password you’ve entered does not match.")
        } else if (passwordValue.length <= 0) {
            onError("The password must be at least 8 characters long.")
        } else { 
            register(jsonString)
        }
    })

}