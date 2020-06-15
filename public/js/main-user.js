window.onload = initUser;

function initUser() {
    const ajaxUl = document.querySelector(".ajax-ul");
    const APP_URL = "http://127.0.0.1:8000/";

    function initApi(api) {
        const user = document.querySelector(".title-user");
        const token = document.getElementById("token").value;
        const initTemplate = new template();

        this.followers = function(api) {
            (async () => {
                const data = { _token: token, id: user.id };

                const rawResponse = await fetch(APP_URL + api, {
                    method: "post",
                    headers: {
                        Accept: "application/json",
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify(data)
                });
                const content = await rawResponse.json();
                initTemplate.setFollowers(content);
            })();
        };
        this.followings = function(api) {
            (async () => {
                const data = { _token: token, id: user.id };

                const rawResponse = await fetch(APP_URL + api, {
                    method: "post",
                    headers: {
                        Accept: "application/json",
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify(data)
                });
                const content = await rawResponse.json();
                initTemplate.setFollowings(content);
            })();
        };
    }

    ajaxUl.addEventListener("click", function(e) {
        const init = new initApi();

        switch (e.target.className) {
            case "seguidores":
                init.followers("api/followers");
                break;
            case "seguindo":
                init.followings("api/followings");
                break;
            default:
        }
    });

    function template(data) {
        //limpa o template se existir
        cleanTemplate();

        this.setFollowers = function(data) {
            const output = templateString(data);
            const name = "Seguidores";

            appendTemplate(output, name);
        };
        this.setFollowings = function(data) {
            const output = templateString(data);
            const name = "Seguindo";

            appendTemplate(output, name);
        };
    }

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
        const ajaxFollows = document.querySelector(".ajax-follows");
        const boxing = document.querySelector(".ajax-follows .boxing");

        const div = document.createElement("div");
        const firstDiv = document.createElement("div");

        const appendDiv = `<div>${name}</div><span class="closer">X</span>`;

        firstDiv.innerHTML = appendDiv;
        firstDiv.classList.add("first");

        div.innerHTML = output;
        div.classList.add("ajax");

        div.insertBefore(firstDiv, div.childNodes[0]);

        ajaxFollows.classList.add("z-index-2");
        boxing.classList.add("visible");
        boxing.appendChild(div);

        const closer = document.querySelector(".closer");
        closer.addEventListener("click", cleanTemplate);
    };

    const cleanTemplate = function(data) {
        const ajaxFollows = document.querySelector(".ajax-follows");
        const boxing = document.querySelector(".ajax-follows .boxing");

        //limpa o container
        if (ajaxFollows.children.length != 0) {
            while (boxing.firstChild) {
                ajaxFollows.classList.remove("z-index-2");
                boxing.classList.remove("visible");
                boxing.removeChild(boxing.firstChild);
            }
        }
    };

    initHeader();
}

// $.ajax({
//     url: APP_URL + api,
//     type: "get",
//     data: { _token: token, id: user.id },
//     success: function(data) {
//         if (data.response != "empty") {
//             try {
//                 initTemplate.setFollowers(data);
//             } catch (err) {
//                 console.warn(err);
//             }
//         }
//     },
//     error: function(data) {
//         console.log(data);
//     }
// }); //end of ajax

// $.ajax({
//     url: APP_URL + api,
//     type: "get",
//     data: { _token: token, id: user.id },
//     success: function(data) {
//         if (data.response != "empty") {
//             try {
//                 initTemplate.setFollowings(data);
//             } catch (err) {
//                 console.warn(err);
//             }
//         }
//     },
//     error: function(data) {
//         console.log(data);
//     }
// }); //end of ajax
