const email = document.querySelector("#email");
const name = document.querySelector("#name-complete");
const user = document.querySelector("#name-user");
const password = document.querySelector("#password");

const selector = (param) => document.querySelector(param);

console.log(selector('label[for="name-user"]'));
//const remove = classList.remove("input-clicked");
console.log(name);

const movelabels = (e) => {
    if (email.value.length == 1) {
        selector('label[for="email"]').classList.add("input-focus");
    }
    if (email.value.length == 0) {
        selector('label[for="email"]').classList.remove("input-focus");
    }

    if (name.value.length == 1) {
        selector('label[for="fn"]').classList.add("input-focus");
    }
    if (name.value.length == 0) {
        selector('label[for="fn"]').classList.remove("input-focus");
    }
    if (user.value.length == 1) {
        selector("#luser").classList.add("input-focus");
    }
    if (user.value.length == 0) {
        selector("#luser").classList.remove("input-focus");
    }

    if (password.value.length == 1) {
        selector('label[for="password"]').classList.add("input-focus");
    }

    if (password.value.length == 0) {
        selector('label[for="password"]').classList.remove("input-focus");
    }
};

email.addEventListener("keyup", movelabels);
name.addEventListener("keyup", movelabels);
user.addEventListener("keyup", movelabels);
password.addEventListener("keyup", movelabels);
