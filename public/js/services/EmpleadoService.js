angular.module('empleadosApp')
.factory('EmpleadoService', ['$http', function($http) {
    return {
        getEmpleados: function(params) {
            return $http.get('/api/empleados', { params: params });
        },
        getEmpleado: function(id) {
            return $http.get('/api/empleados/' + id);
        },
        createEmpleado: function(empleado) {
            return $http.post('/api/empleados', empleado);
        },
        updateEmpleado: function(id, empleado) {
            return $http.put('/api/empleados/' + id, empleado);
        },
        deleteEmpleado: function(id) {
            return $http.delete('/api/empleados/' + id);
        },
        getReporte: function() {
            return $http.get('/api/empleados/reporte/general');
        },
        getProvincias: function() {
            return $http.get('/api/provincias');
        },
        generarReportePdf: function() {
            return $http({
                url: '/api/empleados/reporte/pdf',
                method: 'GET',
                responseType: 'arraybuffer' 
            });
        }
    };
}]);