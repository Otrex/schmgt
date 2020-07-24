
/************************** NAIN CONTROLLER *****************************/
// This is the Main and first Controller to be loaded
app.controller("mainController", function ($scope, $rootScope, $http, $location) {

    $http.post("dashboard/getClass", {})

        .then(function (re) {

            console.log(re.data);

        })
    // This is for the header
    $scope.stats = function () {

        return $scope.state;

    }

    $rootScope.logout = function () {
        
        $http.get("dashboard/logout")
        .then(function (re) {
            //
        })
    }

    // This is a global Delete function
    $rootScope.withdrawMember = function (Id) {

        $http.post("../dashboard/deleteMember", {id: Id})

        .then(function (re) {

            //alert(re.data);

        })

    }

    // This replaces the data so that it can be passed through the url
    $rootScope.getMoreInfo = function (data) {

      // Data is the info to be passed (id)
        var action = "0";

        while (data.includes("/")) {

            data = data.replace("/", "-");

        }
      
        $location.path('/update-record/' + data +"/" + action)

    }

})

/************************* END OF MAIN CONTROLLER ***************************/
//////////////////////////////////////////////////////////////////////////////



//////////////////////////////////////////////////////////////////////////////
/************************** UPDATE RECORD CONTROLLER ************************/

app.controller("updateRecordController", function($scope, $rootScope, $routeParams, $http) {
  
    $rootScope.href = {

        home : ["#/",'main'],

        about : ["#fee", "gfee"]
        
    };
  
    // This gets the url parameters parsed and store it in 'data'
    var data = $routeParams.data;

    while (data.includes("-")) {

        data = data.replace("-", "/");

    }

    $scope.data = data;

    $http.post("../dashboard/getMemberFullDetails", {search: $scope.data})

    .then(function(r){

        $scope.member = r.data[0];

        // Adds the toogle Payment property to the member
        $scope.member.togglePaymentRecord = function (x){
        
            if (x.showPayment == false || x.showPayment == undefined){

                x.showPayment = true;

            } else {

                x.showPayment = false;

            }

            // Controls the preview if it is empty
            if (x.member.payment.transactions.length < 1) {

                x.noPayments = true;

            }
        }// End of the togglePaymentRecord

        // Add to the student the toogle report book
        if ($scope.member.member.type == "student") {
          
            $scope.member.toggleReportBook = function(x) {
              
                if (x.showReportBook == false || x.showReportBook == undefined) { 

                    x.showReportBook = true;

                } else {

                    x.showReportBook = false;

                }

                if (x.reportBook.subjects.length < 1) {

                    x.noReport = true;

                }
            }
        }
    })// End of .then
})

/************************ END OF UPDATE RECORD CONTROLLER ************************/
///////////////////////////////////////////////////////////////////////////////////



//////////////////////////////////////////////////////////////////////////////
/************************** Edit Report CONTROLLER ************************/

// app.controller("editReportBookController", function($scope, $rootScope, $routeParams, $http) {
  
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

/************************ END OF edit report RECORD CONTROLLER ************************/
///////////////////////////////////////////////////////////////////////////////////



///////////////////////////////////////////////////////////////////////////////////
/****************************** Update panel CONTROLLER ******************************/

app.controller("updatePanelController", function ($scope, $route,$http) {
    //console.log($scope.person)
    $scope.fieldsData = {}
    //$scope.classET = "";

    $scope.update = function(){
        //console.log($scope.fieldsData);

        $scope.fieldsData.Id = $scope.person.member.id;

        form = new FormData();

        form.append("id", $scope.fieldsData.Id);
        form.append("name", $scope.fieldsData.name);
        
        $http.post("../dashboard/editMemberData", form, {
            transformRequest:angular.identity,
            headers: { "Content-type" : undefined}
        })

        .then(function(re){

            if (re.data == true){
                // $route.reload();
            }
        })

        if ($scope.fieldsData.hasOwnProperty("class"))
        {
            switch ($scope.fieldsData.class.editType) {
                case "0":
                    //alert($scope.fieldsData.class.by);
                    $scope.moveClass($scope.fieldsData.class.by);
                    break;

                case "1":
                    $scope.moveClass(-1 * parseInt($scope.fieldsData.class.by));
                    //alert(-1 * parseInt($scope.fieldsData.class.by));
                    break;
                default:
                    alert("Please select the action you want to perform..")
                    break;
            }
        }

        if ($scope.fieldsData.hasOwnProperty("picture"))
        {
            $scope.uploadFile($scope.fieldsData.picture);
        }
        
        $scope.fieldsData = {}

        $route.reload();
    }

    $scope.moveClass = function(by) {

        $http.post("../dashboard/promoteStudent", {Id : $scope.person.member.id, by : by})
        .then(function(re){

            if (!re.data){alert("Promotion or Demotion Failed due to Class does not exist")}
    
        })
    }

    $scope.uploadFile = function (file) {
        var fileFormData = new FormData();
        
        fileFormData.append('profilePicture', file);
        fileFormData.append('id', $scope.person.member.id);

        console.log(fileFormData);

        var url = "../dashboard/updatePicture";

        $http.post(url, fileFormData , {
            transformRequest: angular.identity,
            headers: {'Content-type': undefined}
        }). then(function(r){console.log(r)})
    }

    $scope.createFields = function () {
        
        $scope.fieldsPlaceholder = {...$scope.fields};

        for (const key in $scope.fields) {
            if  ($scope.fields.hasOwnProperty(key)) {
                $scope.fieldsPlaceholder[key] = $scope.person[key];
                if (key == "class"){
                    $scope.fieldsPlaceholder[key] = $scope.person.Class;
                }
                if (key == "picture"){
                    $scope.fieldsPlaceholder[key] = $scope.person.member.picture;
                }
            }
        }
        //console.log($scope.fieldsPlaceholder)
        $scope.fields = {};
    }
})// End of update controller

