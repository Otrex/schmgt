
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

    // .when("/d:id", {

    //     templateUrl: "../static/dashboard/templates/dashboard1.htm",

    //     controller: function($scope, $routeParams){
    //         //alert(JSON.stringify($routeParams))

    //         var id = $routeParams.id;

    //         $scope.date = id;

    //         console.log($scope.date)

    //     }//"dashboardController"

    // })

    .when("/students", {

        templateUrl: "../static/dashboard/templates/students.htm",

        controller:"studentsController"

    })

    .when("/staff", {

        templateUrl: "../static/dashboard/templates/staff.htm",

        controller:"staffController"

    })

    .when("/dummy", {

        templateUrl: "../static/dashboard/templates/dashboard.htm",

        controller:"dummyController"

    })

    .when("/settings", {

        templateUrl : "../static/dashboard/templates/settings.htm",

        controller:"settingsController"

    })

    .when("/logout", {

        templateUrl : "dashboard/logout",

        controller: function () {

            window.location.href = "./home?msg=700";

        }

    })

    .when("/view-record/:data/:class", {

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
app.filter("purpose", function(){
    return function (s) {
        var txt = "";
        switch (s) {
            case "sf":
                return "School Fee"

            case "lf":
                return "Lesson Fee"

            case "bf":
                return "Bus Fee"
            default:
                break;
        }
        return txt;
        
    }
})

app.filter("medium", function(){
    return function (s) {
        var txt = "";

        switch (s) {
            case "1":
                return "Bank"
                break;
            case "0":
                return "Cash"
                break;
            default:
                break;
        }

        return txt;
        
    }
})

app.filter("type", function(){
    return function (s) {
        var txt = "";
        switch (s) {
            case "0":
                return "Debit"
                break;
            case "1":
                return "Credit"
            default:
                break;
        }
        return txt;
        
    }
})


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

    this.post = function (url, data, successcallback, failureCallback, config = { 

        transformRequest: angular.identity,

        headers: {'Content-type': undefined} })
    {
        
        let formData = new FormData()

        for ( x in data )
        {
            //console.log([x, data[x]])
            formData.append(x, data[x])
        }

        //console.log({x: data, y: formData})

        $http.post(url, formData , config)
        
        .then(function (r) {

            successcallback(r.data);

        }, function(m){

            failureCallback(m)

        });
    }

})

app.service("tools", function(){

    this.currentDate = new Date();

    this.calender = function (y, m, out) {
    
        return new Calender(out, y, m);
    
    }
})

app.service("urlMsg", function($http, $routeParams){

    this.get = function(params)
    {
        var data = $routeParams.data;

        while (data.includes("-")) {

            data = data.replace("-", "/");

        }

        if (params)
        {
            return [data, $routeParams.class];
        }

        return data;
    }

    this.prepare = function(data)
    {
        while (data.includes("/")) {

            data = data.replace("/", "-");

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

            if (activeLink) {

                activeLink.classList.add(_class);

            }
                
        })
    }

})

// app.controller("exitC", function ($http, $scope,$window, $location) {
//      //$location.path("/");
//     window.location.href = ".";
//  })


function TableBuilder(id, cls, attrs = {border:"1"})
  {

    this.table = document.createElement("table");

    this.cur = this.table;

    this.addAttr = function (el, attrs) {

        for (attr in attrs)
        {
            el.setAttribute(attr , attrs[attr]);
        }

    }

    this.addAttr(this.table, attrs);

    this.th = function (cont) {

        var h = document.createElement("th");

        h.innerHTML = cont;

        this.table.appendChild(h);

    }

    this.tr = function (rs) {

      var r = document.createElement("tr");

      this.table.appendChild(r);

      if (rs)
      {
          this.addAttr(r, {rowspan: rs});
      }

      this.cur = r

    }

    this.td = function (cont = "", cs) {
      
      var c = document.createElement("td");

      c.innerHTML = cont;
      
      if (cs)
      {
          this.addAttr(c, {colspan: cs});
      }

      this.cur.appendChild(c);

      return c;

    }

    this.enterHtml = function (c, data) {
      
      c.innerHTML = data;

    }

    this.append = function (el) {

      el.appendChild(this.table);
      
    }

    this.clearppend = function (el) {

        el.innerHTML = "";

        this.append(el);
    }
  }

  function Calender(el, year, mnth) {

    this.el = el;

    this.numMnth = 31;

    this.year = year ? year.length === 4? year : new Date().getFullYear() : new Date().getFullYear();

    this.mnth = mnth ? mnth : new Date().getMonth() + 1;

    var months = [ "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ]
    var label = [ "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday" ];

    this.isLeap = function () {
        return this.year % 100 === 0 ? this.year % 400 === 0 : this.year % 4 === 0;
    }

    this.numDays = function()
    {
        this.numMnth = this.mnth == 4 || this.mnth == 6 || this.mnth == 9  || this.mnth == 11 ? 30 : this.mnth == 2 ?( this.isLeap() ? 28 : 29 ): 31;
    }

    this.numDays();

    var d = new Date(this.year+"/"+this.mnth+"/1");

    //console.log(d);

    var k = d.getDay()//used to print out the headers

    // for (i = 1; i <= this.numMnth; i++)
    // {

    //     console.log([label[k], i])
    //     if (i % 6 == 0)
    //     {
    //         console.log("....");
    //     }

    //     k === 6 ? k=0 : k++;

    // }

    // console.log(d)

    this.eventDisplay = function(day){

        var el = document.createElement("div");

        var header = document.createElement("header")

        var h1 = document.createElement("h1")

        h1.innerHTML = day +"/"+this.mnth+"/"+this.year;

        header.appendChild(h1);

        el.appendChild(el)

        this.el.appendChild(el)

    }
    this.create = function () {
        this.el.innerHTML = "";
        var m = document.createElement("h1");
        m.innerHTML = months[this.mnth - 1] +" "+ this.year;

        
        
        this.el.appendChild(m);
        
        var view = new TableBuilder("","",attrs= {})

        for (m of label)
        {
            view.th(m.slice(0,3));
        }

        view.tr()

        var i = 1, end = 1;

        //console.log([k, label[k]])

        while (i <= 42)
        {
            if (i > k && end <= this.numMnth)
            {
                view.td("<a ng-click='eventOpen("+this.year+","+this.mnth+","+end+")'>"+(end)+"</a>")

                end++;

            } else {

                view.td();
            }

            if (i % 7 == 0)
            {
                view.tr()
            }

            i ++;
        }

        view.append(this.el)
        

    }
}