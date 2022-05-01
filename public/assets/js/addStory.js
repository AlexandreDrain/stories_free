document.addEventListener("DOMContentLoaded", () => {

    let button = document.querySelector("#add_story");
    let myForm = document.getElementById("stories");

    button.addEventListener("click", (e) => {
        e.preventDefault();
        let selectValues = getSelectValues(document.querySelector("#stories_tags"));

        let datas = Object.fromEntries(new FormData(myForm));
        let myJson = {
            ...datas,
            tags: selectValues
        }

        fetch('http://127.0.0.1:8000/api/create/storie', {
            method: 'POST',
            body: JSON.stringify(myJson),
            headers: {
                'Content-type': 'application/json; charset=UTF-8'
            }
        }).then( response => response.json() ).then( response => {
            if (response.success == false) {
                alert(response.message);
            }
        });
    });

    // https://stackoverflow.com/questions/11821261/how-to-get-all-selected-values-from-select-multiple-multiple
    function getSelectValues(select) {
        var result = [];
        var options = select && select.options;
        var opt;
      
        for (var i=0, iLen=options.length; i<iLen; i++) {
          opt = options[i];
      
          if (opt.selected) {
            result.push(opt.value || opt.text);
          }
        }
        return result;
    }
});
