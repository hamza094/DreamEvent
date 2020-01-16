document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.strtdate');
    var instances = M.Datepicker.init(elems, {format: 'yyyy-mm-dd'});
  });

 document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.strttime');
    var instances = M.Timepicker.init(elems, {});
  });

document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.enddate');
    var instances = M.Datepicker.init(elems, {format: 'yyyy-mm-dd'});
  });
 document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.endtime');
    var instances = M.Timepicker.init(elems, {});
  });
document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('select');
            var instances = M.FormSelect.init(elems);
        });

google.maps.event.addDomListener(window, 'load', function () {
        var places = new google.maps.places.Autocomplete(document.getElementById('location'));
        google.maps.event.addListener(places, 'place_changed', function () {

        });
    });

tinymce.init({
          selector:'#desc',
       height: 350,
             plugins: [
      'advlist autolink link image lists charmap preview hr anchor pagebreak',
      'searchreplace wordcount visualblocks visualchars code fullscreen media nonbreaking',
      'save table directionality emoticons template paste'
    ],
      });