/**************************** END update panel CONTROLLER *****************************/
////////////////////////////////////////////////////////////////////////////////////



///////////////////////////////////////////////////////////////////////////////////
/****************************** SIDE NAV CONTROLLER ******************************/

app.controller("sidenavController", function ($scope, $rootScope) {

    $scope.hrefme = {

        home:["#/", "home"],

        ...$rootScope.href

    };

})// End of sidenav controller

/**************************** END SIDE NAV CONTROLLER *****************************/
////////////////////////////////////////////////////////////////////////////////////




///////////////////////////////////////////////////////////////////////////////////
/******************************** DASH CONTROLLER ********************************/

app.controller("dashboardController", function ($scope, $rootScope, $http) {

    $rootScope.searchType = 0;// This set the search for dash

    $scope.contains = false;

    $rootScope.href = {

        fee : ["#fee","fee"]
        
    };

    $scope.getAllStudent = function(){

        $scope.result = {

            getMoreInfo : $rootScope.getMoreInfo

        };


        $http.post("dashboard/getClass", {})

        .then (function (data, err) {

            $scope.result = { ...$scope.result, ...data.data};

            $scope.contains = true;

        })

    }

})//End of dash

/****************************** END DASH CONTROLLER ******************************/
///////////////////////////////////////////////////////////////////////////////////




//////////////////////////////////////////////////////////////////////////////////
/******************************** FEE CONTROLLER ********************************/

app.controller("feeController", function ($scope, $rootScope, $http) {

    $scope.paymentData = {};

    $scope.showPaymentPortal = false;

    $rootScope.href = {

        home : ["#/",'main'],

        about : ["#fee", "gfee"]

    }

    // Prepares the search type to fee
    $rootScope.searchType = 1;

    $scope.makePayment = function(){

        $http.post("../fee/pay", $scope.paymentData)

        .then (function(result){

            $scope.isSuccessful = result.data;

        })
    }


    $http.get("../fee/getUnpaid")

    .then(function (result){

        $scope.deptors = result.data;

        $scope.unpaidfeetype();

    })

    // This is to collect the payment data
    // payme is the details of the person you want to pay
    $scope.payme = function (payer = "", img = "", name = "") {

        $scope.showPaymentPortal = true;

        $scope.paymentData.payer = payer;

        $scope.payerImg = img;

        $scope.payerName = name;

    }


    $scope.unpaidfeetype = function(){

        var data = $scope.deptors;

        for (var i = 0; i < data.length; i++) {

            adder = 0;

            deptType = [];

            for (k in data[i].dept) {

                if (data[i].dept[k] != null) {

                    deptType.push(k);

                    adder += data[i].dept[k];

                }

            }

            data[i].unpaidType = deptType;

            data[i].totalDept = adder;

            data[i].payme = $scope.payme;
        }
        
    }

})// End of fee controller

/****************************** END FEE CONTROLLER ******************************/
//////////////////////////////////////////////////////////////////////////////////



/////////////////////////////////////////////////////////////////////////////////
/****************************** SEARCH CONTROLLER ******************************/

app.controller("searchController", function ($scope, $rootScope, $http) {

  $scope.found = false;

  $scope.searchfor = function(){

    $scope.students = [];

    $scope.staffs = [];

    var searchQuery = {

        by : $scope.searchBy,

        search : $scope.searchName

    };

    if ( $rootScope.searchType == 1 ){

        searchQuery.getdept = 1;

    }


    $http.post("../dashboard/searchMember", searchQuery)

    .then(function(data) {

        var result = data.data;

        if ( result.length >= 1 ){

            $scope.found = true;

        }
        
        result.forEach(r => {

            if (r.type == "student") {

                $scope.students.push(r);

            } else {

                $scope.staffs.push(r);

            }

        });

    })

  }

})

/**************************** END SEARCH CONTROLLER ****************************/
/////////////////////////////////////////////////////////////////////////////////


