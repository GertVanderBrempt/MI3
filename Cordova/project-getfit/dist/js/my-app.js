// Initialize your app
var myApp = new Framework7();
// Export selectors engine
var $$ = Dom7;
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
            }
            , error: function (responseData, textStatus, errorThrown) {
                $$(".gf-txt-warning").html('POST failed. :' + errorThrown);
            }
        });
    }
}myApp.onPageInit('login', function (page) {
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
                $$(".gf-txt-warning").html((JSON.parse(responseData)).data);
            }
            , error: function (responseData, textStatus, errorThrown) {
                $$(".gf-txt-warning").html('POST failed. :' + errorThrown);
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