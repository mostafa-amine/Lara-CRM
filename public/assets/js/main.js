

// Select csrf token
var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");


$('document').ready(function() {
    $('#checkAll').change(function() {
        if ($(this).is(':checked')){
            var counter = 0
            $('.table_check').each(function() {
                $(this).prop('checked', true)
                counter++
            });
            // display selected rows count
            $('.check_count').text(counter + ' selected')
        }
        else {
            $('.table_check').each(function() {
                $(this).prop('checked', false)
            });

            // display selected rows count
            $('.check_count').text(0 + ' selected')

            setTimeout(function(){
                $('.check_count').text('')
            }, 3000)
        }
    })

    // Toggle Bulk Actions
    $('#bulk_actions').click(function() {
        $("#export, #import").toggleClass('d-none');
    })

    $("#export").click(function() {
        $('.table_check').each(function() {
            if (! ($(this).is(':checked'))){
                var id = $(this).attr('id')
                $(`#${id}`).addClass('noExl')
            }
            else {
                var id = $(this).attr('id')
                $(`#${id}`).removeClass('noExl')
            }
        })

        $(".table2excel").table2excel({
            exclude: ".noExl",
            name: "Worksheet Name",
            filename: "Users" + Date() + 'xlsx',
            fileext: ".xlsx"
          });

    })

    // Handle Import
    $("#import").click(function() {
        $(".importForm").toggleClass('d-none');
    });

    $("#submit").click(function(){
        var file =$("#file")[0].files;

        if (file.length > 0)
        {
            // Create Form Data
            var fd = new FormData();
            fd.append('file', file[0])
            fd.append('_token', CSRF_TOKEN)

            // $(".main_table").text('Loading New Users From Database')

            // Send Ajax Request
            $.ajax({
                url: "/users/import",
                method: 'post',
                data: fd,
                contentType: false,
                dataType: 'json',
                processData: false,
                success: function(response){
                    // Reload the page to update content
                    location.href = location.href;
                }
            })
            // update the table
        }
    })
})

