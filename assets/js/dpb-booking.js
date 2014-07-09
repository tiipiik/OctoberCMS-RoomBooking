!function( $ ) {
    
    $('#showAvailableDates').datepicker({
        inline: true,
        beforeShowDay: function (date) {
            var theday = date.getDate();
            /* index of months are based on 0, so we need to add 1 to the month for matching correctly */
            var themonth = date.getMonth() + 1;
            var theyear = date.getFullYear();
            
            // ensure date is corresponding, for days, months and years
            if (bookedDates[theyear] && bookedDates[theyear][themonth])
                if ($.inArray(theday, bookedDates[theyear][themonth]) != -1) {
                    return {enabled:false, classes:'bg-warning'};
                }
        },
        /*
         * Need to detect locale before and load bootstrap-datepicker.locale.js 
        language:'fr'
         */
    });

    var nowTemp = new Date();
    var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
    var tomorrow = new Date(new Date().getTime() + 24 * 60 * 60 * 1000);
    
    var selector = function (dateStr) {
            var d1 = $('#userBookingArrival').datepicker('getDate');
            var d2 = $('#userBookingDeparture').datepicker('getDate');
            var diff = 0;
            if (d1 && d2) {
                diff = Math.floor((d2.getTime() - d1.getTime()) / 86400000); // ms per day
            }
            if (!isNaN(diff) || diff > 0) {
                $('#totalNights p .total').html(diff);
                $('#totalNights p').removeClass('hide');
                if (diff > 1) {
                    $('#totalNights p .plural').html('s');
                }
            }
        }
    
    var todayDate = $("#userBookingArrival").data('date');
    var todayDateArray = todayDate.split('-');
    
    var checkin = $("#userBookingArrival").datepicker({
        todayHighlight: true,
        startDate:todayDate,
        beforeShowDay: function(date) {
            if (date.valueOf() < now.valueOf())
                return {enabled:false};
                
            var theday = date.getDate();
            var themonth = date.getMonth() + 1;
            var theyear = date.getFullYear();
            
            if (bookedDates[theyear] && bookedDates[theyear][themonth])
                if ($.inArray(theday, bookedDates[theyear][themonth]) != -1) {
                    return {enabled:false, classes:'bg-warning'};
                }
        }
    }).on('changeDate', function(ev) {
        if (ev.dates.valueOf() > checkout.dates.valueOf()) {
            var newDate = new Date(ev.dates.valueOf());
            newDate.setDate(newDate.getDate() + 1);
            checkout.setStartDate(newDate);
            checkout.setDate(newDate);
        }
        checkin.hide();
        $('#userBookingDeparture')[0].focus();
    }).data('datepicker');
    
    var checkout = $("#userBookingDeparture").datepicker({
        todayHighlight: true,
        startDate:tomorrow,
        beforeShowDay: function(date) {
            if (date.valueOf() <= checkin.valueOf())
                return {enabled:false};
        }
    }).on('changeDate', function(ev) {
        checkout.hide();
    }).data('datepicker');
    
    $('#userBookingArrival,#userBookingDeparture').change(selector);
    
}( window.jQuery );