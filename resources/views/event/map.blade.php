<script async defer
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAorsjtV7VJRlduybX8UoWYrD9SaRKWX7A&callback=initMap">
</script>
<script src="{{asset('js/map.js')}}"></script>
<script>
function initMap() {
  // The location of Uluru
  var uluru = {lat: {{$lat}}, lng: {{$lng}}};
  // The map, centered at Uluru
  var map = new google.maps.Map(
      document.getElementById('map'), {zoom: 11, center: uluru});
  // The marker, positioned at Uluru
  var marker = new google.maps.Marker({position: uluru, map: map});
}
</script>
<style>
       /* Set the size of the div element that contains the map */
      #map {
        height: 250px;  /* The height is 400 pixels */
        width: 100%;  /* The width is the width of the web page */
       }
    </style>