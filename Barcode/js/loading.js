var drawingDone = 0;
var loadingDone = 0;

var lineDrawing = anime({
	targets: '#line-drawing .lines path',
	strokeDashoffset: [anime.setDashoffset, 0],
	easing: 'easeInOutSine',
	duration: 3000,
	delay: function (el, i) {
		return i * 250
	},
	complete: function () {
		drawingDone = 1;
		if(loadingDone === 1){
			loaded();
		}
    }
});

function loaded() {
    loadingDone = 1;
    if (drawingDone === 1) {
        var zoomOut = anime({
            targets: '#line-drawing img',
            scale: 0,
            duration: 2000,
            easing: 'easeInOutSine'
        });

        var openScreen = document.getElementById('line-drawing');
        openScreen.style.animationName = 'openUp';
        $("#svgremove").remove();
    }
}