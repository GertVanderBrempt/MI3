// Initialize your app
var myApp = new Framework7();
// Export selectors engine
var $$ = Dom7;
var GEB_ID = null;
var GEB_Voornaam = null;
var GEB_Familienaam = null;
var rouForGeb = [];
var rouForNotGeb = [];
// Add view
var mainView = myApp.addView('.view-main', {
    // Because we use fixed-through navbar we can enable dynamic navbar
    dynamicNavbar: true
});
// Callbacks to run specific code for specific pages, for example for About page:
myApp.onPageInit('registreer', function (page) {
    // run createContentPage func after link was clicked
    /*$$('.create-page').on('click', function () {
        createContentPage();
    });*/
    //
    $$('.gf-btn-registreer-gebruiker').on('click', function () {
        RegistreerGebruiker();
    });
});

function RegistreerGebruiker() {
    //event.preventDefault();
    //console.log('click registreer');
    var data = {};
    data.bewerking = "addGeb";
    data.GEB_Voornaam = $(".gf-input-voornaam").val();
    data.GEB_Familienaam = $(".gf-input-familienaam").val();
    data.GEB_Email = $(".gf-input-email").val();
    data.GEB_Wachtwoord = $(".gf-input-wachtwoord").val();
    var GEB_Wachtwoord2 = $(".gf-input-wachtwoord2").val();
    if (data.GEB_Wachtwoord != GEB_Wachtwoord2) {
        $$(".gf-txt-warning").html("wachtwoorden komen niet overeen");
        $$(".gf-txt-warning").css("color", "red");
    }
    else {
        data.GEB_Wachtwoord = CryptoJS.MD5(data.GEB_Wachtwoord).toString();
        $$.ajax({
            type: "POST"
            , url: 'http://getfit.getenjoyment.net/getfitdb.php'
            , crossDomain: true
            , data: data
            , withCredentials: false
            , success: function (responseData, textStatus, jqXHR) {
                $$(".gf-txt-warning").html((JSON.parse(responseData)).data);
                $$(".gf-txt-warning").css("color", "green");
            }
            , error: function (responseData, textStatus, errorThrown) {
                $$(".gf-txt-warning").html('POST failed. :' + errorThrown);
                $$(".gf-txt-warning").css("color", "red");
            }
        });
    }
}
myApp.onPageInit('login', function (page) {
    $$('.gf-btn-login-gebruiker').on('click', function () {
        LoginGebruiker();
    });
});

function LoginGebruiker() {
    //event.preventDefault();
    //console.log('click login');
    var data = {};
    data.bewerking = "checkLogin";
    data.GEB_Email = $(".gf-input-email").val();
    data.GEB_Wachtwoord = $(".gf-input-wachtwoord").val();
    //else {
    data.GEB_Wachtwoord = CryptoJS.MD5(data.GEB_Wachtwoord).toString();
    $$.ajax({
        type: "POST"
        , url: 'http://getfit.getenjoyment.net/getfitdb.php'
        , crossDomain: true
        , data: data
        , withCredentials: false
        , success: function (responseData, textStatus, jqXHR) {
            if ((JSON.parse(responseData)).status === 200) {
                GEB_ID = (JSON.parse(responseData)).data[0]["GEB_ID"];
                if (GEB_ID != null) {
                    var dataGeb = {};
                    dataGeb.bewerking = "getGeb";
                    dataGeb.GEB_ID = GEB_ID;
                    $$.ajax({
                        type: "POST"
                        , url: 'http://getfit.getenjoyment.net/getfitdb.php'
                        , crossDomain: true
                        , data: dataGeb
                        , withCredentials: false
                        , success: function (responseData, textStatus, jqXHR) {
                            if ((JSON.parse(responseData)).status === 200) {
                                GEB_Voornaam = (JSON.parse(responseData)).data[0]["GEB_Voornaam"];
                                GEB_Familienaam = (JSON.parse(responseData)).data[0]["GEB_Familienaam"];
                                $$(".gf-txt-warning").html(GEB_Voornaam + " werd met success ingelogd");
                                $$(".gf-txt-warning").css("color", "green");
                                mainView.router.loadPage({
                                    url: 'home.html'
                                    , ignoreCache: true
                                    , reload: true
                                });
                            }
                            else {
                                $$(".gf-txt-warning").html((JSON.parse(responseData)).data);
                                $$(".gf-txt-warning").css("color", "red");
                            }
                        }
                        , error: function (responseData, textStatus, errorThrown) {
                            $$(".gf-txt-warning").html("Er ging iets mis tijdens het versturen :" + errorThrown);
                            $$(".gf-txt-warning").css("color", "red");
                        }
                    });
                }
            }
            else {
                $$(".gf-txt-warning").html((JSON.parse(responseData)).data);
                $$(".gf-txt-warning").css("color", "red");
            }
        }
        , error: function (responseData, textStatus, errorThrown) {
            $$(".gf-txt-warning").html("Er ging iets mis tijdens het versturen :" + errorThrown);
            $$(".gf-txt-warning").css("color", "red");
        }
    });
    //}
}
//
myApp.onPageInit('home', function (page) {
    /*$$('.gf-btn-login-gebruiker').on('click', function () {
        LoginGebruiker();
    });*/
    if (GEB_Voornaam != null) {
        $$(".content-block-title").html("Welkom " + GEB_Voornaam + " " + GEB_Familienaam);
    }
});
myApp.onPageInit('routines', function (page) {//traag
    var dataGeb = {};
    dataGeb.bewerking = "getRouForGeb";
    dataGeb.GEB_ID = GEB_ID;
    $$.ajax({
        type: "POST"
        , url: 'http://getfit.getenjoyment.net/getfitdb.php'
        , crossDomain: true
        , data: dataGeb
        , withCredentials: false
        , success: function (responseData, textStatus, jqXHR) {
            if ((JSON.parse(responseData)).status === 200) {
                var html = "";
                (JSON.parse(responseData)).data.forEach(function (dataRou) {
                    console.log(dataRou);
                    var ROU_ID = dataRou["ROU_ID"];
                    var ROU_Naam = dataRou["ROU_Naam"];
                    html += "<p data-value-id='" + ROU_ID + "' >";
                    html += ROU_Naam;
                    html += "</p>";
                });
                rouForGeb = html;
                //$$(".mijn-routines").html(html);
                if(html.length > 0){
                $$(".mijn-routines").html(html);
                }else{
                $$(".mijn-routines").html("<p style='color:red;' >"+"geen"+"</p>");
                }
            }
            else {
                //$$(".gf-txt-warning").html((JSON.parse(responseData)).data);
                //$$(".gf-txt-warning").css("color", "red");
            }
        }
        , error: function (responseData, textStatus, errorThrown) {
            //$$(".gf-txt-warning").html("Er ging iets mis tijdens het versturen :" + errorThrown);
            //$$(".gf-txt-warning").css("color", "red");
        }
    });
    var dataGeb2 = {};
    dataGeb2.bewerking = "getRouForNotGeb";
    dataGeb2.GEB_ID = GEB_ID;
    $$.ajax({
        type: "POST"
        , url: 'http://getfit.getenjoyment.net/getfitdb.php'
        , crossDomain: true
        , data: dataGeb2
        , withCredentials: false
        , success: function (responseData, textStatus, jqXHR) {
            if ((JSON.parse(responseData)).status === 200) {
                var html = "";
                (JSON.parse(responseData)).data.forEach(function (dataRou) {
                    console.log(dataRou);
                    var ROU_ID = dataRou["ROU_ID"];
                    var ROU_Naam = dataRou["ROU_Naam"];
                    html += "<p data-value-id='" + ROU_ID + "'>";
                    html += ROU_Naam;
                    html += "</p>";
                });
                rouForNotGeb = html;
                //console.log(html);
                if(html.length > 0){
                $$(".andere-routines").html(html);
                }else{
                $$(".andere-routines").html("geen");
                }
            }
            else {
                //$$(".gf-txt-warning").html((JSON.parse(responseData)).data);
                //$$(".gf-txt-warning").css("color", "red");
            }
        }
        , error: function (responseData, textStatus, errorThrown) {
            //$$(".gf-txt-warning").html("Er ging iets mis tijdens het versturen :" + errorThrown);
            //$$(".gf-txt-warning").css("color", "red");
        }
    });
});
myApp.onPageInit('maakroutine', function (page) {
    $$('.gf-btn-addRou').on('click', function () {
        AddRou();
    });
});

