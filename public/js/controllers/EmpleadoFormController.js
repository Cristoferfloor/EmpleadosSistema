angular.module('empleadosApp')
.controller('EmpleadoFormController', ['$scope', 'EmpleadoService', '$routeParams', '$location', function($scope, EmpleadoService, $routeParams, $location) {
    $scope.empleado = {
        estado: 'VIGENTE',
        datos_laborales: {
            jornada_parcial: false
        }
    };
    $scope.provincias = [];
    $scope.isEdit = false;
    $scope.guardando = false;

    // Cargar provincias
    EmpleadoService.getProvincias().then(function(response) {
        $scope.provincias = response.data;
    });

    // Modo edición
    if ($routeParams.id) {
        $scope.isEdit = true;

        EmpleadoService.getEmpleado($routeParams.id).then(function(response) {
            $scope.empleado = response.data;

            if (!$scope.empleado.datos_laborales) {
                $scope.empleado.datos_laborales = {};
            }

            // Convertir fechas
            if ($scope.empleado.fecha_nacimiento) {
                $scope.empleado.fecha_nacimiento = new Date($scope.empleado.fecha_nacimiento);
            }
            if ($scope.empleado.datos_laborales.fecha_ingreso) {
                $scope.empleado.datos_laborales.fecha_ingreso = new Date($scope.empleado.datos_laborales.fecha_ingreso);
            }

            // Convertir tipos
            $scope.empleado.datos_laborales.sueldo = parseFloat($scope.empleado.datos_laborales.sueldo || 0);
            $scope.empleado.datos_laborales.jornada_parcial = $scope.empleado.datos_laborales.jornada_parcial === true || $scope.empleado.datos_laborales.jornada_parcial === 1;

            $scope.empleado.datos_laborales.provincia_id = String($scope.empleado.datos_laborales.provincia_id || '');
        });
    }

    // Guardar empleado
    $scope.guardarEmpleado = function() {
        $scope.guardando = true;
        const datos = $scope.empleado.datos_laborales;

        // Validaciones de tipo
        datos.jornada_parcial = (datos.jornada_parcial === true || datos.jornada_parcial === 'true');
        datos.provincia_id = parseInt(datos.provincia_id);
        datos.sueldo = parseFloat(datos.sueldo);

        try {
            $scope.empleado.fecha_nacimiento = new Date($scope.empleado.fecha_nacimiento).toISOString().slice(0, 10);
            datos.fecha_ingreso = new Date(datos.fecha_ingreso).toISOString().slice(0, 10);
        } catch (e) {
            alert('Error en el formato de fecha');
            $scope.guardando = false;
            return;
        }

        const request = $scope.isEdit
            ? EmpleadoService.updateEmpleado($routeParams.id, $scope.empleado)
            : EmpleadoService.createEmpleado($scope.empleado);

        request.then(() => {
            alert($scope.isEdit ? 'Empleado actualizado correctamente' : 'Empleado creado correctamente');
            $location.path('/');
        }, function(error) {
            console.error('Error:', error);
            alert('Error:\n' + JSON.stringify(error.data, null, 2));
        }).finally(() => {
            $scope.guardando = false;
        });
    };

    $scope.cancelar = function() {
        $location.path('/');
    };
}]);
