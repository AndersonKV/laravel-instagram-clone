window.onscroll = scroll;
window.onload = scroll;

function scroll() {
    // console.log(
    //     "evento scroll detectado! " +
    //         window.pageXOffset +
    //         " " +
    //         window.pageYOffset
    // );
    //console.log(window.pageYOffset);

    const divRight = document.querySelector(".section__home--right");

    // if (window.pageYOffset === 100) {
    //     divRight.classList.add("fixed-middle");
    // } else if (window.pageYOffset <= 70) {
    //     try {
    //         if (divRight.classList.contains("fixed-middle") !== false) {
    //             divRight.classList.remove("fixed-middle");
    //         }
    //     } catch (err) {
    //         console.warn("temporariamente não carregado");
    //     }

    //     //divRight.classList.contains("fixed-middle");
    //     console.log("top");
    // }
    initHeader();
}

window.onbeforeunload = function() {
    window.scrollTo(0, 0);
};

window.onload = initHome;

function initHome() {
    const img = document.querySelectorAll(".like-img");
    const getLikes = document.querySelectorAll(".get-likes");
    const APP_URL = "http://127.0.0.1:8000/";
    const apiLike = "api/like";
    const apiLikes = "api/likes";

    const submitLike = function(data) {
        (async () => {
            const token = document.getElementById("token").value;
            const myRequest = APP_URL + apiLike;

            const data = { _token: token, id_post: this.parentElement.id };
            const id = { id_post: this.parentElement.id };
            console.log(id);
            fetch(myRequest, {
                method: "post",
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(data)
            })
                .then(response => response.json())
                .then(data => {
                    try {
                        if (data.like == "200") {
                            updatePeopleLiked(data, id);
                            handleSubmitLike("like", id);
                        }
                        if (data.deslike == "200") {
                            updatePeopleLiked(data, id);
                            handleSubmitLike("not-like", id);
                        }
                    } catch (err) {
                        console.log(err);
                    }
                });
        })();
    };

    img.forEach(element => {
        element.addEventListener("dblclick", submitLike);
    });

    const changeIconLike = function(setClass) {
        const span = document.createElement("span");

        if (setClass == "like") {
            const output = `<i class="fa fa-heart" aria-hidden="true"></i>`;
            span.classList.add(setClass);
            span.innerHTML = output;
        } else {
            const output = `<i class="far fa-heart" aria-hidden="true"></i>`;
            span.classList.add(setClass);
            span.innerHTML = output;
        }

        return span;
    };

    const handleSubmitLike = function(setClass, id) {
        const post = document.getElementById(id.id_post);
        const icons = post.querySelector(".list-icon .first");
        const likeImg = post.querySelector(".like-img");

        if (setClass == "like") {
            const heart = `<span class="like heart-white"><i class="fa fa-heart" aria-hidden="true"></i></span>`;
            const div = document.createElement("div");

            div.innerHTML = heart;
            likeImg.insertBefore(div, likeImg.firstChild);

            icons.removeChild(icons.firstChild);
            const content = changeIconLike(setClass);
            icons.insertBefore(content, icons.firstChild);
        } else {
            icons.removeChild(icons.firstChild);
            const content = changeIconLike(setClass);
            icons.insertBefore(content, icons.firstChild);
        }
    };

    const updatePeopleLiked = function(data, id) {
        const post = document.getElementById(id.id_post);
        const likes = post.querySelector(".count-likes");
        const len = data.users.length;
        console.log(id);
        if (len == 0) {
            while (likes.firstChild) {
                likes.removeChild(likes.firstChild);
            }
        } else if (len == 1) {
            const showList = `<span>Curtido por <b><a href="/${data.users[0].user}">${data.users[0].user}</a></b> e outras 
                                <b id=${id.id_post} class="get-likes">${len} pessoas</b></span>
                                <div class="container-ajax-${id.id_post} z-index-1 container-ajax-likes">
                                <div class="boxing visibility"></div></div>`;

            const div = document.createElement("div");
            div.innerHTML = showList;
            const get = div.querySelector(".get-likes");
            get.addEventListener("click", getUsers);

            likes.appendChild(div);
        } else if (len >= 2) {
            while (likes.firstChild) {
                likes.removeChild(likes.firstChild);
            }

            const showList = `<span>Curtido por <b><a href="/${data.users[0].user}">${data.users[0].user}</a></b> e outras 
                                    <b class="get-likes">${len} pessoas</b></span>
                                    <div class="container-ajax-likes z-index-1">
                                    <div class="boxing visibility"></div></div>`;

            const div = document.createElement("div");
            div.innerHTML = showList;

            likes.appendChild(div);
        }
    };

    const appendTemplateUsers = function(output, name, id) {
        const containerAjax = document.querySelector(
            `.container-ajax-${id.id_post}`
        );

        const boxing = containerAjax.querySelector(".boxing");

        const div = document.createElement("div");
        const firstDiv = document.createElement("div");

        const appendDiv = `<div>${name}</div><span id=${id.id_post} class="closer2">X</span>`;

        firstDiv.innerHTML = appendDiv;
        firstDiv.classList.add("first");

        div.innerHTML = output;
        div.classList.add("ajax");

        div.insertBefore(firstDiv, div.childNodes[0]);

        containerAjax.classList.add("z-index-2");
        boxing.classList.add("visible");
        boxing.appendChild(div);

        const closer = document.querySelector(".closer2");
        closer.addEventListener("click", cleanTemplate);
    };

    const cleanTemplate = function(e) {
        const ajax = document.querySelector(`.container-ajax-${this.id}`);
        const boxing = ajax.querySelector(".boxing");

        // console.log(ajax);

        if (ajax.children.length != 0) {
            while (boxing.firstChild) {
                ajax.classList.remove("z-index-2");
                boxing.classList.remove("visible");
                boxing.removeChild(boxing.firstChild);
            }
        }
    };

    const templateUsers = function(data) {
        const string = data
            .map(perfil => {
                return `
            <div>
             <a href="/${perfil.user}">
            <div>
                <img class="avatar" src="${APP_URL}storage/upload/${perfil.image}"/>
            </div>
            <span>${perfil.user}</span>
            </a>
            </div>`;
            })
            .join("");
        return string;
    };

    const tableListLike = function(data, id) {
        const output = templateUsers(data);
        const name = "Curtidas";

        appendTemplateUsers(output, name, id);
    };

    const getUsers = function(e) {
        const token = document.getElementById("token").value;
        const data = { _token: token, id_post: this.id };
        const id = { id_post: this.id };

        $.ajax({
            url: APP_URL + apiLikes,
            type: "post",
            data: data,
            success: function(data) {
                tableListLike(data, id);
            },
            error: function(data) {
                console.log(data);
            }
        });
    };

    getLikes.forEach(element => {
        element.addEventListener("click", getUsers);
    });
    initHeader();
}
