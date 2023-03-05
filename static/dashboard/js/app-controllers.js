
/***************************************************************************/
// DASHBOARD //
/***************************************************************************/


app.controller("dashboardController", function($scope, server){

    $scope.students = {};

    $scope.teachers = {};

    $scope.nonteachers ={};

    $scope.total = function () {

        function onSuccess (data)
        {
            console.log(data)
            $scope.teachers.total = data[0];

            $scope.nonteachers.total = data[1];

            delete data[0];

            delete data[1];
            console.log(data)

            sum = Object.values(data).reduce(function(a, b){
                return a + b;
            }, 0);

            $scope.students.total = sum;
        }

        function onFailure(p) {}

        server.get('dashboard/getTotalMember', onSuccess, onFailure);

    }

    $scope.total();

    $scope.stats = function () {

        return $scope.state

    }

    

})

app.controller("dummyController", function($scope, server){

    //activeNav.set("dummy")

    $scope.stats = function () {

        return $scope.state
        
    }

})


app.controller("staffController", function($scope, server){

    function getKeyByValue(object, value) {

        return Object.keys(object).find(key => object[key] === value);

    }

    let d = {teachers:0, nonteachers:1};

    server.get("dashboard/getAllStaff", function (p) {
            
        p.forEach((data)=>{

            $scope.staff[d[data.type]] = data;

            delete data.type;
            
        })

    }, function (s) {
        
    })

    $scope.staff = {}

    

    Object.values(d).forEach((e) => {

        server.post("dashboard/getStaffByType", {type: e}, function (p) {
            
            $scope.staff[getKeyByValue(d, e)] = p;

        }, function (s) {
            
        })
    })

    

    $scope.stats = function () {

        return $scope.state
        
    }

})


app.controller("studentsController", function($scope, server){

    function attachpaid(data){return data}

    function getKeyByValue(object, value) {

        return Object.keys(object).find(key => object[key] === value);

      }

    $scope.students = {}
    //activeNav.set("dummy")
    let classes = {c1:"LVL 1", c2: "LVL 2", c3: "LVL 3"};

    Object.values(classes).forEach((el) => {

        server.post("dashboard/getSClass", {class: el}, function (s) {

            $scope.students[getKeyByValue(classes, el)] = s;

            $scope.students[getKeyByValue(classes, el)].forEach((std)=>{std.class = el});

            console.log($scope.students)

        }, function (e){});

    })

    $scope.stats = function () {

        return $scope.state
        
    }

})

app.controller("settingsController", function($scope, urlMsg, server, $location){

    $scope.data = {k: "Hi", v:"Her "}

    $scope.form = {};


})
app.controller("viewMemberController", function($scope, urlMsg, server, $location){

    $scope.currentDate = new Date();
    //activeNav.set("dummy")
    data = urlMsg.get("class");

    _id = data[0];
    _class = data[1];

    if ($scope.value != ""|| $scope.value != undefined)
    {
        if (_class === "staff")
        {
            server.post(
                "dashboard/getStaff", {memberId: _id},
                function(r){
                    $scope.value = r;

                    console.log(r);
                }, function(m){})

        } else {

            server.post(
                "dashboard/getStudent", {memberId: _id, class: _class},
                function(r){
                    $scope.value = r;
                }, function(m){})
        }
    }

    $scope.stats = function () {

        return $scope.state
        
    }

    $scope.remove = function () {

        if (_class != "staff"){

            if (confirm("Do You really want to remove " + $scope.value.name + "?")){
                server.post(
                    "dashboard/withdrawStudent", {memberId: _id, class: _class},
                    function(r){

                        if (r) alert(_id + " Has been Removed Successfully")

                        $location.url("students")

                    }, function(m){})
            }
        } else {

            if (confirm("Do You really want to remove " + $scope.value.name + "?")){
                server.post(
                    "dashboard/withdrawStaff", {memberId: _id},
                    function(r){
                        
                        if (r) alert(_id + " Has been Removed Successfully")

                        $location.url("staff")

                    }, function(m){})
            }
        }
        //server.        
    }

})

