<?php

namespace wstyepaf\Includes\Classes;
class EpRegistry {
	private array $data = [];

	/**
	 * __get
	 *
	 * https://www.php.net/manual/en/language.oop5.overloading.php#object.get
	 *
	 * @param    string $key
	 *
	 * @return   object
	 */
	public function __get(string $key): object {
		return $this->get($key);
	}

	/**
	 * __set
	 *
	 * https://www.php.net/manual/en/language.oop5.overloading.php#object.set
	 *
	 * @param    string $key
	 * @param    object $value
	 *
	 * @return    object
	 */
	public function __set(string $key, object $value): void {
		$this->set($key, $value);
	}
	/**
     * Get
     *
     * @param	string	$key
	 * 
	 * @return	mixed
     */
	public function get(string $key): object {
		return isset($this->data[$key]) ? $this->data[$key] : null;
	}

    /**
     * Set
     *
     * @param	string	$key
	 * @param	string	$value
     */	
	public function set(string $key, object $value): void {
		$this->data[$key] = $value;
	}
	
    /**
     * Has
     *
     * @param	string	$key
	 *
	 * @return	bool
     */
	public function has(string $key): bool {
		return isset($this->data[$key]);
	}

	/**
	 * Unset
	 *
	 * Unsets registry value by key.
	 *
	 * @param	string	$key
	 *
	 * @return	void
	 */
	public function unset(string $key): void {
		if (isset($this->data[$key])) {
			unset($this->data[$key]);
		}
	}
}
