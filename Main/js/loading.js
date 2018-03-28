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
            easing: 'easeInOutSine',
            complete: function () {
                $.notify.addStyle('toast', {
                    html: "<div><span class='notifyjs-toast-title' data-notify-text/></div>",
                    classes: {
                        base: {
                            "opacity": "0.85",
                            "background": "rgba(255,255,255,0.5)",
                            "padding":"20px"
                        },
                        title:{
                            "font-size": "16px"
                        }
                    }
                });
                $.notify.addStyle('toastClick1', {
                    html: "<div><span class='notifyjs-toast-title' data-notify-text/></div>",
                    classes: {
                        base: {
                            "opacity": "0.85",
                            "background": "rgba(255,255,255,0.5)",
                            "padding":"20px"
                        },
                        title:{
                            "font-size": "16px"
                        }
                    }
                });
                $.notify(
                    "Use Left and Right Keyboard Arrows to Navigate",
                    {
                        position:"bottom center",
                        autoHideDelay: 10000,
                        style: 'toast',
                        className: 'title'
                    }
                );
                
                $.notify(
                    "Click Here to view the Tentative Schedule",
                    {
                        position:"top right",
                        autoHideDelay: 10000,
                        style: 'toastClick1',
                        className: 'title'
                    }
                );
                
                $('.notifyjs-toastClick1-title').click(function(){
                	window.open('https://ragam.org.in/Main/tentativeScheduleRagam.pdf','_blank');
                });
                var url = window.location.href;
    		var res = url.split("#");
    		var redirection = res[1];
    		if(redirection==='events'){
    			$('.sample-docs').turn('page', 4);
    			$(".canvas").addClass('fullpage_canvas');
                        $('.sample-docs').turn('size',$(window).width(),$(window).height());
                        $(".sample-docs").addClass('fullpage_sample-docs');
    		}
            }
        });

        var openScreen = document.getElementById('line-drawing');
        openScreen.style.animationName = 'openUp';
        $("#svgremove").remove();
    }
}