app.controller("registerMemberController", function($scope, urlMsg, server){

    //activeNav.set("dummy")
    $scope.type = urlMsg.get();

    $scope.form = {};

    $scope.register = function () {

        $scope.form.date_of_birth = $scope.form.dob.day + "/" + $scope.form.dob.month +"/"+$scope.form.dob.year;

        delete $scope.form.dob;
        
        switch ($scope.type) {

            case "staff":
                
                server.post("dashboard/registerStaff", $scope.form, function (r) {

                    if (r) alert($scope.form.name + " is registered Successfully into "+ $scope.form.class +"!!"); 
                    
                }, function (e) {
                    
                    console.log(e);
                })
                break;
        
            default:
                server.post("dashboard/registerStudent", $scope.form, function (r) {

                    if (r) alert($scope.form.name + " is registered Successfully!!");
                    
                }, function (e) {
                    
                    console.log(e);
                })
                break;
        }

        
    }

    $scope.stats = function () {

        return $scope.state
        
    }

})

app.controller("searchController", function($scope, server){

    $scope.query = {by: "name", value: ""}

    $scope.result = [];//[{a:1, memberId:"o4444"}, {rr:15, memberId:"dummy"}];

    function errHandler(params) {
        
    }

    function getOutput(r) {
        
        $scope.result = r;

        console.log(r);

    }

    $scope.clear = function () {
        
        $scope.result = []
    }

    $scope.stats = function () {

        return $scope.state
        
    }

    $scope.search = function () {
        
        if ($scope.query.value != "")
        {
           // console.log($scope.query)
            server.post("dashboard/searchMember", $scope.query, getOutput, errHandler);

        } else {

            $scope.clear();

        }
    }

})

app.controller("navController", function($scope, links, tag, activeTag){

    // $scope.active = position.active;

    var ls = tag.getAll(".nav-link"), linkIds = [];
        
        ls.forEach(element => {
            
            links.elements.push(element);

            links.ids.push(element.id);

        });

    activeTag.set(links, "btn-primary");

})


/***************************************************************************/
// DASHBOARD //
/***************************************************************************/




// /************************** NAIN CONTROLLER *****************************/
// // This is the Main and first Controller to be loaded
// app.controller("mainController", function ($scope, $rootScope, $http, $location) {

//     $http.post("dashboard/getClass", {})

//         .then(function (re) {

//             console.log("hi");

//         })
//     // This is for the header
//     $scope.stats = function () {

//         return $scope.state;

//     }

//     $rootScope.logout = function () {
        
//         $http.get("dashboard/logout")
//         .then(function (re) {
//             //
//         })
//     }

//     // This is a global Delete function
//     $rootScope.withdrawMember = function (Id) {

//         $http.post("../dashboard/deleteMember", {id: Id})

//         .then(function (re) {

//             //alert(re.data);

//         })

//     }

//     // This replaces the data so that it can be passed through the url
//     $rootScope.getMoreInfo = function (data) {

//       // Data is the info to be passed (id)
//         var action = "0";

//         while (data.includes("/")) {

//             data = data.replace("/", "-");

//         }
      
//         $location.path('/update-record/' + data +"/" + action)

//     }

// })

// /************************* END OF MAIN CONTROLLER ***************************/
// //////////////////////////////////////////////////////////////////////////////



// //////////////////////////////////////////////////////////////////////////////
// /************************** UPDATE RECORD CONTROLLER ************************/

// app.controller("updateRecordController", function($scope, $rootScope, $routeParams, $http) {
  
//     $rootScope.href = {

//         home : ["#/",'main'],

//         about : ["#fee", "gfee"]
        
//     };
  
//     // This gets the url parameters parsed and store it in 'data'
//     var data = $routeParams.data;

//     while (data.includes("-")) {

//         data = data.replace("-", "/");

//     }

//     $scope.data = data;

//     $http.post("../dashboard/getMemberFullDetails", {search: $scope.data})

//     .then(function(r){

//         $scope.member = r.data[0];

//         // Adds the toogle Payment property to the member
//         $scope.member.togglePaymentRecord = function (x){
        
//             if (x.showPayment == false || x.showPayment == undefined){

//                 x.showPayment = true;

//             } else {

//                 x.showPayment = false;

//             }

//             // Controls the preview if it is empty
//             if (x.member.payment.transactions.length < 1) {

//                 x.noPayments = true;

//             }
//         }// End of the togglePaymentRecord

//         // Add to the student the toogle report book
//         if ($scope.member.member.type == "student") {
          
//             $scope.member.toggleReportBook = function(x) {
              
//                 if (x.showReportBook == false || x.showReportBook == undefined) { 

//                     x.showReportBook = true;

//                 } else {

//                     x.showReportBook = false;

//                 }

//                 if (x.reportBook.subjects.length < 1) {

//                     x.noReport = true;

//                 }
//             }
//         }
//     })// End of .then
// })

// /************************ END OF UPDATE RECORD CONTROLLER ************************/
// ///////////////////////////////////////////////////////////////////////////////////



