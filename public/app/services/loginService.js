app.factory('LoginService',
	['Base64', '$http', '$cookieStore', '$rootScope', '$timeout',
	function (Base64, $http, $cookieStore, $rootScope, $timeout) {

		
		var service = {
		 
			

			check_login: function(param) {
			// default post header
			$http.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
			var promise = $http({
					method: 'POST',
					url: $rootScope.api_url + 'Login/LoginUser',
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

		  register_new_user: function(param) {
			// default post header
			$http.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
			var promise = $http({
					method: 'POST',
					url: $rootScope.api_url + 'Login/RegisterUser',
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