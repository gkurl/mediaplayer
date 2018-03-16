
    function check() {

// jQuery way to add items and remove on check/uncheck

        /*    $('#checkboxes').on('change', function() {
                var selectedProducts = [];
                var listProductsCtrl = $('.list-ids');
                listProductsCtrl.html(''); //reset the values here
                $('#checkboxes input[type="checkbox"]:checked').each(function() {
                    selectedProducts.push($(this).attr('value'));
                  /!*  var showtimesAsString = selectedProducts.join(', ');
                    listProductsCtrl.html(showtimesAsString);*!/
                });
                console.log(selectedProducts);
            });*/

// Pure JS way to add items and remove on check/uncheck

        var checkboxes = document.querySelectorAll('input[name=checkbox]');
        /*var reset = document.querySelectorAll('.list-ids');
        reset.innerHTML = '';*/
        var recommendBtn = document.getElementById('getrecommendations');
        var vals = [];

       /* for (i = 0; i < checkboxes.length; i++) {

            checkboxes[i].addEventListener('click', function () {

                if (this.checked) {

                    vals.push(this.value);

                } else {

                    vals.splice(vals.indexOf(this.value), 1);
                }

                if (vals.length >= 1) {

                    recommendBtn.style.display = 'block';

                } else {

                    recommendBtn.style.display = 'none';

                }
                console.log(this, vals);

            });
        }*/

        function getCheckedBoxes(checkbox) {
            var checkboxes = document.getElementsByName('checkbox');
            var checkboxesChecked = [];
            // loop over them all
            for (var i=0; i<checkboxes.length; i++) {
                // And stick the value of checked ones onto an array
                if (checkboxes[i].checked) {
                    checkboxesChecked.push(checkboxes[i].value);
                //else remove the unselected value chosen by user using this
                }else {
                    checkboxesChecked.splice(checkboxesChecked.indexOf(this.value), 0);
                }
                if(checkboxesChecked.length >= 1){
                    recommendBtn.style.display = 'block';
                } else {
                    recommendBtn.style.display = 'none';
                }
            }
            // Return the array if it is non-empty, or null
            return checkboxesChecked.length > 0 ? checkboxesChecked : null;


        }

// Call as
        var checkedBoxes = getCheckedBoxes("mycheckboxes");
        console.log(checkedBoxes);
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


/*}

    function makeRequest(access_token){
        $.ajax({
            method: "POST",
            url: "/mystats/recommends",
            data: {
                seed_artists: vals
            }

    })}*/

