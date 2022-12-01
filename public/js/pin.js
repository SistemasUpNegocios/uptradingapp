async function retrieveData() {
    // Do not cache or hardcode the ConnectionToken. The SDK manages the ConnectionToken's lifecycle.
    return await fetch("/admin/retrieveCard", {
        method: "GET",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    })
        .then(function (response) {
            return response.json();
        })
        .then(function (data) {
            return data.secret;
        });
}

function changePin() {
    // Do not cache or hardcode the ConnectionToken. The SDK manages the ConnectionToken's lifecycle.
    return fetch("/admin/changePin", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    })
        .then(function (response) {
            return response.json();
        })
        .then(function (data) {
            return data.secret;
        });
}

const retrieveButton = document.getElementById("retrievePin");
retrieveButton.addEventListener("click", async (event) => {
    console.log(retrieveData());
});

const changeButton = document.getElementById("changePin");
changeButton.addEventListener("click", async (event) => {
    console.log(changePin());
});
