function initHeader() {
    const search = document.querySelector('input[name="pesquisar"]');
    search.disabled = false;
    const APP_URL = "http://127.0.0.1:8000/";

    search.addEventListener("keyup", e => {
        e.preventDefault();

        const token = document.getElementById("token").value;
        const myLength = search.value.trim();

        cleanTemplate();

        if (myLength.length >= 3) {
            if (e.keyCode != 17) {
                console.log(1);

                setTimeout(function() {
                    $.ajax({
                        url: APP_URL + "api/search",
                        type: "get",
                        data: { _token: token, word: search.value },
                        success: function(data) {
                            console.log("1");
                            if (data.response != "hashtag_empty") {
                                if (data.hashtag) {
                                    try {
                                        templateHashtag(data);
                                    } catch (err) {
                                        console.warn(err);
                                    }
                                }
                            } else if (data.response == "hashtag_empty") {
                                templateNull();
                            }

                            if (data.response != "empty") {
                                if (data[0]) {
                                    //console.log(data);
                                    try {
                                        template(data);
                                    } catch (err) {
                                        console.warn(err);
                                    }
                                }
                            } else if (data.response == "empty") {
                                templateNull();
                            }
                        },
                        error: function(data) {
                            console.log(data);
                        }
                    }); //end   ajax
                }, 1000);
            }
        }
    });

    function template(data) {
        cleanTemplate();
        const output = templateString(data);

        appendTemplate(output);
    }

    function templateHashtag(data) {
        cleanTemplate();
        const texto = data.hashtag.substring(1);

        const string = `<div class="search-hashtag">
                            <a href="/explore/tags/${texto}">
                                <span>${data.hashtag}</span>
                                <span>${data.len} publicações</span>
                            </a>
                        </div>`;

        const containerAjax = document.querySelector(".container-ajax");

        const boxing = document.querySelector(".container-ajax .boxing");

        const div = document.createElement("div");

        div.innerHTML = string;
        div.classList.add("ajax");

        containerAjax.classList.add("z-index-2");
        boxing.classList.add("visible");
        boxing.appendChild(div);
    }

    function templateNull() {
        cleanTemplate();

        const containerAjax = document.querySelector(".container-ajax");

        const boxing = document.querySelector(".container-ajax .boxing");

        const div = document.createElement("div");
        const output = `<span class="center">Nenhum resultado encontrado.</span>`;

        div.innerHTML = output;
        div.classList.add("ajax");

        containerAjax.classList.add("z-index-2");
        boxing.classList.add("visible");
        boxing.appendChild(div);
        //console.log(div);
    }

    document.addEventListener("click", e => {
        //$(document).on("click", function(e) {
        const dentro = e.target.closest(".container-ajax .boxing");
        const containerAjax = document.querySelector(".container-ajax");
        const boxing = document.querySelector(".container-ajax .boxing");

        if (dentro === null) {
            while (boxing.firstChild) {
                containerAjax.classList.remove("z-index-2");
                boxing.classList.remove("visible");
                boxing.removeChild(boxing.firstChild);
            }
        }
    });

    const templateString = function(data) {
        const string = data
            .map(perfil => {
                return `
            <div>
             <a href="/${perfil.user}">
            <div>
                <img class="avatar" src="${APP_URL}storage/upload/${perfil.img}"/>
            </div>
            <span>${perfil.user}</span>
            </a>
            </div>`;
            })
            .join("");
        return string;
    };

    const appendTemplate = function(output, name) {
        const containerAjax = document.querySelector(".container-ajax");

        const boxing = document.querySelector(".container-ajax .boxing");

        const div = document.createElement("div");

        div.innerHTML = output;
        div.classList.add("ajax");

        containerAjax.classList.add("z-index-2");
        boxing.classList.add("visible");
        boxing.appendChild(div);
    };

    const cleanTemplate = function(data) {
        const containerAjax = document.querySelector(".container-ajax");
        const boxing = document.querySelector(".container-ajax .boxing");

        if (containerAjax.children.length != 0) {
            while (boxing.firstChild) {
                containerAjax.classList.remove("z-index-2");
                boxing.classList.remove("visible");
                boxing.removeChild(boxing.firstChild);
            }
        }
    };
}
