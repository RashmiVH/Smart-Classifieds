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
     * @subpackage     Cache::Adapters
     * @link           www.pdomap.net
     * @since          2.*
     * @version        $Revision$
     */

    /**
     * Cache Manager with apc 
     */         
    class pdoMap_Cache_Adapters_APC implements pdoMap_Cache_IAdapter {
        private $key = 'pdomap:';
        private $buffer = array();
        private $hash;
        public function openSession() {
            $this->hash = apc_fetch($this->key.'hash');
            if (!is_array($this->hash)) {
                $this->hash = array();
            }
        }
        public function closeSession() {
            apc_store($this->key.'hash', $this->hash);            
        }
        public function check($key, $timeout = 0) {
            if (!$timeout) {
                return isset($this->hash[$key]);            
            } else {
                if (isset($this->hash[$key])) {
                    return ($this->hash[$key] + $timeout > time());
                } else return false;        
            }
        }
        public function set($key, &$value) {
            $this->hash[$key] = time();
            $this->buffer[$key] = $value;
            apc_store($this->key.$key, $value);
        }
        public function get($key) {
            if (!isset($this->buffer[$key])) {
                $ok = false;
                $this->buffer[$key] = apc_fetch($this->key.$key, $ok);
                if (!$ok) {
                    throw new KeyNotFoundException($key);
                }
            } 
            return $this->buffer[$key];
        }
        public function remove($key) {
            if (isset($this->hash[$key])) {
                unset($this->hash[$key]);
                return apc_delete($this->key.$key);
            } else throw new KeyNotFoundException($key);
        }
        public function clear() {
            apc_clear_cache();
            $this->hash = array();
        }
    }