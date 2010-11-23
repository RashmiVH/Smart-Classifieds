<?php

    /*
     *  $Id$
     *
     * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
     * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
     * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
     * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
     * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
     * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
     * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
     * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
     * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
     * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
     * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
     *
     * This software consists of voluntary contributions made by many individuals
     * and is licensed under the LGPL. For more information, see
     * <http://www.pdomap.net>.
     */    

    /**
     * @author         Ioan CHIRIAC <i dot chiriac at yahoo dot com>
     * @license        http://www.opensource.org/licenses/lgpl-2.1.php LGPL
     * @package        pdoMap
     * @subpackage     Core
     * @link           www.pdomap.net
     * @since          2.*
     * @version        $Revision$
     */
         
    /**
     * pdoMap Main Manager
     */              
    abstract class pdoMap {
        /**
         * @var string Root path (the pdoMap root)
         */               
        public static $rootPath;
        /**
         * @var string Caching path (must be secured - contains sensitive data) 
         * If path is in web folder (it's not recomended) you must create
         * a .htaccess file with this content :
         * <code>
         * Order Allow,Deny
         * Allow from None
         * Deny from All                           
         * </code>
         */               
        public static $cachePath;        
        /**
         * @var pdoMap_Core_Config    Main configuration
         */                 
        private static $coreConfig;
        /**
         * @var pdoMap_Parsing_Config_Document    Mapping configuration
         */                 
        private static $config;        
        /**
         * @var pdoMap_Cache_Manager  Cache manager instance
         */                 
        private static $cache;    
        /**
         * @var pdoMap_Database_Manager   Database manager instance         
         */                 
        private static $database;        
        /**
         * @var pdoMap_Database_Request_Manager   Request manager instance         
         */                 
        private static $request;
        /**
         * @var pdoMap_Database_Field Field manager instance
         */                 
        private static $field;
        /**
         * @var array Mapping structure buffer
         */                 
        private static $structures = array();
        /**
         * @var array Mapping services buffer
         */                 
        private static $services = array();                    
        /**
         * Get the cache manager
         * @return pdoMap_Cache_Manager         
         */
        public static function cache() {
            if (!self::$cache) {
                self::$cache = new pdoMap_Cache_Manager();
            }
            return self::$cache;
        }    
        /**
         * Get the field manager
         */                     
        public static function field() {
            if (!self::$field) {
                self::$field = new pdoMap_Database_Field();
            }
            return self::$field;
        }                 
        /**
         * Get framework configuration instance
         * @returns pdoMap_Core_Config     
         */                 
        public static function coreConfig() {
            if (!self::$coreConfig) {
                self::$coreConfig = new pdoMap_Core_Config();        
            }
            return self::$coreConfig;
        }
        /**
         * Get the database manager
         */                 
        public static function database() {
            if (!self::$database) {
                self::$database = new pdoMap_Database_Manager(); 
            }
            return self::$database;
        }
        /**
         * Get the request manager
         */                 
        public static function request($type = null) {
            if (!self::$request) {
                self::$request = new pdoMap_Database_Request_Manager(); 
            }
            if (!$type) {
                return self::$request;        
            } else return self::$request->get($type);
        }        
        /**
         * Get framework configuration instance
         * @returns pdoMap_Core_Config     
         */                 
        public static function config($file = null) {
            if (!is_null($file)) {
                $time = time() - filemtime($file);
                if (!self::cache()->check('config-'.$file, $time)) {
                    $conf = new pdoMap_Parsing_Config_Document($file);
                    self::cache()->clear();        
                    self::cache()->set('config-'.$file, $conf->getObject());
                }
                self::$config = self::cache()->get('config-'.$file);
                if (!self::$config) {
                    throw new pdoMap_Exceptions_ConfigurationUndefined();
                }            
                // WAKEUP SERVICES
                foreach(self::$config->getMappingKeys() as $key) {
                    self::get($key); // initialize service
                }                
            } elseif (!self::$config) {
                throw new pdoMap_Exceptions_ConfigurationUndefined();
            }
            return self::$config;
        }        
        /**
         * Get a mapping structure instance
         * @params string Mapping type     
         */                 
        public static function structure($type) {
            if (!isset(self::$structures[$type])) {
                $xml = self::config()->getMetaPath($type);
                $time = time() - filemtime($xml);
                if (!self::cache()->check('structure-'.$type, $time)) {
                    // REFRESH CACHE
                    $conf = new pdoMap_Parsing_Mapping_Document($xml);
                    try {                    
                        self::cache()->set(
                            'structure-'.$type, 
                            $conf->generate(
                                self::$cachePath.$type, $type
                            )
                        );                        
                    } catch(Exception $ex) {
                        $conf->close();
                        @unlink(self::$cachePath.$type.'.structure.php');
                        @unlink(self::$cachePath.$type.'.class.php');
                        throw new Exception(
                            'Unable to parse '.$type.' : '.
                            $ex
                        );                    
                    }
                }    
                self::$structures[$type] = self::cache()->get('structure-'.$type);
            }
            return self::$structures[$type];
        }
        /**
         * Initialize mapping class files
         * @throw pdoMap_Exceptions_MappingNotFound
         */
        public static function using($type) {
            // REQUIRE GEN FILE
            $file = self::$cachePath.$type.'.class.php';
            if (!file_exists($file)) {
                self::structure($type);
            }
            if (file_exists($file)) {
                require_once($file);
            } else throw new pdoMap_Exceptions_MappingNotFound($type, $file);
            // REQUIRE EXTENSION FILES (IF NEED)
            self::config()->RunRequires($type);            
        }                 
        /**
         * Get an adapter instance (singleton version)
         * Use static call directly for php 5.3 versions
         * @params string Binded table name           
         * @returns pdoMap_Mapping_IAdapter 
         */                 
        public static function get($type) {
            if (!isset(self::$services[$type])) {
                self::using($type);                            
                if (!pdoMap::cache()->hasService($type)) {
                    $interface = self::structure($type)->service;
                    $classes = get_declared_classes();
                    foreach($classes as $namespace) {
                        $reflexion = new ReflectionClass($namespace);
                        if (!$reflexion->isAbstract() && 
                                !$reflexion->isInterface() && 
                                $reflexion->implementsInterface($interface)) {
                            if (!pdoMap::cache()->hasService($type)) {
                                pdoMap::cache()->setService($type, $reflexion->newInstance());
                            } else {
                                throw new pdoMap_Exceptions_ServiceDuplicated(
                                    $type, $interface, pdoMap::cache()->getService($type), $namespace);
                            }
                        }
                    }
                }         
                self::$services[$type] = pdoMap::cache()->getService($type);       
                if (!self::$services[$type]) 
                    throw new pdoMap_Exceptions_ServiceNotFound($type);                
            }
            return self::$services[$type];        
        }
        /**
         * Get an adapter instance
         * @returns pdoMap_Mapping_IAdapter                  
         */                 
        public final static function __callStatic($type, $args = null) {
            return self::get($type);
        }
        /**
         * Autoload the framework classes 
         * @params string Class name
         * @returns mixed         
         */                 
        public static function autoload($class) {
            if (substr($class, 0, 7) == 'pdoMap_') { // works only for pdoMap framework
                return require_once(
                    pdoMap::$rootPath
                    .str_replace(
                        '_', 
                        '/', 
                        substr(
                            $class, 
                            7
                        )
                    )
                    .'.php'
                );
            } elseif (substr($class, -11) == 'AdapterImpl') {  // handles also generated classes
                self::get(strtolower(substr($class, 0, strlen($class) - 11)));
                if (!class_exists($class)) {
                    throw new pdoMap_Exceptions_ClassNotFound($class);
                }
                return true;
            } else return false; // ignore others classes
        }
    }
    
    /**
     * Defines pdoMap root directory
     */         
    pdoMap::$rootPath = dirname(__FILE__).'/';
        
    /**
     * Defines default pdoMap directories
     */         
    pdoMap::$cachePath         = pdoMap::$rootPath.'cache/tmp/';
        
    /** 
     * Registers pdoMap Autoload Manager 
     */
    spl_autoload_register(array('pdoMap', 'autoload'));
    
    /**
     * Fix for php 5.2
     */         
    if(!function_exists('get_called_class')) {
        function get_called_class($bt = false,$l = 1) {
            if (!$bt) $bt = debug_backtrace();
            if (!isset($bt[$l])) throw new Exception("Cannot find called class -> stack level too deep.");
            if (!isset($bt[$l]['type'])) {
                throw new Exception ('type not set');
            } else switch ($bt[$l]['type']) {
                case '::':
                    $lines = file($bt[$l]['file']);
                    $i = 0;
                    $callerLine = '';
                    do {
                        $i++;
                        $callerLine = $lines[$bt[$l]['line']-$i] . $callerLine;
                    } while (stripos($callerLine,$bt[$l]['function']) === false);
                    preg_match('/([a-zA-Z0-9\_]+)::'.$bt[$l]['function'].'/',
                                $callerLine,
                                $matches);
                    if (!isset($matches[1])) {
                        // must be an edge case.
                        throw new Exception ("Could not find caller class: originating method call is obscured.");
                    }
                    switch ($matches[1]) {
                        case 'self':
                        case 'parent':
                            return get_called_class($bt,$l+1);
                        default:
                            return $matches[1];
                    }
                    // won't get here.
                case '->': switch ($bt[$l]['function']) {
                        case '__get':
                            // edge case -> get class of calling object
                            if (!is_object($bt[$l]['object'])) throw new Exception ("Edge case fail. __get called on non object.");
                            return get_class($bt[$l]['object']);
                        default: return $bt[$l]['class'];
                    }
        
                default: throw new Exception ("Unknown backtrace method type");
            }
        }
    }    