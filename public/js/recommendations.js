var checkboxes;
var checkboxesChecked;

function check () {


    function getCheckedBoxes() {

        checkboxes = document.getElementsByName('checkbox');
        checkboxesChecked = [];
        var recommendBtn = document.getElementById('getrecommendations');

        // loop over them all
        for (var i = 0; i < checkboxes.length; i++) {
            // And stick the value of checked ones onto an array
            if (checkboxes[i].checked) {
                checkboxesChecked.push(checkboxes[i].value);
                //else remove the unselected value chosen by user using this
            } else {
                checkboxesChecked.splice(checkboxesChecked.indexOf(this.value), 0);
            }
            if (checkboxesChecked.length >= 1) {
                recommendBtn.style.display = 'block';
            } else {
                recommendBtn.style.display = 'none';
            }
            if (checkboxesChecked.length > 4) {
                stopCheck();
            }
        }
        // Return the array if it is non-empty, or null

        return checkboxesChecked.length > 0 ? checkboxesChecked : null;


        function stopCheck() {

            $('.checkbox-class').change(function () {
                if ($('input.checkbox-class').filter(':checked').length == 5)
                    $('input.checkbox-class:not(:checked)').attr('disabled', 'disabled');
                else
                    $('input.checkbox-class').removeAttr('disabled');
            });


        }
    }

    var checkedBoxes = getCheckedBoxes();
    console.log(checkedBoxes);
}


        function makeRequest(access_token) {

            var str = checkboxesChecked.join();

                $.ajax({
                    type: "GET",
                    url: "https://api.spotify.com/v1/recommendations",
                    headers: {
                        'Authorization': 'Bearer ' + access_token
                    },
                    data: {
                        seed_tracks: str,
                        limit: 10
                    },
                    success: function(data) {
                       console.log(data);
                       $.each(json.items, function (index, tracks) {
                           console.log(tracks);
                           tr = $('<tr/>');
                           tr.append("<td>" + tracks.name + "</td>")
                       })
                    }
                });


    }
























           /* } if(vals.length >= 1){

                recommendBtn.style.display = 'block';

            } if(vals.length == 0){
                alert ('it\s empty bitch');
            }
        console.log(vals);*/




           /* if (checkboxes[i].checked) {
                vals.push(checkboxes[i].value);
            }
            if (vals.length > 5) {
                checkboxes[i].checked = false;
                vals.pop();
            } if (checkboxes.disabled = true){
                recommendBtn.style.display = 'block';
            }


            console.log(vals, checkboxes);
        }*/


      /*  for (u=0; u < unchecked.length; u++) {
            if(vals.length == 5){
                unchecked[u].style.color = "blue";
            }

            }
        console.log(vals, unchecked);*/






