$(function() {
    $("#date").datepicker({ dateFormat: 'yy-mm-dd' }).bind("change", function() {
        var minValue = $(this).val();
        minValue = $.datepicker.parseDate("yy-mm-dd", minValue);
        minValue.setDate(minValue.getDate() + 1);
        $("#date").datepicker("option", "minDate", minValue);
    })
});