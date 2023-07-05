<?php

/**
 * Proxy class
 */
namespace wstyepaf\Includes\Classes;
#[AllowDynamicProperties]
class Ep_Ajax_Filter_Proxy {
	/**
	 * Magic Method Get
	 *
	 * @param	string	$key
	 */
	public function &__get(string $key):mixed {
		if (property_exists($this, $key)) {
			return $this->registry->get($key);
		} else {
			throw new \Exception('Error: Could not call proxy key ' . $key . '!');
		}
	}

	/**
	 * Magic Method Set
	 *
	 * @param	string	$key
	 * @param	string	$value
	 */
	public function __set(string $key, object $value): void {
		$this->{$key} = $value;
	}

	public function __call(string $method, array $args) {
		// Hack for pass-by-reference
		foreach ($args as $key => &$value);

		if (isset($this->{$method})) {
			return call_user_func_array($this->{$method}, $args);
		} else {
			$trace = debug_backtrace();

			throw new \Exception('<b>Notice</b>:  Undefined property: Proxy::' . $method . ' in <b>' . $trace[0]['file'] . '</b> on line <b>' . $trace[0]['line'] . '</b>');
		}
	}
}


