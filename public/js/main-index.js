window.onload = initIndex;

function initIndex() {
    const email = document.querySelector("#email");
    const password = document.querySelector("#password");

    // function handleNumbers(event) {
    //     const labelEmail = document.querySelector(".label-email");
    //     const labelPassword = document.querySelector(".label-password");

    //     if (email.value.length === 1) {
    //         labelEmail.classList.add("input-clicked");
    //     }
    //     if (email.value.length === 0) {
    //         labelEmail.classList.remove("input-clicked");
    //     }

    //     if (password.value.length === 1) {
    //         labelPassword.classList.add("input-clicked");
    //     }

    //     if (password.value.length === 0) {
    //         labelPassword.classList.remove("input-clicked");
    //     }

    //     console.log(email.value);
    // }

    const movelabels = e => {
        const labelEmail = document.querySelector(".label-email");
        const labelPassword = document.querySelector(".label-password");

        if (email.value.length === 1) {
            labelEmail.classList.add("input-clicked");
        }
        if (email.value.length === 0) {
            labelEmail.classList.remove("input-clicked");
        }

        if (password.value.length === 1) {
            labelPassword.classList.add("input-clicked");
        }

        if (password.value.length === 0) {
            labelPassword.classList.remove("input-clicked");
        }

        console.log(email.value);
    };

    email.addEventListener("keyup", movelabels);
    password.addEventListener("keyup", movelabels);
}
