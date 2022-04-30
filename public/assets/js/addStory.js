document.addEventListener("DOMContentLoaded", () => {

    let button = document.querySelector("#add_story");
    let myForm = document.getElementById("stories");

    button.addEventListener("click", (e) => {
        e.preventDefault();

        fetch('http://127.0.0.1:8000/api/create/storie', {
            method: 'POST',
            body: JSON.stringify(Object.fromEntries(new FormData(myForm))),
            headers: {
                'Content-type': 'application/json; charset=UTF-8'
            }
        })
    });
});
