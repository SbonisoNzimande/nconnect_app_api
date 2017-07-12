app.factory('DashboardService',
	['Base64', '$http', '$cookieStore', '$rootScope', '$timeout',
	function (Base64, $http, $cookieStore, $rootScope, $timeout) {

		
		var service = {
		 
			

			create_person: function(param) {
			// default post header
			$http.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
			var promise = $http({
					method: 'POST',
					url: $rootScope.api_url + 'PeopleManagement/CreatePerson',
					data: $.param(param),
					headers: {'Content-Type': 'application/x-www-form-urlencoded'}
				}).success(function (data, status, headers, config) {
					// handle success things
					console.log(data);
					return data;
				}).error(function (data, status, headers, config) {
					// handle error things
					console.log(data);
					return data;
				});
				return promise;
			},

		  



		  };


		  return service;

}])