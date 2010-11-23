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
     * Cached configuration file
     */          
    class pdoMap_Parsing_Config_Cache {
        private $data;
        private $file;
        /**
         * Constructor
         * @params array Configuration data         
         */                 
        public function __construct($data, $file = null) {
            $this->data = $data;
            $this->file = $file;
            $this->__wakeup();
        }
        /**
         * Registering database connections
         */         
        public function __wakeup() {
            foreach($this->data['connections'] as $key => $cnx) {
                pdoMap::database()->Register($cnx['dns'], $cnx['user'], $cnx['pwd'], $cnx['prefix'], $key);
            }            
        }
        /**
         * Set the user connection
         * @params string User name
         * @params string Connection key                  
         */           
        public function setUser($user = 'root', $db = '*') {
            $this->data['connections'][$db]['user'] = $user; 
        }      
        /**
         * Set the password connection
         * @params string Password
         * @params string Connection key                  
         */                 
        public function setPwd($pwd = '', $db = '*') {
            $this->data['connections'][$db]['pwd'] = $pwd;             
        }
        /**
         * Set the tables prefix
         * @params string Prefix for each table
         * @params string Connection key                  
         */                 
        public function setPrefix($prefix = '', $db = '*') {
            $this->data['connections'][$db]['prefix'] = $prefix;
        }
        /**
         * Set the connection string
         * @params string Connection string
         * @params string Connection key                  
         */                 
        public function setDns($dns = '', $db = '*') {
            $this->data['connections'][$db]['dns'] = $dns;
        }
        /**
         * Save and execute connections
         */                 
        public function Save() {
            $f = @fopen($this->file, 'w+');
            if ($f) {
                fputs($f, '<?xml version="1.0"?'.">\n");
                fputs($f, '<pdomap>'."\n");
                fputs($f, "\t".'<connections>'."\n");
                foreach($this->data['connections'] as $key => $info) {
                    fputs($f, "\t\t".'<add ');
                    foreach($info as $key => $data) {
                        fputs($f, $key.'="'.$data.'" ');
                    }
                    fputs($f, '/>'."\n");                
                }
                fputs($f, "\t".'</connections>'."\n");
                fputs($f, "\t".'<mapping root="'.$this->data['root'].'">'."\n");
                foreach($this->data['mapping'] as $key => $data) {
                    fputs($f, "\t\t".'<adapter ');
                    fputs($f, 'name="'.$key.'" ');
                    fputs($f, 'path="'.$data['path'].'" ');
                    fputs($f, 'meta="'.$data['meta'].'"');
                    if (sizeof($data['require']) > 0) {
                        fputs($f, ">\n");
                        foreach($data['require'] as $file) {
                            fputs($f, "\t\t\t".'<require>'.$file.'</require>'."\n");
                        }
                        fputs($f, "\t\t".'</adapter>'."\n");                    
                    } else {
                        fputs($f, " />\n");
                    }
                }
                fputs($f, "\t".'</mapping>'."\n");
                fputs($f, '</pdomap>'."\n");
                fclose($f);
                $this->__wakeup();
                return true;
            } else return false;
        }
        /**
         * Include requires list 
         * @throw pdoMap_Parsing_Config_Exceptions_MappingUndefined   
         * @throw pdoMap_Exceptions_MappingNotFound               
         */                 
        public function RunRequires($type) {
            if (!isset($this->data['mapping'][$type])) {
                throw new pdoMap_Parsing_Config_Exceptions_MappingUndefined($type);
            }
            $root = $this->getRootPath().$this->data['mapping'][$type]['path'];
            foreach($this->data['mapping'][$type]['require'] as $file) {
                if (file_exists($root.$file)) {
                    require_once($root.$file);
                } else throw new pdoMap_Exceptions_MappingNotFound($type, $root.$file);
            }
        }        
        /**
         * Get the mapping configuration
         * @throw pdoMap_Parsing_Config_Exceptions_MappingUndefined         
         */                 
        public function mapping($type) {
            if (isset($this->data['mapping'][$type])) {
                return $this->data['mapping'][$type];
            } else 
                throw new pdoMap_Parsing_Config_Exceptions_MappingUndefined($type);
        }
        /**
         * Get the meta link with full path
         * @throw pdoMap_Parsing_Config_Exceptions_MappingUndefined         
         */                 
        public function getMetaPath($type) {
            if (!isset($this->data['mapping'][$type])) {
                throw new pdoMap_Parsing_Config_Exceptions_MappingUndefined(
                    $type
                );
            }
            return 
                $this->getRootPath()
                .$this->data['mapping'][$type]['path']
                .$this->data['mapping'][$type]['meta'];
        }
        /**
         * Get the mapping root
         */                 
        public function getRootPath() {
            if (substr($this->data['root'], 0, 1) == '.') {
                return realpath(dirname($this->file)).'/'.$this->data['root']; 
            } else return $this->data['root'];        
        }
        /**
         * Get the mapping key list
         */                 
        public function getMappingKeys() {
            return array_keys($this->data['mapping']);
        }
        /**
         * Deserialize from php code
         */                 
        public function __set_state($conf) {
            return new pdoMap_Parsing_Config_Cache($conf['data'], $conf['file']);
        }        
    }