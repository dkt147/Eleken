// Initialize and add the map
// function initMap() {
//     // The location of Uluru
//     const uluru = { lat: 24.868353856378757, lng: 67.0816387829692 };
//     // The map, centered at Uluru
//     const map = new google.maps.Map(document.getElementById("map"), {
//       zoom: 18,
//       center: uluru,
//     });
//     // The marker, positioned at Uluru
//     const marker = new google.maps.Marker({
//       position: uluru,
//       map: map,
//     });
//   }

function initMap() {
  // The location of Uluru
  const uluru = [
    { lat: 24.86572610272431, lng: 67.15033480677955 },
    { lat: 24.86572610272431, lng: 67.15033480677955 },
  ];
  // The map, centered at Uluru
  const map = new google.maps.Map(document.getElementById("map"), {
    zoom: 18,
    center: uluru[0],
  });
  // The marker, positioned at Uluru
  for (let i = 0; i < uluru.length; i++) {
    let marker = new google.maps.Marker({
      position: uluru[i],
      map: map,
    });
  }
}

window.initMap = initMap;
