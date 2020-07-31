/******************* Numbers Total **************/
app.directive("dTotal",  function () {

    return {

        scope : {

              infoData : '=dData',

              type : "=dMemberType",
        
        },
        
        templateUrl: function (elem, attr) {
        
            return "../static/dashboard/templates/snippets/" + attr.panel + ".htm";
        
        }
    }
})


app.directive("dMiddle", function () {
    
    return {

        restrict: "E",

        transclude: true,

        template: "<div class='v-middle'><div><ng-transclude></ng-transclude></div></div>"
    }
})


/******************* Member **************/
app.directive("dMemberLess",  function () {

    return {

        scope : {

              member : '=dData'
        
        },
        
        templateUrl: "../static/dashboard/templates/snippets/member-less.htm",
        
        controller: function($scope, $location){

            $scope.view = function (memberId) {
                
                $location.path('/view-record/' + memberId)
                
            }
        }//function (elem, attr) {
        
        //     return "../static/dashboard/templates/snippets/" + attr.panel + ".htm";
        
        // }
    }
})



/*************************** DR-SIDENAV VIEW *************************/
app.directive("dNavBar", function () {

    return {

        templateUrl: "../static/dashboard/templates/snippets/nav-bar.htm",

        controller:"navController"

    }

})



/*************************** DR-user info VIEW *************************/
app.directive("dUserInfoBar", function () {

    return {

        templateUrl: "../static/dashboard/templates/snippets/user-info.htm"

    }

})

/*************************** DR-Searchinfo VIEW *************************/
app.directive("dSearchBar", function () {

    return {

        templateUrl: "../static/dashboard/templates/snippets/search-bar.htm",

        controller: "searchController"

    }

})



// /********************** END OF DR-SIDENAV VIEW ***********************/



// /********************** DR-MYPERSON VIEW ***********************/
// app.directive("dirMyPerson", function () {

//   return {

//     scope : { person : '=memberData'},

//     templateUrl : function (elem, attr) {
      
//       return hostpath + "templates/snippets/" + attr.type + "-item.htm";

//     }

//   }

// })
// /********************** END OF DR-MYPERSON VIEW ***********************/



// /********************** DR-SEARCH BAR VIEW ***********************/
// app.directive("dirSearchBar", function () {

//   return {

//     scope :false,

//     templateUrl :  hostpath + "templates/snippets/search-panel.htm",

//     controller: "searchController"

//   }

// })
// /*********************END OF DR-SEARCH BAR VIEW ********************/



// /********************** DR-RECORD VIEW ***********************/
// app.directive("dirRecord", function() {

//   return {

//     scope : {

//       person : '=memberData'

//     },

//     templateUrl: function (elem, attr) {

//         return hostpath + "templates/snippets/" + attr.type + "-view.htm";

//     }

//   }

// })
// /********************** END DR-RECORD VIEW ***********************/


// /********************** DR-UPDATEPANEL VIEW ***********************/
// app.directive("dirUpdatePanel", function(){

//   return {
    
//       scope : {

//         person : '=memberData'

//       },

//       templateUrl : hostpath + "templates/snippets/update-panel.htm",

//       controller : "updatePanelController"

//   }

// })

// /********************** DR-UPDATE PANEL VIEW ***********************/


// app.directive("fileUpload", function ($parse) {
  
//   return {
//     restrict: 'A',
    
//     link : function(scope, element, attrs){

//       var x = $parse(attrs.fileUpload);
      
//       mod = x.assign;

//       element.bind("change", function () {
//         scope.$apply(function(){
//           mod(scope, element[0].files[0])
//         }) 
             
//        //console.log({scope : scope, element:element[0].files[0], attrs: attrs, m: mod});
//       })
//     }
//   }
// })