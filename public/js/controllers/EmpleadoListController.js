angular.module('empleadosApp')
.controller('EmpleadoListController', ['$scope', 'EmpleadoService', '$location', function($scope, EmpleadoService, $location) {
    $scope.empleados = [];
    $scope.currentPage = 1;
    $scope.totalItems = 0;
    $scope.itemsPerPage = 20;
    $scope.searchText = '';
    $scope.estadoFilter = '';
    
    $scope.loadEmpleados = function() {
       var params = {
        page: $scope.currentPage,
        search: $scope.searchText
    };

    if ($scope.estadoFilter) {
        params.estado = $scope.estadoFilter;
    }

        
        EmpleadoService.getEmpleados(params).then(function(response) {
            $scope.empleados = response.data.data;
            $scope.totalItems = response.data.total;
            $scope.itemsPerPage = response.data.per_page;
        });
    };
    
    $scope.pageChanged = function() {
        $scope.loadEmpleados();
    };
    
    $scope.search = function() {
        $scope.currentPage = 1;
        $scope.loadEmpleados();
    };
    
    $scope.nuevoEmpleado = function() {
        $location.path('/empleados/nuevo');
    };
    
    $scope.editarEmpleado = function(id) {
        $location.path('/empleados/' + id + '/editar');
    };
    
    $scope.verEmpleado = function(id) {
        $location.path('/empleados/' + id);
    };
    $scope.eliminarEmpleado = function(id) {
    if (confirm('¿Estás seguro de eliminar este empleado?')) {
        EmpleadoService.deleteEmpleado(id).then(function(response) {
            alert(response.data.message);
            $scope.loadEmpleados(); // refrescar lista
        }, function(error) {
            alert('Error al eliminar empleado');
            console.error(error);
        });
    }
};
    $scope.generarReporte = function() {
        EmpleadoService.getReporte().then(function(response) {
            // Implementar lógica para descargar el reporte
            console.log(response.data);
            alert('Reporte generado. Ver consola para detalles.');
        });
    };
   $scope.generarReporte = function() {
        EmpleadoService.generarReportePdf().then(function(response) {
            // Crear un blob con los datos del PDF
            var file = new Blob([response.data], {type: 'application/pdf'});
            
            // Crear un enlace para descargar el archivo
            var fileURL = URL.createObjectURL(file);
            var a = document.createElement('a');
            a.href = fileURL;
            a.target = '_blank';
            a.download = 'reporte_empleados.pdf';
            document.body.appendChild(a);
            a.click();
            
            // Limpiar
            setTimeout(function() {
                document.body.removeChild(a);
                URL.revokeObjectURL(fileURL);  
            }, 100);
        }, function(error) {
            console.error('Error al generar el reporte:', error);
            alert('Error al generar el reporte');
        });
    };
    


    
   
    $scope.loadEmpleados();
}]);