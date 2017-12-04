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
myApp.onPageInit('login', function (page) {
    // run createContentPage func after link was clicked
    $$('.create-page').on('click', function () {
        createContentPage();
    });
    //
});
/*

function Register()
    {
        event.preventDefault();
        var User={};
        User.Voornaam = $("#Voornaam").val();
        User.Familienaam = $("#Familenaam").val();
        User.Email = $("#Email").val();
        User.Wachtwoord = $("#Wachtwoord").val();
        User.Geslacht = $("#Geslacht").val();
        User.Geboortedatum = $("Geboortedatum").val();

        $(function()
        {
            $.ajax({
                type: "POST",
                url: 'php/Register.php',
                data: '{user: ' + JSON.stringify(User) + '}',
                contentType: "application/json; charset=utf-8",
                dataType: 'json',
                success: function (response) {
                    alert("User has been added successfully.");
                    window.location.reload();
                },error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
            });
            return false
        });
    }
*/
// Callbacks to run specific code for specific pages, for example for About page:
myApp.onPageInit('page1', function (page) {
    // run createContentPage func after link was clicked
    $$('.create-page').on('click', function () {
        createContentPage();
    });

$("#currency").on("change",function() {
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
	mainView.router.loadContent(
        '<!-- Top Navbar-->' +
        '<div class="navbar">' +
        '  <div class="navbar-inner">' +
        '    <div class="left"><a href="#" class="back link"><i class="icon icon-back"></i><span>Back</span></a></div>' +
        '    <div class="center sliding">Dynamic Page ' + (++dynamicPageIndex) + '</div>' +
        '  </div>' +
        '</div>' +
        '<div class="pages">' +
        '  <!-- Page, data-page contains page name-->' +
        '  <div data-page="dynamic-pages" class="page">' +
        '    <!-- Scrollable page content-->' +
        '    <div class="page-content">' +
        '      <div class="content-block">' +
        '        <div class="content-block-inner">' +
        '          <p>Here is a dynamic page created on ' + new Date() + ' !</p>' +
        '          <p>Go <a href="#" class="back">back</a> or go to <a href="services.html">Services</a>.</p>' +
        '        </div>' +
        '      </div>' +
        '    </div>' +
        '  </div>' +
        '</div>'
    );
	return;
}