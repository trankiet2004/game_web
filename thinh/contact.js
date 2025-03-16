document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contactForm');
  
    form.addEventListener('submit', function(e) {
      e.preventDefault();
      e.stopPropagation();
  
      // Check form validity
      if (form.checkValidity() === false) {
        form.classList.add('was-validated');
        return;
      }
  
      // Simulate sending message (integrate with your backend here)
      const submitButton = form.querySelector('button[type="submit"]');
      submitButton.disabled = true;
      submitButton.textContent = 'Sending...';
  
      // Fake delay to simulate message send process
      setTimeout(() => {
        alert('Thank you for contacting us! We will get back to you soon.');
        form.reset();
        form.classList.remove('was-validated');
        submitButton.disabled = false;
        submitButton.textContent = 'Send Message';
      }, 1500);
    });
  });
  
  // Google Maps initialization callback
  function initMap() {
    // Replace with your actual coordinates
    const location = { lat: 40.7128, lng: -74.0060 };
    const map = new google.maps.Map(document.getElementById("map"), {
      center: location,
      zoom: 14,
      styles: [ // Optional: custom dark theme styles for the map
        {
          "elementType": "geometry",
          "stylers": [{ "color": "#242f3e" }]
        },
        {
          "elementType": "labels.text.fill",
          "stylers": [{ "color": "#746855" }]
        },
        {
          "elementType": "labels.text.stroke",
          "stylers": [{ "color": "#242f3e" }]
        },
        {
          "featureType": "administrative.locality",
          "elementType": "labels.text.fill",
          "stylers": [{ "color": "#d59563" }]
        },
        {
          "featureType": "poi",
          "elementType": "labels.text.fill",
          "stylers": [{ "color": "#d59563" }]
        },
        {
          "featureType": "road",
          "elementType": "geometry",
          "stylers": [{ "color": "#38414e" }]
        },
        {
          "featureType": "road",
          "elementType": "geometry.stroke",
          "stylers": [{ "color": "#212a37" }]
        },
        {
          "featureType": "road",
          "elementType": "labels.text.fill",
          "stylers": [{ "color": "#9ca5b3" }]
        },
        {
          "featureType": "road.highway",
          "elementType": "geometry",
          "stylers": [{ "color": "#746855" }]
        },
        {
          "featureType": "road.highway",
          "elementType": "geometry.stroke",
          "stylers": [{ "color": "#1f2835" }]
        },
        {
          "featureType": "road.highway",
          "elementType": "labels.text.fill",
          "stylers": [{ "color": "#f3d19c" }]
        },
        {
          "featureType": "transit",
          "elementType": "geometry",
          "stylers": [{ "color": "#2f3948" }]
        },
        {
          "featureType": "transit.station",
          "elementType": "labels.text.fill",
          "stylers": [{ "color": "#d59563" }]
        },
        {
          "featureType": "water",
          "elementType": "geometry",
          "stylers": [{ "color": "#17263c" }]
        },
        {
          "featureType": "water",
          "elementType": "labels.text.fill",
          "stylers": [{ "color": "#515c6d" }]
        },
        {
          "featureType": "water",
          "elementType": "labels.text.stroke",
          "stylers": [{ "color": "#17263c" }]
        }
      ]
    });
  
    // Add a marker to the map
    new google.maps.Marker({
      position: location,
      map: map,
      title: "BKGame Office"
    });
  }
  