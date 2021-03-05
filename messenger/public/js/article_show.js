$(document).ready(function () {
    $('.js-user').on('click', function (e) {
        // dont follow the link
        e.preventDefault();
        $tr = $(this).parent().parent();


        var $link = $(e.currentTarget);
        $.ajax({
            method: 'POST',
            url: $link.attr('href')
        }).done(function (data) {
            $tr.find('.js-count').html(data.compter);
            }
        )
    });

    $('.js-user-delete').on('click', function (e) {
        // dont follow the link
        e.preventDefault();
        $tr = $(this).parent().parent();


        var $link = $(e.currentTarget);
        $.ajax({
            method: 'POST',
            url: $link.attr('href')
        }).done(function (data) {
                $tr.remove();
            }
        )
    })

    $('.js-user-update').on('click', function (e) {
        // dont follow the link
        e.preventDefault();
        $tr = $(this).parent().parent();


        var $link = $(e.currentTarget);
        $.ajax({
            method: 'POST',
            url: $link.attr('href')
        }).done(function (data) {
                $tr.find('.updatedClass').html(data.status);
                console.log(data.status);
                if(data.status === "USER UPDATED"){
                    $tr.find('.updatedClass').removeClass('badge-primary')
                    $tr.find('.updatedClass').addClass('badge-success')
                }else{
                    $tr.find('.updatedClass').addClass('badge-primary')
                    $tr.find('.updatedClass').removeClass('badge-success')

                }

            }
        )
    })
})