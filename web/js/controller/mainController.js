'use strict';
angular.module('webview')
.controller('mainController', [ '$scope', '$http', function($scope, $http){
        $scope.input = {};
        $scope.loading = false;

        $scope.selected_tag = null;

        var success = function(data){
            $scope.html_data = data.data.raw;
            $scope.totals = data.data.totals;
        };

        var error = function(error){
            $scope.error_message = error.status == 404
                ? 'Sorry the URL you requested, '+ $scope.input.search +' was not found - bummer.'
                : (error.status == 400
                    ? 'Opps.. looks like something might be wrong - maybe you have a malformed URL ?'
                    : 'Something Bad Happened - Be sure we are hard at slee.. work fixing it!');

        };

        $scope.highlightItems = function(k){
            $scope.dehighlightItems();
            var targets = $('.hljs-title:contains("'+k+'")');

            // sanity check
            var filteredTargets = _.filter(targets, function(d){
                var text = $(d).text();
                return k === text;
            });

            $(filteredTargets).addClass('highlighted');

            $scope.selected_tag = k;
        };

        $scope.dehighlightItems = function() {
            $scope.selected_tag = null;
            $('.hljs-title').removeClass('highlighted');
        };

        $scope.submit = function(){
            $scope.error_message = '';
            $scope.loading = true;

            $http.post('/search', $scope.input)
                .then(success, error)
                .finally(function(){
                    $scope.loading = false;
                    $scope.input = {};
                });
        };
    }]);