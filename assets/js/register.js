$(document).ready(function() {
	$("#hideLogin").click(function() {
		$("#loginForm").hide();
		$("#registerForm").fadeIn();
	});

	$("#hideRegister").click(function() {
		$("#loginForm").fadeIn();
		$("#registerForm").hide();
	});
});