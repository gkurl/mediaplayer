
    var checkboxes;
    var vals;

    function check() {
        var checkboxes = document.querySelectorAll('.checkbox-class:checked');
        var vals = [];
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                vals.push(checkboxes[i].value);
            } if(vals.length > 5){
                checkboxes[i].checked = false;
                vals.pop();
                if(checkboxes[i].checked === false){
                    checkboxes[i].disabled = true;
                }

            }
            console.log(vals);

        }
}


    function makeRequest(access_token){
        $.ajax({
            method: "POST",
            url: "/mystats/recommends",
            data: {
                seed_artists: vals
            }

    })}

