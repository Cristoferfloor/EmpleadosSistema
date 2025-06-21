angular.module('empleadosApp', ['ngRoute'])
.config(['$routeProvider', function($routeProvider) {
    $routeProvider
        .when('/', {
            templateUrl: 'views/empleados/list.html',
            controller: 'EmpleadoListController'
        })
        .when('/empleados/nuevo', {
            templateUrl: 'views/empleados/form.html',
            controller: 'EmpleadoFormController'
        })
        .when('/empleados/:id/editar', {
            templateUrl: 'views/empleados/form.html',
            controller: 'EmpleadoFormController'
        })
        .when('/empleados/:id', {
            templateUrl: 'views/empleados/show.html',
            controller: 'EmpleadoShowController'
        })
        .otherwise({
            redirectTo: '/'
        });
}]);