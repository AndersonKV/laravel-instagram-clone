// const btnLogin = document.querySelector(".btn-login");
// const form = document.querySelector("form");

// btnLogin.addEventListener("click", event => {
//     event.preventDefault();

//     const fields = [...document.querySelectorAll(".input-block input")];

//     fields.forEach(field => {
//         if (field.value === "") form.classList.add("validate-error");
//     });

//     const formError = document.querySelector(".validate-error");
//     if (formError) {
//         formError.addEventListener("animationend", event => {
//             if (event.animationName === "nono") {
//                 formError.classList.remove("validate-error");
//             }
//         });
//     } else {
//         form.classList.add("form-hide");
//     }
// });

// form.addEventListener("animationstart", event => {
//     if (event.animationName === "down") {
//         document.querySelector("body").style.overflow = "hidden";
//     }
// });

// form.addEventListener("animationend", event => {
//     if (event.animationName === "down") {
//         form.style.display = "none";
//         document.querySelector("body").style.overflow = "none";
//     }
// });

window.onload = initPost;

function initPost() {
    console.log("initHeader()");

    document.querySelector("html").classList.add("js");

    var fileInput = document.querySelector(".input-file"),
        button = document.querySelector(".input-file-trigger"),
        the_return = document.querySelector(".file-return");

    button.addEventListener("keydown", function(event) {
        if (event.keyCode == 13 || event.keyCode == 32) {
            fileInput.focus();
        }
    });

    button.addEventListener("click", function(event) {
        fileInput.focus();
        return false;
    });

    fileInput.addEventListener("change", function(event) {
        const token = document.querySelector('input[name="_token"]');
        console.log(this.value);
        //document.querySelector('.my-container--row--col-sm-left').append(div)
        the_return.append(this.value);
        //document.getElementById("upload").submit();
    });

    //=============================================
    // var form = document.querySelector("#upload");
    // var request = new XMLHttpRequest();
    // form.addEventListener("submit", function(e) {
    //     e.preventDefault();
    //     var formdata = new FormData(form);
    //     request.open("open", "/post/submit");
    //     request.addEventListener("load", transferComplete);
    //     request.send(formdata);
    // });
    // function transferComplete(data) {
    //     //console.log(data.currentTarget.response);
    // }
    //initHeader();
}
