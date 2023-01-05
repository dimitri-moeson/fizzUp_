
$(document).ready(function () {
    $('#list-comment').DataTable({

        ordering : {

            0 : false,
            1 : false,

        }

    });
});

$(function(){

    setTimeout(function () {
        $('.alert').alert('close');
    },6000);
});
