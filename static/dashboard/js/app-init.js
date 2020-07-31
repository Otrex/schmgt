
var app = angular.module("MyDashboard", ["ngRoute"]);

app.value("position", {active:""});

app.value("links", {elements:[], ids:[]});

app.config(function($routeProvider, $locationProvider) {

    $locationProvider.hashPrefix('');

    $routeProvider

    .when("/", {

        templateUrl: "../static/dashboard/templates/dashboard1.htm",

        controller:"dashboardController"

    })

    .when("/students", {

        templateUrl: "../static/dashboard/templates/students.htm",

        controller:"studentsController"

    })

    .when("/dummy", {

        templateUrl: "../static/dashboard/templates/dashboard.htm",

        controller:"dummyController"

    })

    .when("/logout", {

        templateUrl : "dashboard/logout",

        controller: function () {

            window.location.href = "./home?msg=700";

        }

    })

    .when("/view-record/:data", {

        templateUrl: "../static/dashboard/templates/member-full.htm",

        controller:"viewMemberController"
            
    })

    .when("/register/:data", {

        templateUrl: "../static/dashboard/templates/register.htm",

        controller:"registerMemberController"
            
    })

    .otherwise({
        templateUrl: "../static/dashboard/templates/page-404.htm"
    })

});


app.filter("ucfirst", function(){

    return function (st) {

        var txt = "";

        if (st === undefined) {return ""}

        st.split(" ").forEach(el => {
            
            txt += el.replace(el[0], el[0].toUpperCase())+" ";

        });

        return txt
        
    }
})
/********************SERVICES ********************************/

app.service("server", function($http){

    this.get = function(url, successcallback, failureCallback, config = undefined)
    {
        $http.get(url, config)
        
        .then(function (r) {

            successcallback(r.data);

        }, function(m){

            failureCallback(m)

        });
    }

})


app.service("urlMsg", function($http, $routeParams){

    this.get = function()
    {
        var data = $routeParams.data;

        while (data.includes("-")) {

            data = data.replace("-", "/");

        }

        return data;
    }

})


app.service("tag", function(){

    this.get = function(selector)
    {
        //alert(selector)
        return document.querySelector(selector);
    }

    this.getAll = function(selector)
    {
        //alert(selector)
        return document.querySelectorAll(selector);
    }

})

app.service("activeTag", function($rootScope, $location, tag){

    this.set = function(links, _class)
    {
        $rootScope.$on("$routeChangeStart", function () {

            if (links.elements.length === 0){return}

            //console.log(links)

            links.elements.forEach(link => {
                
                link.classList.remove(_class);

            });

            var uri = $location.url(),

                tagname = uri ? ( uri == "/" ? "home" : uri.slice(1) ) : "home";

                //console.log(uri)

            if (uri === "logout") { return };

            tagname = tagname.split("/")[0]

            tagid = "#"+tagname;

            activeLink = tag.get(tagid);

            activeLink.classList.add(_class);
                
        })
    }

})

// app.controller("exitC", function ($http, $scope,$window, $location) {
//      //$location.path("/");
//     window.location.href = ".";
//  })