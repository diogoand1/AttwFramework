<?php  
    /**
     * Permission is hereby granted, free of charge, to any person obtaining a copy
     * of this software and associated documentation files (the "Software"), to deal
     * in the Software without restriction, including without limitation the rights
     * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
     * copies of the Software, and to permit persons to whom the Software is
     * furnished to do so, subject to the following conditions:
     * 
     * The above copyright notice and this permission notice shall be included in
     * all copies or substantial portions of the Software.
     * 
     * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
     * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
     * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
     * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
     * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
     * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
     * THE SOFTWARE.
    */

    /**
     * @package AttwFramework
     * @author Gabriel Jacinto <gamjj74@hotmail.com>
     * @license https://github.com/AttwFramework/AttwFramework/blob/master/LICENSE.md
     * @since AttwFramework v1.0
    */
 
    namespace Attw\Router;

    use Attw\Router\RouterException;

    /**
     * Router manager
    */
    class RoutingManager{
        /**
         * Routes registred
         *
         * @var array
        */
        private static $routes;
        
        /**
         * Current controller
         *
         * @var string
        */
        private static $controller;

        /**
         * Current controller's action
         *
         * @var string
        */
        private static $action;

        /**
         * Current Get params
         *
         * @var array
        */
        private static $params;
        
        /**
         * Create a new route
         *
         * @param string | array $params Get params
         * @param array $controllerAndAction
         * @throws Attw\Router\Exception\RouterException case is not defined the controller and action
         * @throws Attw\Router\Exception\RouterException case is indicate an invalid controller
         * @throws Attw\Router\Exception\RouterException case is indicate an invalid action
        */
        public static function setRoute( $params, array $controllerAndAction ){
            if( !isset( $controllerAndAction['controller'], $controllerAndAction['action'] ) ){
                throw new RouterException( 'Indicate a controller and a action to the route' );
            }

            $controller = $controllerAndAction['controller'];
            $action = $controllerAndAction['action'];

            if( is_array( $controller ) ){
                if( count( $controller ) >= 1 ){
                    $controllerArrReverse = array_reverse( $controller );

                    for( $i = 0; $i < count( $controller ) - 1; $i++ ){
                        array_shift( $controllerArrReverse );
                    }

                    foreach( $controllerArrReverse as $key => $value ){
                        $controllerArrReverse[ strtolower( $key ) ] = $value;
                    }

                    $controllerR = $controllerArrReverse;
                }else{
                    throw new RouterException( 'Define a valid controller' );
                }
            }else{
                $controllerR[ strtolower( $controller ) ] = $controller;
            }

            if( is_array( $action ) ){
                if( count( $action ) >= 1 ){
                    $actionArrReverse = array_reverse( $action );

                    for( $i = 0; $i < count( $action ) - 1; $i++ ){
                        array_shift( $actionArrReverse );
                    }

                    $actionR = $actionArrReverse;
                }else{
                    throw new RouterException( 'Define a valid action' );
                }
            }else{
                $actionR[ $action ] = $action;
            }

            $params = ( is_array( $params ) ) ? $params : explode( '/', $params );
            self::$routes[] = array( 'route' => $params, 'controller' => $controllerR, 'action' => $actionR );
        }
        
        /**
         * Get the current controller
         *
         * @return string
        */
        public static function getController(){
            return self::$controller;
        }
        
        /**
         * Get the current controller's action
         *
         * @return string
        */
        public static function getAction(){
            return self::$action;
        }
        
        /**
         * Get the current Get params
         *
         * @return array
        */
        public static function getParams(){
            return ( count( self::$params ) > 0 ) ? self::$params : array();
        }
        
        /**
         * Define the controller, the action and the params
         *
         * @param string $url URL to use
         * @param string $defaultController Default controller to application
         * @param string $defaultAction Default action to controllers
        */
        public static function setParams( $url, $defaultController, $defaultAction ){
            $params = explode( '/', $url );

            $cController = ( isset( $params[0] ) && $params[0] !== null && $params[0] !== '' ) ? $params[0] : $defaultController;
            $cAction = ( isset( $params[1] ) && $params[1] !== null && $params[1] !== '' ) ? $params[1] : $defaultAction;

            $cController = strtolower( $cController );
            $cAction = strtolower( $cAction );

            $validControllers = 0;
            $validActions = 0;

            if( count( self::$routes ) == 0 ){
                self::$controller = ucfirst( $cController );
                self::$action = $cAction;
            }else{
                foreach( self::$routes as $route ){ 
                    if( is_array( $route['controller'] ) ){
                        foreach( $route['controller'] as $key => $value ){
                            if( $key == $cController ){
                                self::$controller = ucfirst( $value );
                                $cControllerR = $key;
                                $validControllers++;
                            }
                        }
                    }

                    if( is_array( $route['action'] ) ){
                        foreach( $route['action'] as $key => $value ){
                            if( $key == $cAction ){
                                self::$action = $value;
                                $cActionR = $key;
                                $validActions++;
                            }
                        }
                    }

                    if( $validControllers > 0 && $validActions > 0 ){
                        if( isset( $cControllerR, $cActionR ) ){
                            if( $cController == $cControllerR && $cAction == $cActionR ){
                                $paramsSetted = $route['route'];
                        
                                if( count( $params ) === 1 || count( $params ) === 2 ){
                                    $paramsExists = false;
                                    self::$params = array();
                                }else{
                                    unset( $params[0], $params[1] );
                                    
                                    foreach( $params as $key => $value ){
                                        $params[ $key - 2 ] = $value;
                                        unset( $params[ $key ] );
                                    }
                                    
                                    if( count( $params ) > count( $paramsSetted ) ){
                                        foreach( $params as $key => $value ){
                                            if( $key + 1 > count( $paramsSetted ) ){
                                                unset( $params[ $key ] );
                                            }
                                        }
                                    }
                                    
                                    self::$params = array_combine( $paramsSetted, $params );
                                }
                            }
                        }
                    }else{
                        self::$controller = ucfirst( $cController );
                        self::$action = $cAction;
                    }
                }
            }
        }

        /**
         * Return the query strings from a URL
         *
         * @param string $url
         * @return array Queries
        */
        public static function getQueryStrings( $url ){
            $params = explode( '?', $url );

            if( count( $params ) > 1 ){
                $params = end( $params );
                $relations = explode( '&', $params );

                $queries = array();

                foreach( $relations as $relation ){
                    $camps = explode( '=', $relation );
                    $queries[ $camps[0] ] = $camps[1];
                }
            }else{
                $queries = array();
            }

            return $queries;
        }
    }