// //////////////////////////////////////////////////////////////////////////////
// /************************** Edit Report CONTROLLER ************************/

// // app.controller("editReportBookController", function($scope, $rootScope, $routeParams, $http) {
  
// //     $rootScope.href = {

// //         home : ["#/",'main'],

// //         about : ["#fee", "gfee"]
        
// //     };
  
// //     // This gets the url parameters parsed and store it in 'data'
// //     var data = $routeParams.data;

// //     while (data.includes("-")) {

// //         data = data.replace("-", "/");

// //     }

// //     $scope.data = data;

// //     $http.post("../dashboard/getMemberFullDetails", {search: $scope.data})

// //     .then(function(r){

// //         $scope.member = r.data[0];

// //         // Adds the toogle Payment property to the member
// //         $scope.member.togglePaymentRecord = function (x){
        
// //             if (x.showPayment == false || x.showPayment == undefined){

// //                 x.showPayment = true;

// //             } else {

// //                 x.showPayment = false;

// //             }

// //             // Controls the preview if it is empty
// //             if (x.member.payment.transactions.length < 1) {

// //                 x.noPayments = true;

// //             }
// //         }// End of the togglePaymentRecord

// //         // Add to the student the toogle report book
// //         if ($scope.member.member.type == "student") {
          
// //             $scope.member.toggleReportBook = function(x) {
              
// //                 if (x.showReportBook == false || x.showReportBook == undefined) { 

// //                     x.showReportBook = true;

// //                 } else {

// //                     x.showReportBook = false;

// //                 }

// //                 if (x.reportBook.subjects.length < 1) {

// //                     x.noReport = true;

// //                 }
// //             }
// //         }
// //     })// End of .then
// // })

// /************************ END OF edit report RECORD CONTROLLER ************************/
// ///////////////////////////////////////////////////////////////////////////////////



// ///////////////////////////////////////////////////////////////////////////////////
// /****************************** Update panel CONTROLLER ******************************/

// app.controller("updatePanelController", function ($scope, $route,$http) {
//     //console.log($scope.person)
//     $scope.fieldsData = {}
//     //$scope.classET = "";

//     $scope.update = function(){
//         //console.log($scope.fieldsData);

//         $scope.fieldsData.Id = $scope.person.member.id;

//         form = new FormData();

//         form.append("id", $scope.fieldsData.Id);
//         form.append("name", $scope.fieldsData.name);
        
//         $http.post("../dashboard/editMemberData", form, {
//             transformRequest:angular.identity,
//             headers: { "Content-type" : undefined}
//         })

//         .then(function(re){

//             if (re.data == true){
//                 // $route.reload();
//             }
//         })

//         if ($scope.fieldsData.hasOwnProperty("class"))
//         {
//             switch ($scope.fieldsData.class.editType) {
//                 case "0":
//                     //alert($scope.fieldsData.class.by);
//                     $scope.moveClass($scope.fieldsData.class.by);
//                     break;

//                 case "1":
//                     $scope.moveClass(-1 * parseInt($scope.fieldsData.class.by));
//                     //alert(-1 * parseInt($scope.fieldsData.class.by));
//                     break;
//                 default:
//                     alert("Please select the action you want to perform..")
//                     break;
//             }
//         }

//         if ($scope.fieldsData.hasOwnProperty("picture"))
//         {
//             $scope.uploadFile($scope.fieldsData.picture);
//         }
        
//         $scope.fieldsData = {}

//         $route.reload();
//     }

//     $scope.moveClass = function(by) {

//         $http.post("../dashboard/promoteStudent", {Id : $scope.person.member.id, by : by})
//         .then(function(re){

//             if (!re.data){alert("Promotion or Demotion Failed due to Class does not exist")}
    
//         })
//     }

//     $scope.uploadFile = function (file) {
//         var fileFormData = new FormData();
        
//         fileFormData.append('profilePicture', file);
//         fileFormData.append('id', $scope.person.member.id);

//         console.log(fileFormData);

//         var url = "../dashboard/updatePicture";

//         $http.post(url, fileFormData , {
//             transformRequest: angular.identity,
//             headers: {'Content-type': undefined}
//         }). then(function(r){console.log(r)})
//     }

//     $scope.createFields = function () {
        
//         $scope.fieldsPlaceholder = {...$scope.fields};

