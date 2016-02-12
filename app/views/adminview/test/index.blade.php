
<!DOCTYPE html>
<html lang="en" xmlns:ng="http://angularjs.org">
<head>
	<meta charset=utf-8 />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

	<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.12/angular.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.12/angular-route.min.js"></script>
	<script src="https://raw.githack.com/begriffs/angular-paginate-anything/master/dist/paginate-anything-tpls.js"></script>
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" />
	<style>
		ul.pagination, div.per-page {
			display: inline-block;
			vertical-align: middle;
		}
		div.per-page {
			margin-left: 1em;
		}
		ul.pagination > li a {
			display: inline-block;
			min-width: 3em;
			text-align: center;
		}
	</style>

	<title>Demo angular-paginate-anything</title>
</head>
<body class="container" ng-app="demoapp" ng-controller="DemoController">

	<h4 class="row text-center" ng-hide="words">
		Loading...
	</h4>

	<div class="row">
		<bgf-pagination
		page="page"
		per-page="perPage"
		client-limit="clientLimit"
		url="url"
		url-params = 'urlParams'
		link-group-size="2"
		collection="words">
	</bgf-pagination>

	<ul>
		<li ng-repeat="ww in words">[[ ww ]]</li>
	</ul>
	<bgf-pagination
	passive="true"
	page="page"
	per-page="perPage"
	client-limit="clientLimit"
	url="url"
	url-params = 'urlParams'
	link-group-size="2"
	collection="words">
</bgf-pagination>
</div>

</body>
<script>
	angular.module("demoapp", ['bgf.paginateAnything', 'ngRoute'], function($interpolateProvider)
	{
		$interpolateProvider.startSymbol('[[');
		$interpolateProvider.endSymbol(']]');
	})
	.config(function($locationProvider) {
		$locationProvider.html5Mode(true);
	})
	.controller("DemoController", function($scope, $location) {
		$scope.url = '/adminsite/customer/ajax';
		$scope.urlParams = {
			query : ''
		}
		$scope.perPage = parseInt($location.search().perPage, 10) || 5;
		$scope.page = parseInt($location.search().page, 10) || 0;
		$scope.clientLimit = 250;

		$scope.$watch('page', function(page) { $location.search('page', page); });
		$scope.$watch('perPage', function(page) { $location.search('perPage', page); });
		$scope.$on('$locationChangeSuccess', function() {
			var page = +$location.search().page,
			perPage = +$location.search().perPage;
			if(page >= 0) { $scope.page = page; };
			if(perPage >= 0) { $scope.perPage = perPage; };
		});
	});
</script>
</html>
