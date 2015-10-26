angular.module('webview')
.controller('mainController', [ '$scope', '$http', function($scope, $http){
        $scope.input = {};

        var success = function(data){

            console.log(data);

        };

        var error = function(error){

        };

        $scope.submit = function(){
            $http.post('/search', $scope.input).then(success, error);
        };


    }]);