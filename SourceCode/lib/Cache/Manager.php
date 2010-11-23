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
     * @subpackage     Cache
     * @link           www.pdomap.net
     * @since          2.*
     * @version        $Revision$
     */
    
    /**
     * Cache manager
     */         
    class pdoMap_Cache_Manager
        extends pdoMap_Cache_Manager_Event
    {
        /**
         * List of services
         */                 
        private $services = array();
        /**
         * List of entities
         */                 
        private $entities = array();        
        /**
         * @var pdoMap_Cache_IAdapter 
         */                 
        private $proxy;
        /**
         * Get the cache manager instance
         */                 
        public function proxy() {
            if (!$this->proxy) {
                // INITIALIZE CACHE MANAGER
                if (pdoMap::coreConfig()->cacheAdapter == null) {
                    pdoMap::coreConfig()->cacheAdapter = pdoMap::coreConfig()->cacheAdapters[0];
                } 
                $class = 'pdoMap_Cache_Adapters_'.pdoMap::coreConfig()->cacheAdapter;
                $this->proxy = new $class();
                $this->proxy->openSession();
                $this->raise('OpenSession');
            }
            return $this->proxy;
        }
        
        #region Proxy Calls
        public function check($key, $timeout = 0) { 
            $this->raise('Check', new pdoMap_Cache_Manager_Args($key));
            return $this->proxy()->check($key, $timeout); 
        }
        public function get($key) { 
            $this->raise('Get', new pdoMap_Cache_Manager_Args($key));            
            return $this->proxy()->get($key); 
        }
        public function set($key, &$value) { 
            $this->raise('Set', new pdoMap_Cache_Manager_Args($key));            
            return $this->proxy()->set($key, $value); 
        }
        public function remove($key) { 
            $this->raise('Remove', new pdoMap_Cache_Manager_Args($key));            
            return $this->proxy()->remove($key); 
        }
        public function clear() { 
            $this->raise('Clear');
            return $this->proxy()->clear(); 
        }
        #endregion
        
        #region Services cache
        public function hasService($name) {
            if (isset($this->services[$name])) {
                return true;
            } else return $this->check('service-'.$name);
        }
        public function getService($name) {
            if (!isset($this->services[$name])) {
                $this->services[$name] = $this->get('service-'.$name);
            } 
            return $this->services[$name];
        }
        public function setService($name, $service) {
            $this->services[$name] = $service;
        }
        public function removeService($name) {
            unset($this->services[$name]);
            return $this->remove('service-'.$name);
        }
        #endregion
        #region Entities cache (as singletons)
        /**
         * Verify if an entity is in cache
         */                 
        public function hasEntity($type, $id) {
            return (isset($this->entities[$type][$id]));
        }
        /**
         * Get an entity from cache
         */                 
        public function getEntity($type, $id) {
            if ($this->hasEntity($type, $id)) {
                return $this->entities[$type][$id];
            } else throw new Exception('Entity not found '.$type.' - '.$id);
        }
        /**
         * Set an entity to cache
         */                 
        public function setEntity(pdoMap_Mapping_Entity &$entity) {
            if (!isset($this->entities[$entity->getType()])) {
                $this->entities[$entity->getType()] = array();
            }
            $this->entities[$entity->getType()][$entity->getPk()] = $entity;
        }
        /**
         * Remove an entity from cache
         */                 
        public function removeEntity(pdoMap_Mapping_Entity $entity) {
            if ($this->hasEntity($entity->getType(), $entity->getPk())) {
                unset($this->entities[$entity->getType()][$entity->getPk()]);
            } else throw new Exception('Entity not found '.$type.' - '.$id);
        }
        #endregion
        
        /**
         * Closing cache session
         */                 
        public function closeSession() {
            if ($this->proxy) {
                foreach($this->services as $name => $service) {
                    $service->detachAll();
                    $this->set('service-'.$name, $service);
                }
                $this->proxy()->closeSession();
                $this->raise('CloseSession');
                $this->proxy = null;
            }
        }
    }