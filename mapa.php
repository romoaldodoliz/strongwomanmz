<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>

<style>
html, body {
height: 100%;
margin: 0;
}

.leaflet-container {
height: 400px;
width: 600px;
max-width: 100%;
max-height: 100%;
}
</style>

<div style="display: flex; flex-direction: row; justify-content: left; align-items: center;">
<div id="map" style="width: 900px; height: 600px;"></div>
</div>

<script>const map = L.map('map').setView([-19.3022, 34.9145], 7);

const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
maxZoom: 19,
attribution: '&copy; <a href="http://www.pircom.org.mz">PIRCOM</a>'
}).addTo(map);

const anaNilzaIcon = L.icon({
        iconUrl: 'https://cdn-icons-png.flaticon.com/128/9088/9088666.png',
        iconSize: [70, 70],
    });

    const teclaDavidIcon = L.icon({
        iconUrl: 'https://cdn-icons-png.flaticon.com/128/9088/9088666.png',
        iconSize: [70, 70],
    });

    const anaNilzaMarker = L.marker([-25.9692, 32.5732], {
        icon: anaNilzaIcon,
        zIndexOffset: 1000
    }).addTo(map);
    anaNilzaMarker.bindPopup('Sede do Movimento');

    const gazaMarker = L.marker([-24.1335, 33.5677], {
        icon: teclaDavidIcon,
        zIndexOffset: 1000
    }).addTo(map);
    gazaMarker.bindPopup('Xai-Xai');

    const sofalaMarker = L.marker([-19.1211, 34.8552]).addTo(map);
    sofalaMarker.bindPopup('Sofala');

    const caboDelgadoMarker = L.marker([-12.0181, 39.0652]).addTo(map);
caboDelgadoMarker.bindPopup('Cabo Delgado');

const nampulaMarker = L.marker([-15.1164, 39.2673]).addTo(map);
nampulaMarker.bindPopup('Nampula');

const teteMarker = L.marker([-16.2073, 33.5935]).addTo(map);
teteMarker.bindPopup('Tete');

const niassaMarker = L.marker([-12.983, 36.2995]).addTo(map);
niassaMarker.bindPopup('Niassa');

map.fitBounds([
[-26.919, 30.213],
[-10.317, 40.851]
]);
</script>


<p><br><br></p>