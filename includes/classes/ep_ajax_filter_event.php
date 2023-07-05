<?php
/**
* Event class
*
* Event System
* 
* https://github.com/opencart/opencart/wiki/Events-(script-notifications)-2.2.x.x
*/
namespace wstyepaf\Includes\Classes;
class Ep_Ajax_Filter_Event {
	protected $registry;
	protected array $data = [];
	
	/**
	 * Constructor
	 *
	 * @param	object	$route
 	*/
	public function __construct(\wstyepaf\Includes\Classes\EpRegistry $registry) {
		$this->registry = $registry;
	}
	
	/**
	 * 
	 *
	 * @param	string	$trigger
	 * @param	object	$action
	 * @param	int		$priority
 	*/	
	public function register(string $trigger, \wstyepaf\System\Library\Action $action, int $priority = 0): void {
		$this->data[] = [
			'trigger'  => $trigger,
			'action'   => $action,
			'priority' => $priority
		];
		
		$sort_order = [];

		foreach ($this->data as $key => $value) {
			$sort_order[$key] = $value['priority'];
		}

		array_multisort($sort_order, SORT_ASC, $this->data);	
	}
	
	/**
	 * 
	 *
	 * @param	string	$event
	 * @param	array	$args
 	*/		
	public function trigger(string $event, array $args = []){
		foreach ($this->data as $value) {
			if (preg_match('/^' . str_replace(['\*', '\?'], ['.*', '.'], preg_quote($value['trigger'], '/')) . '/', $event)) {
				$result = $value['action']->Ep_Ajax_Filter_execute($this->registry, $args);

				if (!is_null($result) && !($result instanceof \Exception)) {
					return $result;
				}
			}
		}

		return '';
	}
	
	/**
	 * 
	 *
	 * @param	string	$trigger
	 * @param	string	$route
 	*/	
	public function unregister(string $trigger, string $route): void {
		foreach ($this->data as $key => $value) {
			if ($trigger == $value['trigger'] && $value['action']->getId() == $route) {
				unset($this->data[$key]);
			}
		}			
	}
	
	/**
	 * 
	 *
	 * @param	string	$trigger
 	*/		
	public function clear(string $trigger): void {
		foreach ($this->data as $key => $value) {
			if ($trigger == $value['trigger']) {
				unset($this->data[$key]);
			}
		}
	}	
}
