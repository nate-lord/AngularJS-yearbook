angular.module( 'YearbookApp', [ 'autoheight' ] ).controller( 'YearbookCtrl', [ '$http', '$timeout', function( $http, $timeout ) {
  var self = this;
  var $rootScope = angular.element( document.documentElement ).scope();
  self.ids = ProfileIds;
  
  self.CurrentProfile = {
    firstName: InitialProfile.firstName,
    lastName: InitialProfile.lastName,
    imgFileName: InitialProfile.imgFileName,
    graduationYear: InitialProfile.graduationYear,
    clubs: InitialProfile.clubs,
    futurePlans: InitialProfile.futurePlans,
    quote: InitialProfile.quote,
    id: InitialProfile.id
  };
  
  self.notEditable = true;
  
  self.isTransitioning = false;
  
  self.animationClasses = {
    'navVisiblity': ( self.notEditable ? 'visible' : 'notVisible' ),
    'profileTransition': ( self.isTransitioning ? 'visible' : 'notVisible' )
  };
  
  
  
  self.fn = {
    changeProfile: function( id ) {
      id = parseInt( id, 10 );
      
      if ( id === self.CurrentProfile.id ) {
        return
      }
      
      self.isTransitioning = true;
      
      $timeout(
        function() {
          $http
            .post( 'getProfile.php', { id: id })
            .then(
              function successCallback( response ) {
                self.CurrentProfile.firstName = response.data.first_name;
                self.CurrentProfile.lastName = response.data.last_name;
                self.CurrentProfile.imgFileName = response.data.img_file_name;
                self.CurrentProfile.graduationYear = response.data.graduation_year;
                self.CurrentProfile.clubs = response.data.clubs;
                self.CurrentProfile.futurePlans = response.data.future_plans;
                self.CurrentProfile.quote = response.data.quote;
                self.CurrentProfile.id = response.data.id;
                
                self.fn.resizeTextareas();
                self.isTransitioning = false;
              },
              function errorCallback( response ) {
                console.log( 'error:' );
                console.log( response );
              }
            );
        }, 200
      );
    },
    getNavVisibilityClass: function() {
      return ( self.notEditable ? 'visible' : 'notVisible' );
    },
    getProfileTransitionClass: function() {
      return ( self.isTransitioning ? 'transitioning' : 'notTransitioning' );
    },
    getTransitionClass: function( bool ) {
      return ( self.isTransitioning ? 'hide' : '' );
    },
    getValidationClass: function( bool ) {
      return ( bool ? 'invalid' : 'valid' );
    },
    resizeTextareas: function() {
      $rootScope.$broadcast( 'autoheight-adjust' );
    },
    save: function() {
      var Profile;
      if ( !self.notEditable ) {
        return;
      }
      
      Profile = angular.toJson( self.CurrentProfile );
      console.log( Profile );
      $http
        .post( 'saveProfile.php', self.CurrentProfile )
        .then(
          function successCallback( response ) {
            console.log( 'success:' );
            console.log( response );
          },
          function errorCallback( response ) {
            console.log( 'error:' );
            console.log( response );
          }
        );
    }
  }
  self.fn.resizeTextareas();
  window.onresize = self.fn.resizeTextareas;
}]);