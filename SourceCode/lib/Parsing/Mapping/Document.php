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
     * @subpackage     Parsing::Mapping
     * @link           www.pdomap.net
     * @since          2.*
     * @version        $Revision$
     */
    
    /**
     * Configuration Reader
     * Loads a table XML mapping and generate associated class      
     */
    class pdoMap_Parsing_Mapping_Document extends pdoMap_Core_XML_Document {
        private $f;
        public $tab = 0;
        public $mappingKey;
        public $mappingData = array();
        /**
         * Loads and read a xml mapping file
         */                 
        public function __construct($file) {
            $this->hasMany(
                array(
                    'field', 'request', 'transaction', 
                    'param', 'cond', 'order', 'join', 
                    'do', 'set', 'collection'
                )
            );
            $this->mapTag('transaction', 'pdoMap_Parsing_Mapping_Transaction');
            $this->mapTag('request',     'pdoMap_Parsing_Mapping_Request');
            $this->mapTag('do',          'pdoMap_Parsing_Mapping_Do');
            $this->mapTag('collection',  'pdoMap_Parsing_Mapping_Collection');
            parent::__construct(
                $file,
                pdoMap::$rootPath.'Parsing/Mapping/Structure.xsd'    
            );
        }
        /**
         * Start writing to a file
         */                 
        public function open($file) {   
            $this->close();
            $this->f = fopen($file, 'w+');
            $this->tab = 0;
            if (!$this->f) throw new Exception('Unable to write file '.$file);
        }
        /**
         * Close file
         */          
        public function close() {
            if ($this->f) fclose($this->f);        
        }        
        /**
         * Generate php mapping class 
         * @throw pdoMap_Parsing_Mapping_Exceptions_Field         
         */                 
        public function generate($file, $ns) {
            $this->mappingKey = $ns;
            $ns = ucfirst($ns); // Camelstyle
            /**
             * Defining Interface Service
             */                         
            $this->open($file.'.class.php');
            $this->writeLine('<?php // GEN '.$ns.' AT '.date('Y-m-d H:i:s'));
            $this->writeLine('interface I'.$ns.'Adapter {');        
            if (isset($this->adapter)) {
                if (isset($this->adapter->request)) 
                    foreach($this->adapter->request as $rq) 
                        $rq->writeSignature(true);
                if (isset($this->adapter->transaction)) 
                    foreach($this->adapter->transaction as $rq) 
                        $rq->writeSignature(true);
            }
            $this->writeLine('}');
            /**
             * Defining Adapter Service
             */                         
            $this->writeLine(
                'class '.$ns.'AdapterImpl'
            );
            $this->writeLine(
                    'extends pdoMap_Mapping_Adapter'
            ); 
            $this->writeLine(
                    'implements I'.$ns.'Adapter {'
            );
            $this->writeLine(
                'public static $adapter = \''.$this->mappingKey.'\';'
            );
            $this->writeLine('public function __construct() {');    
            $this->writeLine('parent::__construct(\''.$this->mappingKey.'\');');
            $this->writeLine('}');
            if (isset($this->adapter)) {
                if (isset($this->adapter->request)) 
                    foreach($this->adapter->request as $rq) 
                        $rq->toPhp(true);
                if (isset($this->adapter->transaction)) 
                    foreach($this->adapter->transaction as $rq) 
                        $rq->toPhp(true);
            }
            $this->writeLine('}');        
            /**
             * Generating Item Entity Manager
             */                                 
            $this->writeLine(
                'class '.$ns.'EntityImpl extends pdoMap_Mapping_Entity {'
            );
            $this->writeLine(
                    'public function __construct($values = null) {'
            );
            $this->writeLine(
                        'parent::__construct(\''
                            .$this->mappingKey
                            .'\', $values);'
            );
            $this->writeLine('}');    
            foreach($this->fields->field as $field) {    
                if (isset($field->calculated)) {
                    $field->calculated = str_replace(
                        '{', '$this->', $field->calculated
                    );
                    $field->calculated = str_replace(
                        '}', '', $field->calculated
                    );
                    $field->calculated = str_replace(
                        '.', '->', $field->calculated
                    );
                    $this->writeLine('/**');                    
                    $this->writeLine(' * Calculated field getter '.$field->bind);                    
                    $this->writeLine(' * Formula : '.$field->calculated);                    
                    $this->writeLine(' */');                    
                    $this->writeLine(
                        'public function getter'.$field->bind.'() {'
                    );
                    $this->writeLine('$this->setValue(\''.$field->bind.'\', '.$field->calculated.');');
                    $this->writeLine('return $this->getValue(\''.$field->bind.'\');');
                    $this->writeLine('}');                  
                }
            }
            if (isset($this->entity)) {
                if (isset($this->entity->collection)) 
                    foreach($this->entity->collection as $rq) 
                        $rq->toPhp(false);
                if (isset($this->entity->request)) 
                    foreach($this->entity->request as $rq) 
                        $rq->toPhp(false);
                if (isset($this->entity->transaction)) 
                    foreach($this->entity->transaction as $rq) 
                        $rq->toPhp(false);
            }
            $this->writeLine('}');
            /**
             * Generating Structure Manager
             */                                 
            $this->open($file.'.structure.php');
            $this->writeLine('<?php // GEN '.$ns.' AT '.date('Y-m-d H:i:s'));
            // GET ENTITY MANAGER
            if (isset($this->entity) && isset($this->entity->class)) {
                $entity = $this->entity->class;
            } else $entity = $ns.'EntityImpl';
            // GET ADAPTER MANAGER 
            if (isset($this->adapter) && isset($this->adapter->class)) {
                $adapter = ', \''.$this->adapter->class.'\'';
            } else $adapter = ', \'I'.$ns.'Adapter\'';
            // GET DATABASE MANAGER
            if ($this->use) {
                $db = ', \''.$this->use.'\'';
            } else $db = '';
            // START CONSTRUCT
            $this->writeLine(
                '$return = new pdoMap_Mapping_Metadata_Table(\''
                .$this->mappingKey
                .'\', \''
                .$this->name
                .'\', \''
                .$entity.'\''
                .$adapter.$db.');'
            );
            foreach($this->fields->field as $field) {    
                if (!isset($field->bind)) {
                    throw new Exception(
                        'A field must contain a bind attribute !'
                    );
                }                    
                if (!isset($field->type)) {
                    throw new Exception(
                        'A field must contain a type attribute !'
                    );
                }                
                if (!isset($field->name)) $field->name = $field->bind;
                $this->writeLine(
                    '$return->fields[\''
                    .$field->bind
                    .'\'] = new pdoMap_Mapping_Metadata_Field('
                );
                $this->writeData('\''.$field->name.'\',');
                $this->writeLine('\''.$field->bind.'\',');
                $this->writeData('\''.ucfirst(strtolower($field->type)).'\',');        
                $props = $field->getProperties();
                unset($props['name']); 
                unset($props['bind']);    
                unset($props['type']);
                if (isset($props['calculated'])) {
                    unset($props['calculated']);
                }
                $this->writeData(var_export($props, true));
                $this->writeLine(');');
            }
            $this->writeLine('return $return;');
            $this->close();            
            // TEST STRUCTURE
            $structure = include($file.'.structure.php');
            foreach($structure->fields as $bind => $field) {
                try {
                    pdoMap::field()->getMeta($field);   // TEST FIELD META
                } catch(Exception $ex) {
                    @unlink($file.'.structure.php');
                    @unlink($file.'.class.php');
                    throw new pdoMap_Parsing_Mapping_Exceptions_Field(
                        $field, $this->__file, $ex->getMessage()
                    );
                }
            }
            return $structure;
        }        
        /**
         * Write a line to open file
         * @params string data to write
         */                 
        public function writeLine($data) {
            if (substr($data, 0, 1) == '}') $this->tab -= 1;
            if (substr($data, 0, 2) == '->') 
                $this->writeData(str_repeat("\t", 6));
            $this->writeData(str_repeat("\t", $this->tab).$data."\n");
            if (substr($data, -1) == '{') $this->tab += 1;
        }
        /**
         * Write data to open file
         * @params string data to write
         */                 
        public function writeData($data) {
            fputs($this->f, $data);
        }
        /**
         * Generate a xml file from structure
         */                 
        public static function map(IRequestTable $table, $path) {
            $f = fopen(pdoMap::$mappingPath.$table->getName().'.map.xml', 'w+');
            if (!$f) 
                throw new Exception(
                    'Unable to write XML file on '
                    .$table->getName()
                    .'.xml. Please check that folder and files are writable.'
                );
            fputs($f, '<?xml version="1.0"?'.'>'."\n");
            fputs($f, 
                '<table name="'
                    .$table->getName()
                    .'" use="'
                    .$table->getDatabase().'">'."\n"
            );
            fputs($f, 
                '<!-- GENERATED BY PDOMAP AT '
                    .date('Y-m-d H:i:s')
                .' -->'."\n"
            );            
            fputs($f, "\t".'<fields>'."\n");
            foreach($table->getFields() as $field) {
                fputs($f, "\t\t".'<field ');
                fputs($f, "\n\t\t\t".'bind="'.$field->getBind().'"');
                fputs($f, "\n\t\t\t".'type="'.$field->getType().'"');
                fputs($f, "\n\t\t\t".'size="'.$field->getSize().'"');
                fputs($f, "\n\t\t\t".'name="'.$field->getName().'"');
                fputs($f, ' />'."\n");                
            }
            fputs($f, "\t".'</fields>'."\n");            
            fputs($f, '</table>'."\n");
            fclose($f);            
        }
    } 