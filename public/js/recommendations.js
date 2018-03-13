
/*
    var checkedvalue = document.querySelector('#checked:checked').value;
*/
    function check() {
        var checkedValue = [];
        var boxes = document.querySelector('#checked:checked').value;
        for (var i = 0; i < boxes.length; i++) {
            var box = boxes[i];
            if (box.type == "checkbox" && box.checked) {
                checkedValue[checkedValue.length] = box.value;
            }
            console.log(checkedValue);
        }
    }



/*    $.ajax({
        method: "POST",
        url: "/recommends",
        data: {trackid: checkedvalue}
    })
    }*/

