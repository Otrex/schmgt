
var app = angular.module("MyDashboard", ["ngRoute"]);

app.config(function($routeProvider, $locationProvider) {

    $locationProvider.hashPrefix('');

    var loc = schmgt.rootDir + "/static/dashboard/"

    $routeProvider

    .when("/", {

        templateUrl: loc + "templates/dashboard.htm",

        controller:"dashboardController"

    })

    .when("/logout", {

        templateUrl : "dashboard/logout",

        controller:"exitC"

    })


    // .when("/fee", {

    //     templateUrl: loc + "templates/fee.htm",

    //     controller:"feeController"

    // })

    // .when("/update-record/:data/:action", {

    //     templateUrl: loc + "templates/update-record.htm",

    //     controller:"updateRecordController"
        
    // })

    // .when("/edit-reportbook/:data/:action", {

    //     templateUrl: loc + "templates/edit-reportbook.htm",

    //     controller:"editReportBookController"
        
    // })
    
});

app.controller("exitC", function ($http, $scope,$window, $location) {
     //$location.path("/");
    window.location.href = schmgt.rootDir;
 })