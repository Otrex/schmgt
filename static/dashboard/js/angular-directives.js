
var hostpath = location.origin + "/schoolmgt/static/";

/*************************** DR-SIDENAV VIEW *************************/
app.directive("dirSideNav", function () {

    return {

        templateUrl: hostpath + "templates/side-nav.htm",

        controller:"sidenavController"

    }

})
/********************** END OF DR-SIDENAV VIEW ***********************/



/********************** DR-MYPERSON VIEW ***********************/
app.directive("dirMyPerson", function () {

  return {

    scope : { person : '=memberData'},

    templateUrl : function (elem, attr) {
      
      return hostpath + "templates/snippets/" + attr.type + "-item.htm";

    }

  }

})
/********************** END OF DR-MYPERSON VIEW ***********************/



/********************** DR-SEARCH BAR VIEW ***********************/
app.directive("dirSearchBar", function () {

  return {

    scope :false,

    templateUrl :  hostpath + "templates/snippets/search-panel.htm",

    controller: "searchController"

  }

})
/*********************END OF DR-SEARCH BAR VIEW ********************/



/********************** DR-RECORD VIEW ***********************/
app.directive("dirRecord", function() {

  return {

    scope : {

      person : '=memberData'

    },

    templateUrl: function (elem, attr) {

        return hostpath + "templates/snippets/" + attr.type + "-view.htm";

    }

  }

})
/********************** END DR-RECORD VIEW ***********************/


/********************** DR-UPDATEPANEL VIEW ***********************/
app.directive("dirUpdatePanel", function(){

  return {
    
      scope : {

        person : '=memberData'

      },

      templateUrl : hostpath + "templates/snippets/update-panel.htm",

      controller : "updatePanelController"

  }

})

/********************** DR-UPDATE PANEL VIEW ***********************/


app.directive("fileUpload", function ($parse) {
  
  return {
    restrict: 'A',
    
    link : function(scope, element, attrs){

      var x = $parse(attrs.fileUpload);
      
      mod = x.assign;

      element.bind("change", function () {
        scope.$apply(function(){
          mod(scope, element[0].files[0])
        }) 
             
       //console.log({scope : scope, element:element[0].files[0], attrs: attrs, m: mod});
      })
    }
  }
})