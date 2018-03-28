var loggedIn = -1;
var redirectUrl;

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
                loggedIn = 1;
                $(".login").remove();
                checkHospitalityRegistration();
                checkMainReg();
            }else
            {
                loggedIn = 0;
                redirectUrl = data_decoded['redirectUrl'];
                $(".barcode").remove();
                $(".logout").remove();
                $(".login").click(function () {
                    window.location.href = data_decoded['redirectUrl'];
                });
            }
        });
}

function bookHospitality() {
    $.post('../Login/checkLogin.php',{},
        function ( data ) {
            var data_decoded = JSON.parse(data);
            var status = data_decoded['status'];

            if( status === "Success" )
            {
                checkMainRegistration();
            }else
            {
                window.location.href = data_decoded['redirectUrl'];
            }
        });
}

function checkMainRegistration(){
    $.post('php/checkMainRegistration.php',{},
        function ( data ) {

            if( data === "SUCCESS" )
            {
                buyHospitality();
            }else
            {
                checkWorkshopRegistration();
            }
        });
}


function checkWorkshopRegistration(){
    $.post('php/checkWorkshopRegistration.php',{},
        function ( data ) {

            if( data === "SUCCESS" )
            {
                buyHospitality();
            }else
            {
                alert("Main Event Registration must be done to avail Hospitality");
            }
        });
}

function checkHospitalityRegistration() {
    $.post('php/checkHospitalityRegistration.php',{},
        function ( data ) {
            if( data === "SUCCESS" )
            {
                $("#hospi").remove();
            }
        });
}

function buyHospitality() {
    $.post('php/sendPayment.php',{
            'ProgramName': 'Hospitality Registration'
        },
        function ( data ) {
            if(data==="Failure"){
        	alert("Contact 9562613599 to clarify the problem");
            }else{
            	window.location.href=data;
            }
        });
}

function bookCombo(comboName) {
    if(loggedIn){
        buyCombo(comboName)
    }else {
        window.location.href=redirectUrl;
    }
}

function buyCombo(comboName) {
    $.post('php/sendPayment.php',{
            'ProgramName': comboName
        },
        function ( data ) {
            if(data==="Failure"){
        	alert("Contact 9562613599 to clarify the problem");
            }else{
            	window.location.href=data;
            }
        });
}

function checkMainReg(){
    $.post('php/checkMainRegistration.php',{},
        function ( data ) {

            if( data === "SUCCESS" )
            {
                $(".buy_register_button").remove();
            }
        });
}