<?php

/*
 * WebSiteToYou License
 * Each line should be prefixed with  * 
 */

namespace wstyepaf\Includes\Classes;

class Ep_Ajax_Filter_Loadingcontroller {

    public $registry;
    public $route;
    public $class;
    public $file;
    public $method;

    public function __construct(\wstyepaf\Includes\Classes\EpRegistry $registry) {
        $this->registry = $registry;
    }

    public function Ep_Ajax_Filter_loadingController($route) {

        // $this->file = $route . strtolower(substr($route, strrpos($route, '/') + 1));

        $route = preg_replace('/[^a-zA-Z0-9_|\/]/', '', $route);

        $this->route = preg_replace('/[^a-zA-Z0-9_|\/]/', '', $route);

        if (isset($_GET['page'])) {

            $this->class = str_replace(['_', '/'], ['', '\\'], ucwords($this->route, '_/'));
            $this->method = 'index';
        } else {
            //If need other 
            $this->class = str_replace(['_', '/'], ['', '\\'], ucwords($this->route, '_/'));
            $this->method = $_GET['page'];
        }

        return $this->Ep_Ajax_Filter_execute($this->registry);
    }

    public function Ep_Ajax_Filter_loadingModel($route) {

        // Sanitize the call
        $route = preg_replace('/[^a-zA-Z0-9_\/]/', '', $route);
        $this->route = preg_replace('/[^a-zA-Z0-9_|\/]/', '', $route);
        $this->class = str_replace(['_', '/'], ['', '\\'], ucwords($this->route, '_/'));

        // Check if the requested model is already stored in the registry.
        if (!$this->registry->has('model_' . str_replace('/', '_', $route))) {
            // Converting a route path to a class name
            $class = 'Includes\\Models\\' . str_replace(['_', '/'], ['', '\\'], ucwords($route, '_/'));

            $file = EP_PLUGIN_DIR . 'includes/models/' . trim(str_replace('\\', '/', strtolower(substr($this->route, strlen(''))))) . '.php';

            if (isset($file) && is_file($file)) {



                require($file);

                // return true;
            } else {

                //return false;
            }


            $class = '\wstyepaf\Includes\Models' . '\\' . $this->class;

            $model = new $class($this->registry);

            //print_r($model->testmodel());

            if (class_exists($class)) {




                $proxy = new \wstyepaf\Includes\Classes\Ep_Ajax_Filter_Proxy();

                // Overriding models is a little harder so we have to use PHP's magic methods.
                foreach (get_class_methods($class) as $method) {

                    if ((substr($method, 0, 2) != '__') && is_callable($class, $method)) {
                        $proxy->{$method} = $this->callback($route . '/' . $method);
                    }
                }

                $this->registry->set('model_' . str_replace('/', '_', $route), $proxy);
            } else {
                throw new \Exception('Error: Could not load model ' . $class . '!');
            }
        }
    }

    public function Ep_Ajax_Filter_execute($registry, array &$args = []) {

        //print_r($this->class);
        // print_r($registry->loading->view('controller/add_admin_page'));
        // Stop any magical methods being called
        if (substr($this->method, 0, 2) == '__') {
            return new \Exception('Error: Calls to magic methods are not allowed!');
        }
        // Get the current namespace being used by the config
        $class = 'Includes' . '\\' . $this->class;

        $file = EP_PLUGIN_DIR . 'includes/' . trim(str_replace('\\', '/', strtolower(substr($this->route, strlen(''))))) . '.php';

        if (isset($file) && is_file($file)) {


            require($file);

            // return true;
        } else {

            //return false;
        }
        $args[]['registry'] = $this->registry;

        $class = '\wstyepaf\Includes' . '\\' . $this->class;

        $controller = new $class($registry);

        return call_user_func_array([$controller, $this->method], $args);
    }

    protected function Ep_Ajax_Filter_callback(string $route): callable {


        if (phpversion() < 8):
            return function (&...$args) use ($route) {
                // Grab args using function because we don't know the number of args being passed.
                // https://www.php.net/manual/en/functions.arguments.php#functions.variable-arg-list
                // https://wiki.php.net/rfc/variadics
                $route = preg_replace('/[^a-zA-Z0-9_\/]/', '', $route);

                // Keep the original trigger
                $trigger = $route;

                $event = new \wstyepaf\Includes\Classes\Ep_Ajax_Filter_Event($this->registry);

                // Trigger the pre events
                $result = $event->trigger('model/' . $trigger . '/before', [&$route, &$args]);

                if ($result) {
                    $output = $result;
                } else {
                    // Create a key to store the model object
                    $key = substr($route, 0, strrpos($route, '/'));

                    // Check if the model has already been initialised or not
                    if (!$this->registry->has($key)) {
                        // Create the class name from the key

                        $class = '\wstyepaf\Includes\Models\\' . str_replace(['_', '/'], ['', '\\'], ucwords($key, '_/'));

                        $model = new $class($this->registry);

                        $this->registry->set($key, $model);
                    } else {
                        $model = $this->registry->get($key);
                    }

                    // Get the method to be used
                    $method = substr($route, strrpos($route, '/') + 1);

                    $callable = [$model, $method];

                    if (is_callable($callable)) {
                        $output = call_user_func_array($callable, $args);
                    } else {
                        throw new \Exception('Error: Could not call model/' . $route . '!');
                    }
                }

                // Trigger the post events
                $result = $event->trigger('model/' . $trigger . '/after', [&$route, &$args, &$output]);

                if ($result) {
                    $output = $result;
                }

                return $output;
            };
        else:
            return function (mixed &...$args) use ($route) {
                // Grab args using function because we don't know the number of args being passed.
                // https://www.php.net/manual/en/functions.arguments.php#functions.variable-arg-list
                // https://wiki.php.net/rfc/variadics
                $route = preg_replace('/[^a-zA-Z0-9_\/]/', '', $route);

                // Keep the original trigger
                $trigger = $route;

                $event = new \wstyepaf\Includes\Classes\Ep_Ajax_Filter_Event($this->registry);

                // Trigger the pre events
                $result = $event->trigger('model/' . $trigger . '/before', [&$route, &$args]);

                if ($result) {
                    $output = $result;
                } else {
                    // Create a key to store the model object
                    $key = substr($route, 0, strrpos($route, '/'));

                    // Check if the model has already been initialised or not
                    if (!$this->registry->has($key)) {
                        // Create the class name from the key

                        $class = '\wstyepaf\Includes\Models\\' . str_replace(['_', '/'], ['', '\\'], ucwords($key, '_/'));

                        $model = new $class($this->registry);

                        $this->registry->set($key, $model);
                    } else {
                        $model = $this->registry->get($key);
                    }

                    // Get the method to be used
                    $method = substr($route, strrpos($route, '/') + 1);

                    $callable = [$model, $method];

                    if (is_callable($callable)) {
                        $output = call_user_func_array($callable, $args);
                    } else {
                        throw new \Exception('Error: Could not call model/' . $route . '!');
                    }
                }

                // Trigger the post events
                $result = $event->trigger('model/' . $trigger . '/after', [&$route, &$args, &$output]);

                if ($result) {
                    $output = $result;
                }

                return $output;
            };
        endif;
    }

}
