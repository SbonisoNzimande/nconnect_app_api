app.controller('LoginCtrl',
	['$state', '$scope', '$rootScope', '$http', '$window', '$log', '$location', '$stateParams', '$timeout', 'promiseTracker', 'LoginService', 
	function ($state, $scope, $rootScope, $http, $window, $log, $location,  $stateParams, $timeout, promiseTracker, LoginService) {

		
		$scope.SubmitLoginForm = function(isValid) {
			if (isValid) {
				var param = {
					'username': $scope.username, 
					'password': $scope.password
				};

				$scope.login_error = false;
				$scope.login_success = false;

				LoginService.check_login (param).then(function(d) {
					var responce = d.data
					console.log(responce);

					if (responce.status == true) {
						console.log('data saved');
						$scope.login_error 	= false;
						$scope.login_success = true;

						$timeout(function() {
							$window.location.href = responce.redirect_to;
						}, 1000);
					}else{
						$scope.login_error 	= responce.text;
					}
				});


			}
		}

		$scope.SubmitRegisterForm = function(isValid) {

			// check to make sure the form is completely valid
			if (isValid) {
				var param = {
					'Username': $scope.Username, 
					'Email': $scope.Email,
					'Password': $scope.Password,
					'Password2': $scope.Password2
				};

				$scope.registration_error = false;
				$scope.registration_success = false;

				LoginService.register_new_user (param).then(function(d) {
					var responce = d.data
					console.log(responce);

					if (responce.status == true) {
						console.log('data saved');
						$scope.registration_error 	= false;
						$scope.registration_success = true;

						$timeout(function() {
							$state.go('signin');
						}, 1000);
					}else{
						$scope.registration_error 	= responce.text;
					}
				});


			}

		};
}])