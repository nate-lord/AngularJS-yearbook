<?php
include 'init.php';
?>
<html ng-app="YearbookApp" lang="">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>AngularJS spin up</title>
    <meta name="description" content="An example of AngularJS">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="styles/sass/stylesheets/style.css">
  </head>
  <body ng-controller="YearbookCtrl as ctrl">
    <nav ng-cloak ng-class="ctrl.fn.getNavVisibilityClass()">
      <div ng-repeat="id in ctrl.ids">
        <input type="radio"
               name="profiles"
               ng-value="id.id"
               ng-checked="ctrl.CurrentProfile.id == id.id"
               ng-click="ctrl.fn.changeProfile( id.id )" />
        <label>profile {{ id.id }}</label>
      </div>
    </nav>
    <footer>
      <input type="checkbox"
             name="toggleEdit"
             ng-model="ctrl.notEditable"
             ng-click="ctrl.fn.save()"
             ng-disabled="profile.firstName.$error.maxlength || profile.lastName.$error.maxlength || profile.graduationYear.$error.maxlength || profile.quote.$error.maxlength" />
      <label class="visible"><span ng-show="ctrl.notEditable">edit</span><span ng-show="!ctrl.notEditable">save</span></label>
    </footer>
    
    <main>
      <form name="profile">
        <header ng-class="ctrl.fn.getTransitionClass()">
          <h1 class="firstName" ng-class="ctrl.fn.getValidationClass( profile.firstName.$error.maxlength )">
            <input type="text"
                   ng-model="ctrl.CurrentProfile.firstName"
                   name="firstName"
                   ng-maxlength="9"
                   ng-disabled="ctrl.notEditable"
                   disabled />
          </h1>
          <h1 class="lastName" ng-class="ctrl.fn.getValidationClass( profile.lastName.$error.maxlength )">
            <input type="text"
                   ng-model="ctrl.CurrentProfile.lastName"
                   name="lastName"
                   ng-maxlength="9"
                   ng-disabled="ctrl.notEditable"
                   disabled /></h1>
        </header>
        <figure>
          <img ng-cloak
               ng-class="ctrl.fn.getTransitionClass()"
               src="imgs/{{ ctrl.CurrentProfile.imgFileName }}" />
        </figure>
        <dl ng-class="ctrl.fn.getTransitionClass()">
          <div class="row" ng-class="ctrl.fn.getValidationClass( profile.graduationYear.$error.maxlength )">
            <dt>Class of</dt>
            <dd>
              <input type="text"
                     ng-model="ctrl.CurrentProfile.graduationYear"
                     name="graduationYear"
                     ng-maxlength="12"
                     ng-disabled="ctrl.notEditable"
                     disabled />
            </dd>
          </div>
          <div class="row">
            <dt>Clubs</dt>
            <dd><textarea autoheight ng-disabled="ctrl.notEditable" disabled ng-model="ctrl.CurrentProfile.clubs"></textarea></dd>
          </div>
          <div class="row">
            <dt>Future plans</dt>
            <!-- angular specific: https://stackoverflow.com/questions/17772260/textarea-auto-height -->
            <dd><textarea autoheight ng-disabled="ctrl.notEditable" disabled ng-model="ctrl.CurrentProfile.futurePlans"></textarea></dd>
          </div>
        </dl>
        <blockquote ng-class="[ ctrl.fn.getValidationClass( profile.quote.$error.maxlength ), ctrl.fn.getTransitionClass() ]">
          <textarea ng-disabled="ctrl.notEditable"
                    ng-maxlength="150"
                    name="quote"
                    disabled
                    ng-model="ctrl.CurrentProfile.quote"></textarea>
        </blockquote>
      </form>
    </main>
<?php
  echo getGlobalScriptFromRows();
?>
    <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.3.11/angular.min.js"></script>
    <script src="scripts/plugins.js"></script>
    <script src="scripts/script.js"></script>
  </body>
</html>