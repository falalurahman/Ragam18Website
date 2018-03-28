function bookProshowTicket(proshow) {
    if(loggedIn){
        buyProshowTicket(proshow);
    }else {
        window.location.href = redirectUrl;
    }
}

function buyProshowTicket(proshow) {
    $.post('php/sendPayment.php',{
            'ProgramName': proshow
        },
        function ( data ) {
            if(data==="Failure"){
        	alert("Contact 9562613599 to clarify the problem");
            }else{
            	window.location.href=data;
            }
        });
}