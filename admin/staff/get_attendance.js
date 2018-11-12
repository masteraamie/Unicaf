

$(document).ready(function()
{
    $(document).on('click' , '#getdet' , function(){

        var id = $('#member_name').val();
        var day = $("#day").val();
        var month = $("#month").val();
        var year = $("#year").val();
        var type = $("#monthly").prop("checked") == true ? "monthly" : "daily";

        $("#content").html("");

        $.post("get_attendance.php",
            {
                id : id,
                day : day,
                month : month,
                year : year,
                type : type
            },
            function(data , status)
            {
                if(data) {

                    var ul = data;
                    $("#attend").html(ul);

                    $(".show_attendance").slideDown();
                }
                else
                    alert("No Attendance Recorded ! !");
            }
        );

    });


        $(":radio").on('click',function(){
            if($(":radio#daily").is(':checked'))
            {
                $(".daily").slideDown();
            }

            else
            {
                $(".daily").slideUp();
            }

        });

        $(":input#getdet").click(function(){

            $("#get_mem").html($("select#member_name").find(":selected").text());
        });

        $(".close-btn").click(function(){
            $(".show_attendance").slideUp();
        });

});