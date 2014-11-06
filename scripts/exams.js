/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function() {
    $(document).on('click', '.addmore', function() {
        var $length = $('.exam_categories').length;
        var clonedObject = $(this).parent().parent().parent().clone().removeClass('newlyAdded' + $length).addClass('newlyAdded' + ($length + 1));
        $('.addmore', clonedObject).addClass('removeMore').removeClass('addmore');
        //$('.removeMore i', clonedObject).removeClass('fa-plus').addClass('fa-minus');
        $('.removeMore', clonedObject).text('').removeClass('btn-primary').addClass('btn-danger').append('<i class="fa fa-minus"></i>');
        clonedObject.appendTo('.categoriesContainer');
    });
    $(document).on('click', '.removeMore', function() {
        $(this).parent().parent().parent().remove();
    });
});
