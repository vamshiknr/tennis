/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {
    $(document).on('change', '#selectState', function () {
        $.ajax({
            url: adminURL + '/academy.php',
            type: 'POST',
            data: 'selectedState=' + this.value + '&selectCity=city&token=' + Math.round(Math.random() * 1000000),
            datatype: 'html',
            success: function (result) {
                $('#selectCity').html(result);
            },
            error: function () {
                alert('Error');
                return false;
            }
        });
    });

    /*
     * Event to generate multiple image uploading options
     *
     * Minimum 0 images
     * Maximum No of courts selected
     */
    $(document).on('change', '#clay_courts', function () {
        var NoOfCourts = parseInt(this.value);
        if (NoOfCourts != 0) {
            $('.court_count').removeClass('hide').addClass('show');
            $('#court_count').html('');
            var op = '<input type="hidden" name="editClayCourts" value=""/>';
            for ($j = 0; $j < NoOfCourts; $j++) {
                op += '<div><input type="file" name="uploadCourt[]"/></div>';
            }
            $('#court_count').html(op);
        } else {
            $('#court_count').html('');
        }
    });

    /*
     * Event to toggle the Academy photo in edit
     *
     */
    $(document).on('click', '.change', function () {
        $('.academy_photo').removeClass('hide').addClass('show');
    });
});
