$(window).on("load", function() {
    checkLogin();
    loaded();
});

function checkLogin() {
    $.post('../Login/checkLogin.php',{},
        function ( data ) {
            var data_decoded = JSON.parse(data);
            var status = data_decoded['status'];

            if( status === "Success" )
            {
                $(".login").remove();
                checkWorkshopRegistration();
            }else
            {
                $(".barcode").remove();
                $(".logout").remove();
                $(".login").click(function () {
                    window.location.href = data_decoded['redirectUrl'];
                });
            }
        });
}

function bookWorkshop(WorkshopName) {
    $.post('../Login/checkLogin.php',{},
        function ( data ) {
            var data_decoded = JSON.parse(data);
            var status = data_decoded['status'];

            if( status === "Success" )
            {
                buyWorkshop(WorkshopName);
            }else
            {
                window.location.href = data_decoded['redirectUrl'];
            }
        });
}


function checkWorkshopRegistration(){
    $.post('php/checkWorkshopRegistration.php',{},
        function ( data ) {
            var data_decoded = JSON.parse(data);
            for( i=1; i<=7; i++){
                if(data_decoded.includes("WID0"+i)){
                    $("#w"+i+'register').remove();
                }
            }
        });
}

function buyWorkshop(WorkshopName) {
    $.post('php/sendPayment.php',{
            'ProgramName': WorkshopName
        },
        function ( data ) {
            if(data==="Failure"){
        	alert("Contact 9562613599 to clarify the problem");
            }else{
            	window.location.href=data;
            }
        });
}