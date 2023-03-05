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

app.directive("dSettingItem",  function () {

    return {

        scope : {

              infoData : '=dData',
        },

        template : function($scope)
        {
            $scope.form  = {};
            
            return "<div>" 

            + "<label>{{infoData[0]}}: {{infoData[1]}} </label>"
            + "<button class='btn btn-primary ' style='margin: 0px 10px; width: 70px;' ng-click='t = t ? 0 : 1' > Edit </button>"
            + "<input class='form-control' ng-model='form[infoData[0]]' ng-show='t' />"
            + "</div>"
        }
        
        // templateUrl: function (elem, attr) {
        
        //     return "../static/dashboard/templates/snippets/" + attr.panel + ".htm";
        
        // }
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
        
        controller: function($scope, $location, urlMsg){

            $scope.view = function (memberId, _class = "staff") {
                
                $location.path('/view-record/' + urlMsg.prepare(memberId) + '/' + urlMsg.prepare(_class))
                
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

app.directive("dCalender", function () {

    return {

        templateUrl: "../static/dashboard/templates/snippets/calender.htm",

        controller : function(tools, tag, $scope)
        {
            tools.calender($scope.y, $scope.m, tag.get("#cal-view")).create();

            $scope.eventOpen = function (y, m, d) {
                //alert(""+y+m+d);
                console.log([y,m,d])
            }
            
            $scope.$watch('m',function (nv, ov) {
                console.log([nv,ov, $scope.m]);
                if (nv){
                    tools.calender($scope.y, $scope.m, tag.get("#cal-view")).create();
                }
            })

            $scope.$watch('y',function (nv, ov) {
                console.log([nv,ov, $scope.y]);
                if (nv){
                    tools.calender($scope.y, $scope.m, tag.get("#cal-view")).create();
                }
            })


        }

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