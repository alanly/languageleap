(function() {

	var app = angular.module('adminApp');

	/**
	 * A generic confirmation dialog.
	 * Use the following attributes:
	 * ng-confirm-message="Are you sure?"
	 * ng-confirm-click="onConfirm()"
	 */
	app.directive('ngConfirmClick', [function() {
		return {
			restrict: 'A',
			link: function(scope, element, attrs) {
				element.bind('click', function() {
					var message = attrs.ngConfirmMessage;
					if (message && confirm(message)) {
						scope.$apply(attrs.ngConfirmClick);
					}
				});
			}
		}
	}]);

})();