//         for (const key in $scope.fields) {
//             if  ($scope.fields.hasOwnProperty(key)) {
//                 $scope.fieldsPlaceholder[key] = $scope.person[key];
//                 if (key == "class"){
//                     $scope.fieldsPlaceholder[key] = $scope.person.Class;
//                 }
//                 if (key == "picture"){
//                     $scope.fieldsPlaceholder[key] = $scope.person.member.picture;
//                 }
//             }
//         }
//         //console.log($scope.fieldsPlaceholder)
//         $scope.fields = {};
//     }
// })// End of update controller

// /**************************** END update panel CONTROLLER *****************************/
// ////////////////////////////////////////////////////////////////////////////////////



// ///////////////////////////////////////////////////////////////////////////////////
// /****************************** SIDE NAV CONTROLLER ******************************/

// app.controller("sidenavController", function ($scope, $rootScope) {

//     $scope.hrefme = {

//         home:["#/", "home"],

//         ...$rootScope.href

//     };

// })// End of sidenav controller

// /**************************** END SIDE NAV CONTROLLER *****************************/
// ////////////////////////////////////////////////////////////////////////////////////




// ///////////////////////////////////////////////////////////////////////////////////
// /******************************** DASH CONTROLLER ********************************/

// app.controller("dashboardController", function ($scope, $rootScope, $http) {

//     $rootScope.searchType = 0;// This set the search for dash

//     $scope.contains = false;

//     $rootScope.href = {

//         fee : ["#fee","fee"]
        
//     };

//     $scope.getAllStudent = function(){

//         $scope.result = {

//             getMoreInfo : $rootScope.getMoreInfo

//         };


//         $http.post("dashboard/getClass", {})

//         .then (function (data, err) {

//             $scope.result = { ...$scope.result, ...data.data};

//             $scope.contains = true;

//         })

//     }

// })//End of dash

// /****************************** END DASH CONTROLLER ******************************/
// ///////////////////////////////////////////////////////////////////////////////////




// //////////////////////////////////////////////////////////////////////////////////
// /******************************** FEE CONTROLLER ********************************/

// app.controller("feeController", function ($scope, $rootScope, $http) {

//     $scope.paymentData = {};

//     $scope.showPaymentPortal = false;

//     $rootScope.href = {

//         home : ["#/",'main'],

//         about : ["#fee", "gfee"]

//     }

//     // Prepares the search type to fee
//     $rootScope.searchType = 1;

//     $scope.makePayment = function(){

//         $http.post("../fee/pay", $scope.paymentData)

//         .then (function(result){

//             $scope.isSuccessful = result.data;

//         })
//     }


//     $http.get("../fee/getUnpaid")

//     .then(function (result){

//         $scope.deptors = result.data;

//         $scope.unpaidfeetype();

//     })

//     // This is to collect the payment data
//     // payme is the details of the person you want to pay
//     $scope.payme = function (payer = "", img = "", name = "") {

//         $scope.showPaymentPortal = true;

//         $scope.paymentData.payer = payer;

//         $scope.payerImg = img;

//         $scope.payerName = name;

//     }


//     $scope.unpaidfeetype = function(){

//         var data = $scope.deptors;

//         for (var i = 0; i < data.length; i++) {

//             adder = 0;

//             deptType = [];

//             for (k in data[i].dept) {

//                 if (data[i].dept[k] != null) {

//                     deptType.push(k);

//                     adder += data[i].dept[k];

//                 }

//             }

//             data[i].unpaidType = deptType;

//             data[i].totalDept = adder;

//             data[i].payme = $scope.payme;
//         }
        
//     }

// })// End of fee controller

// /****************************** END FEE CONTROLLER ******************************/
// //////////////////////////////////////////////////////////////////////////////////



// /////////////////////////////////////////////////////////////////////////////////
// /****************************** SEARCH CONTROLLER ******************************/

// app.controller("searchController", function ($scope, $rootScope, $http) {

//   $scope.found = false;

//   $scope.searchfor = function(){

//     $scope.students = [];

//     $scope.staffs = [];

//     var searchQuery = {

//         by : $scope.searchBy,

//         search : $scope.searchName

//     };

//     if ( $rootScope.searchType == 1 ){

//         searchQuery.getdept = 1;

//     }


//     $http.post("../dashboard/searchMember", searchQuery)

//     .then(function(data) {

//         var result = data.data;

//         if ( result.length >= 1 ){

//             $scope.found = true;

//         }
        
//         result.forEach(r => {

//             if (r.type == "student") {

//                 $scope.students.push(r);

//             } else {

//                 $scope.staffs.push(r);

//             }

//         });

//     })

//   }

// })

// /**************************** END SEARCH CONTROLLER ****************************/
// /////////////////////////////////////////////////////////////////////////////////


