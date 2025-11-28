/*
Template Name: Rasket- Responsive Bootstrap 5 Admin Dashboard
Author: Techzaa
File: vector map js
*/


class VectorMap {

    initWorldMapMarker() {
        new jsVectorMap({
            map: 'world',
            selector: '#world-map-markers',
            zoomOnScroll: false,
            zoomButtons: true,
            markersSelectable: true,
            markers: [
                { name: "Greenland", coords: [72, -42] },
                { name: "Canada", coords: [56.1304, -106.3468] },
                { name: "Brazil", coords: [-14.2350, -51.9253] },
                { name: "Egypt", coords: [26.8206, 30.8025] },
                { name: "Russia", coords: [61, 105] },
                { name: "China", coords: [35.8617, 104.1954] },
                { name: "United States", coords: [37.0902, -95.7129] },
                { name: "Norway", coords: [60.47, 8.46] },
                { name: "Ukraine", coords: [48.37, 31.16] },
            ],
            markerStyle: {
                initial: { fill: "#5B8DEC" },
                selected: { fill: "#ed5565" }
            },
            labels: {
                markers: {
                    render: marker => marker.name
                }
            },
            regionStyle: {
                initial: {
                    fill: 'rgba(169,183,197,0.2)'
                }
            },
        });
    }

    initCanadaVectorMap() {
        new jsVectorMap({
            map: 'canada',
            selector: '#canada-vector-map',
            zoomOnScroll: false,
            regionStyle: { initial: { fill: '#1e84c4' } }
        });
    }

    initRussiaVectorMap() {
        new jsVectorMap({
            map: 'russia',
            selector: '#russia-vector-map',
            zoomOnScroll: false,
            regionStyle: { initial: { fill: '#1bb394' } }
        });
    }

    initIraqVectorMap() {
        new jsVectorMap({
            map: 'iraq',
            selector: '#iraq-vector-map',
            zoomOnScroll: false,
            regionStyle: { initial: { fill: '#f8ac59' } }
        });
    }

    initSpainVectorMap() {
        new jsVectorMap({
            map: 'spain',
            selector: '#spain-vector-map',
            zoomOnScroll: false,
            regionStyle: { initial: { fill: '#23c6c8' } }
        });
    }

    initUsaVectorMap() {
        new jsVectorMap({
            map: 'us_merc_en',
            selector: '#usa-vector-map',
            regionStyle: { initial: { fill: '#ffe381' } }
        });
    }

    init() {
        this.initWorldMapMarker();
        this.initCanadaVectorMap();
        this.initRussiaVectorMap();
        this.initIraqVectorMap();
        this.initSpainVectorMap();
        // this.initUsaVectorMap();
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new VectorMap().init();
});