function AddRou() {
    //event.preventDefault();
    //console.log('click login');
    var data = {};
    data.bewerking = "addRou";
    data.ROU_Naam = $(".gf-input-naam").val();
    data.ROU_GEB_ID = GEB_ID;
    $$.ajax({
        type: "POST"
        , url: 'http://getfit.getenjoyment.net/getfitdb.php'
        , crossDomain: true
        , data: data
        , withCredentials: false
        , success: function (responseData, textStatus, jqXHR) {
            if ((JSON.parse(responseData)).status === 200) {
                $$(".gf-txt-warning").html((JSON.parse(responseData)).data[0]);
                $$(".gf-txt-warning").css("color", "green");
            }
            else {
                $$(".gf-txt-warning").html((JSON.parse(responseData)).data);
                $$(".gf-txt-warning").css("color", "red");
            }
        }
        , error: function (responseData, textStatus, errorThrown) {
            $$(".gf-txt-warning").html("Er ging iets mis tijdens het versturen :" + errorThrown);
            $$(".gf-txt-warning").css("color", "red");
        }
    });
    //}
}
// Callbacks to run specific code for specific pages, for example for About page:
myApp.onPageInit('page1', function (page) {
    // run createContentPage func after link was clicked
    $$('.create-page').on('click', function () {
        createContentPage();
    });
    $("#currency").on("change", function () {
        alert($(this).val());
    });
});
// Callbacks to run specific code for specific pages, for example for About page:
myApp.onPageInit('page2', function (page) {
    // run createContentPage func after link was clicked
    $$('.create-page').on('click', function () {
        createContentPage();
    });
});
// Generate dynamic page
var dynamicPageIndex = 0;

function createContentPage() {
    mainView.router.loadContent('<!-- Top Navbar-->' + '<div class="navbar">' + '  <div class="navbar-inner">' + '    <div class="left"><a href="#" class="back link"><i class="icon icon-back"></i><span>Back</span></a></div>' + '    <div class="center sliding">Dynamic Page ' + (++dynamicPageIndex) + '</div>' + '  </div>' + '</div>' + '<div class="pages">' + '  <!-- Page, data-page contains page name-->' + '  <div data-page="dynamic-pages" class="page">' + '    <!-- Scrollable page content-->' + '    <div class="page-content">' + '      <div class="content-block">' + '        <div class="content-block-inner">' + '          <p>Here is a dynamic page created on ' + new Date() + ' !</p>' + '          <p>Go <a href="#" class="back">back</a> or go to <a href="services.html">Services</a>.</p>' + '        </div>' + '      </div>' + '    </div>' + '  </div>' + '</div>');
    return;
}