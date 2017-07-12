app.controller('MainCtrl',
	['$state', '$scope', '$rootScope', '$http', '$window', '$log', '$location', '$stateParams', '$timeout', 'promiseTracker', 'DashboardService', 
	function ($state, $scope, $rootScope, $http, $window, $log, $location,  $stateParams, $timeout, promiseTracker, DashboardService) {

		
		$scope.SubmitCreateForm = function(isValid) {
			if (isValid) {
				var param = {
					'first_name': $scope.first_name, 
					'last_name': $scope.last_name, 
					'language': $scope.language, 
					'dob': $scope.dob, 
					'mobile': $scope.mobile, 
					'email': $scope.email
				};

				console.log(param)

				$scope.create_error = false;
				$scope.create_success = false;
				$scope.create_text = '';

				DashboardService.create_person (param).then(function(d) {
					var responce = d.data
					console.log(responce);

					if (responce.status == true) {
						console.log('data saved');
						$scope.create_error 	= false;
						$scope.create_success 	= true;

						$scope.create_text = responce.text;


						// $timeout(function() {
						// 	$window.location.href = responce.redirect_to;
						// }, 1000);
					}else{
						$scope.create_error 	= responce.text;
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