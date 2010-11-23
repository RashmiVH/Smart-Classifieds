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
     * @author          Ioan CHIRIAC <i dot chiriac at yahoo dot com>
     * @license         http://www.opensource.org/licenses/lgpl-2.1.php LGPL
     * @package         pdoMap
     * @subpackage      Core::XML
     * @link            www.pdomap.net
     * @since           2.*
     * @version         $Revision$
     */

    /**
     * Xml Document Manager
     */        
    class pdoMap_Core_XML_Document 
        extends 
            pdoMap_Core_XML_Node 
    {
        protected $__map = array();
        protected $__many = array();
        protected $__rootName;
        protected $__file;
        /**
         * Initialize a xml document
         * @params string File to open automatically
         * @params string XSD file to use for file validation         
         */                 
        public function __construct($file = null, $xsd = null) {
            if (!is_null($file)) {
                $this->load($file, $xsd);
            } else {
                $this->rootName = 'root';
            }
        }
        /**
         * Map a tag to a class
         */                 
        protected function mapTag($name, $class) {
            if (!isset($this->__map[$name])) $this->__map[$name] = $class;
        }
        /**
         * Defines multiple entries
         */                 
        protected function hasMany($tag) {
            if (is_array($tag)) {
                foreach($tag as $k) $this->hasMany($k);
            } else $this->__many[$tag] = true;
        }        
        /**
         * Loads a file to a class
         */                 
        public function load($file, $xsd = null) {
            if (!file_exists($file)) {
                throw new pdoMap_Core_XML_Exceptions_FileNotFound($file);
            }
            $this->__file = $file;
            libxml_use_internal_errors(true);
            $doc = new DOMDocument();
            $doc->load($file);            
            $root = $doc->firstChild;
            $this->__rootName = $root->nodeName;
            
            // TRY TO VALIDATE
            if (!is_null($xsd)) {
                if (!$doc->schemaValidate($xsd)) {
                    throw new pdoMap_Core_XML_Exceptions_Validate(
                        $file, libxml_get_errors()
                    );                    
                }
            }

            // READING ATTRIBUTES
            if ($root->hasAttributes()) {
                $a = 0; 
                while($root->attributes->item($a)) {
                    $name = $root->attributes->item($a)->nodeName;
                    $value = $root->attributes->item($a)->nodeValue;
                    $this->$name = $value;
                    $a++;
                }
            }
            // READING CHILDS
            $this->readNodes($root->childNodes, $this);
        }
        /**
         * Save the file
         */                 
        public function save($file = null) {
            if (!is_null($file)) $this->__file = $file;
            $f = fopen($this->__file, 'w+');
            if (!$f) {
                throw new Exception('Unable to save the file '.$this->__file);
            }
            fputs($f, '<?xml version="1.0"?'.">\n");
            fputs($f, '<'.$this->__rootName.'>'."\n");
            fputs($f, $this->serialize($this->__properties));
            fputs($f, '</'.$this->__rootName.'>'."\n");
            fclose($f);
        }
        // SERIALIZE A COLLECTION OF PROPERTIES
        private function serialize($array, $level = 1) {
            $ret = '';
            foreach($array as $key => $value) {
                if (is_array($value)) {
                    foreach($value as $val) {
                        $ret .= $this->serializeItem($key, $val, $level);
                    }
                } else $ret .= $this->serializeItem($key, $value, $level);
            }
            return $ret;
        }
        /**
         * SERIALIZE AN ITEM
         */         
        private function serializeItem($key, $value, $level) {
            $ret = str_repeat("\t", $level).'<'.$key.'>';
            if (is_a($value, 'xmlNode')) {
                $ret .= "\n".$this->serialize(
                    $value->getProperties(), $level + 1
                ).str_repeat("\t", $level);                    
            } else {
                $ret .= $this->getNodeValue($value);                    
            }        
            $ret .= '</'.$key.">\n";
            return $ret;
        }
        // SERIALIZE AN VALUE
        private function getNodeValue($value) {
            if (is_numeric($value)) {
                return $value;
            } else {
                if (
                    strpos($value, '&') === false 
                    && strpos($value, '<') === false
                ) {
                    return $value;
                } else return '<![CDATA['.$value.']]>';
            }
        } 
        /**
         * Read nodes
         */                 
        private function readNodes($nodes, &$target) {        
            foreach($nodes as $node) {
                $name = $node->nodeName;
                // echo '-'.$name.'<br />';
                if (substr($name,0,1) !=  '#') {                
                    // HANDLE NODE
                    if (isset($target->$name) || isset($this->__many[$name])) {
                        if (isset($target->$name)) {
                            $val = $target->$name;
                            if (!is_array($target->$name)) {
                                $val = array($val);
                            }
                        } else $val = array();
                        $val[] = $this->addNode($node, $target);
                        $target->$name = $val;
                    } else {
                        $target->$name = $this->addNode($node, $target);
                    }                            
                    // HANDLE ATTRIBUTES
                    if ($node->hasAttributes()) {
                        $target->$name = $this->addAttributes(
                            $node, $target->$name
                        );        
                    }                    
                }
            }
        }
        /**
         * Reads and add a node
         */                  
        private function addNode($node, &$target) {
            $name = $node->nodeName;
            if ($this->hasChilds($node)) {
                $ret = $this->loadNode($name, $target);                                            
                $this->readNodes($node->childNodes, $ret);
            } else {
                $ret = $node->nodeValue;
            } 
            return $ret;
        }
        /**
         * Verify if node have childs
         */                  
        private function hasChilds($node) {
            if (!$node->hasChildNodes() || $node->childNodes->length < 2) {
                return false;
            } else {
                foreach($node->childNodes as $child) {
                    if (substr($child->nodeName, 0, 1) != '#') return true;
                }
                return false;
            }
        }
        /**
         * Read attributes and add to target
         */                 
        private function addAttributes($node, $target) {
            $name = $node->nodeName;
            if (!$target) $target = $this->loadNode($name, $this);
            if (is_array($target)) {
                if (!$target[sizeof($target) - 1]) {
                    $target[sizeof($target) - 1] = $this->loadNode(
                        $name, $this
                    );
                }
            }
            $a = 0; 
            while($node->attributes->item($a)) {
                $name = $node->attributes->item($a)->nodeName;
                $value = $node->attributes->item($a)->nodeValue;
                if (is_array($target)) {
                    $target[sizeof($target) - 1]->$name = $value;
                } else {
                    $target->$name = $value;
                }                                                    
                $a++;
            }    
            return $target;
        }
        /**
         * Initialize a node
         */                 
        private function loadNode($name, &$parent) {
            if (isset($this->__map[$name])) {
                return new $this->__map[$name]($this, $parent);
            } else {
                return new pdoMap_Core_XML_Node($this, $parent);
            }
        }
    }
