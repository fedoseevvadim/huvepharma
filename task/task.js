////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Первый Бит
// Август 2019
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$(document).ready(function () {

      // Перечеркиваем задачи, которые уже выполнены
      var checkExist = setInterval(function() {

         if ($('[data-bx-calendar-entry]').length) {

             var elems = $('[data-bx-calendar-entry]');

             for ( var i = 0; i < elems.length; i++ ) {

                 var value = elems[i].getAttribute("data-bx-calendar-entry");
                 var status = elems[i].getAttribute("status");

                 if (value.includes("task")) {

                     if ( status === "5" ) {
                         elems[i].classList.add("calendar-event-line-text-completed");
                     }

                 }

             }

             //clearInterval(checkExist);
         }
      }, 1000);

});

