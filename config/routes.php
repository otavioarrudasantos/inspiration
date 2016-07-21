<?php

define(CONTROLLERS_NAMESPACE, 'Xosq\\Application\\Controller\\');

/*
	'route/:id' => [
		'GET' => 'controller:method'
		'POST' => 'controller:method'
		'PUT' => 'controller:method'
		'DELETE' => 'controller:method'
	]
 */
return array(
	'/customer' => [
		'GET' => CONTROLLERS_NAMESPACE . 'CustomerController:findAll',
		'POST' => CONTROLLERS_NAMESPACE . 'CustomerController:post',
	],

	'/customer/:id' => [
		'GET' => CONTROLLERS_NAMESPACE . 'CustomerController:findById',
		'PUT' => CONTROLLERS_NAMESPACE . 'CustomerController:put',
		'DELETE' => CONTROLLERS_NAMESPACE . 'CustomerController:delete',
	],

	'/customer/:id/product' => [
		'GET' => CONTROLLERS_NAMESPACE . 'CustomerController:getCustomerProducts',
		'POST' => CONTROLLERS_NAMESPACE . 'CustomerController:put',
	]
);