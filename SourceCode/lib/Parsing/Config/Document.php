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
     * @subpackage     Parsing::Config
     * @link           www.pdomap.net
     * @since          2.*
     * @version        $Revision$
     */
    
    /**
     * Parse xml file
     */          
    class pdoMap_Parsing_Config_Document extends pdoMap_Core_XML_Document {
        /**
         * Loads and read a xml mapping file
         */                 
        public function __construct($file) {
            $this->hasMany(
                array(
                    'add', 'adapter', 'require'
                )
            );
            parent::__construct(
                $file, 
                pdoMap::$rootPath.'Parsing/Config/Structure.xsd'
            );
        }
        /**
         * Returns an configuration array
         */                 
        public function getArray() {
            $ret = array(
                'connections' => array(), 
                'mapping' => array(),
                'root' => './'
            );
            // READ CONNECTION ARRAY
            if (isset($this->connections) && isset($this->connections->add)) {
                foreach($this->connections->add as $cnx) {
                    if (isset($cnx->key)) {
                        $key = $cnx->key;
                    } else $key = '*';
                    $ret['connections'][$key] = array(
                        'dns' => $cnx->dns,
                        'user' => $cnx->user,
                        'pwd' => $cnx->pwd,
                        'prefix' => $cnx->prefix
                    );
                }
            }
            // READ MAPPING ARRAY
            if (isset($this->mapping) && isset($this->mapping->adapter)) {
                if (isset($this->mapping->root)) {
                    $ret['root'] = $this->mapping->root;
                }
                foreach($this->mapping->adapter as $adapter) { 
                    if (isset($adapter->meta)) {
                        $meta = $adapter->meta;
                    } else $meta = $adapter->name.'.map.xml';
                    $ret['mapping'][$adapter->name] = array(
                        'path' => $adapter->path,
                        'meta' => $meta,
                        'require' => array()
                    );
                    if (isset($adapter->require)) {
                        $ret['mapping'][$adapter->name]['require'] = $adapter->require;
                    }
                }
            }            
            // Return result
            return $ret;
        }
        /**
         * Instanciate an object
         */                 
        public function getObject() {
            return new pdoMap_Parsing_Config_Cache($this->getArray(), $this->__file);
        }
    }
    
?>