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
     * @subpackage     Database::Adapters::MySQL
     * @link           www.pdomap.net
     * @since          2.*
     * @version        $Revision$
     */

    /** 
     * Database Table structure
     */
    class pdoMap_Database_Request_Adapters_MySQL_Table 
        implements 
            pdoMap_Database_Request_Adapters_ITable 
    {
        private $database;
        private $name;
        private $adapter;
        private $primary;
        private $fields = array();
        public function __construct($database, $name, $data = null) {
            if (is_null($data)) {
                $sql = pdoMap::database()->Request(
                    $database, 
                    'SHOW FULL COLUMNS FROM '
                    .pdoMap_Database_Request_Adapters_MySQL_Builder::escapeTable(
                        $name, 
                        $database
                    )
                );
                while($row = pdoMap::database()->Fetch($sql)) {
                    $this->fields[] = new pdoMap_Database_Request_Adapters_MySQL_Field($row);
                    if ($row[4] == 'PRI') {
                        $this->primary = sizeof($this->fields) - 1;
                    }
                }
            } else {
                $this->fields = $data['fields'];
                $this->primary = $data['pk'];
                $this->adapter = $data['adapter'];
            }
            $this->database = $database;
            $this->name = $name;
        }
        public function getDatabase() { return $this->database; }
        public function getName() { return $this->name; }
        public function getFields() { return $this->fields; }
        public function getPrimaryKey() { return $this->fields[$this->primary]; }
        public function getForeignKeys() { return $this->fk; }
        public function Truncate() {
            return pdoMap::database()->Request(
                $this->database, 
                'TRUNCATE TABLE '
                .pdoMap_Database_Request_Adapters_MySQL_Builder::escapeTable(
                    $this->name, 
                    $this->database
                )
            );
        }
        public function Drop() {
            // REMOVE TABLE REFERENCES
            if ($this->adapter) {
                foreach(pdoMap::config()->getMappingKeys() as $m) {
                    if ($m != $this->adapter) {
                        pdoMap::structure($m)->TableRequest()->DropFk(
                            $this->adapter
                        );
                    }
                }            
            }
            // RUN TABLE DROPPING
            return pdoMap::database()->Request(
                $this->database, 
                'DROP TABLE IF EXISTS '
                .pdoMap_Database_Request_Adapters_MySQL_Builder::escapeTable(
                    $this->name, 
                    $this->database
                )
            );        
        }
        public function Create() {    
            $sql = 'CREATE TABLE '
                    .pdoMap_Database_Request_Adapters_MySQL_Builder::escapeTable(
                        $this->name, 
                        $this->database
                    ).' ('."\n";
            $opt = '';
            foreach($this->fields as $field) {
                $sql .= pdoMap_Database_Request_Adapters_MySQL_Builder::escapeEntity($field->name).' ';
                switch($field->type) {
                    case pdoMap_Mapping_Metadata_Field::FIELD_TYPE_PK:
                        $sql .= 'INT(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ';
                        break;
                    case pdoMap_Mapping_Metadata_Field::FIELD_TYPE_FK:
                        $sql .= 'INT(10) UNSIGNED NOT NULL';
                        $opt .= 'INDEX('.pdoMap_Database_Request_Adapters_MySQL_Builder::escapeEntity($field->name).'), '."\n";
                        break;
                    case pdoMap_Mapping_Metadata_Field::FIELD_TYPE_TEXT:
                        if (isset($field->size)) {
                            $sql .= 'VARCHAR('.$field->size.')';
                        } else {
                            $sql .= 'TEXT';
                        }
                        break;
                    case pdoMap_Mapping_Metadata_Field::FIELD_TYPE_INT:
                        switch($field->size) {
                            case 'tiny':
                                $sql .= 'TINYINT';
                                break;
                            case 'small':
                                $sql .= 'SMALLINT';
                                break;
                            case 'medium':
                                $sql .= 'MEDIUMINT';
                                break;
                            case 'big':
                                $sql .= 'BIGINT';
                                break;
                            default:
                                $sql .= 'INT(10)';
                        }
                        break;
                    case pdoMap_Mapping_Metadata_Field::FIELD_TYPE_FLOAT:
                        $sql .= 'FLOAT';
                        break;                        
                    case pdoMap_Mapping_Metadata_Field::FIELD_TYPE_ENUM:
                        $sql .= 'ENUM(';
                        foreach($field->values as $val) {
                            $sql .= pdoMap_Database_Request_Adapters_MySQL_Builder::escapeValue($val).', ';
                        }
                        $sql = substr($sql, 0, strlen($sql) - 2).')';
                        break;
                    case pdoMap_Mapping_Metadata_Field::FIELD_TYPE_DATE:
                        $sql .= 'TIMESTAMP';
                        break;
                    default:
                        throw new Exception('Unknown field type '.$field->type.' for '.$field->name.' on table '.$this->name);
                        break;
                }
                if ($field->isIndex) {
                    $opt .= 'INDEX('.pdoMap_Database_Request_Adapters_MySQL_Builder::escapeEntity($field->name).'), '."\n";
                }
                if ($field->isNull) {
                    $sql .= ' NULL ';                        
                } else {
                    $sql .= ' NOT NULL ';    
                }
                if ($field->default) {
                    if (substr($field->default, 0, 1) == '*') {
                        $sql .= ' DEFAULT '.substr($field->default, 1);                    
                    } else {
                        $sql .= ' DEFAULT '.pdoMap_Database_Request_Adapters_MySQL_Builder::escapeValue($field->default);
                    }
                }
                $sql .= ' COMMENT \'*'.$field->bind.':'.$field->comment.'\', '."\n";
            }
            $sql .= $opt;
            $sql = substr($sql, 0, strlen($sql) - 3).')  ENGINE = INNODB;';
            return pdoMap::database()->Request($this->database, $sql); 
        }    
        public function DropFk($adapter) {
            foreach($this->fields as $field) {
                if ($field->type == pdoMap_Mapping_Metadata_Field::FIELD_TYPE_FK) {
                    if ($field->adapter == $adapter) {
                        $sql = 'ALTER TABLE '
                        .pdoMap_Database_Request_Adapters_MySQL_Builder::escapeTable(
                            $this->name, 
                            $this->database
                        );
                        $sql .= ' DROP FOREIGN KEY '.pdoMap_Database_Request_Adapters_MySQL_Builder::escapeEntity($this->name.'_'.$field->name);
                        try {
                            return pdoMap::database()->Request(
                                $this->database, $sql
                            );
                        } catch(pdoMap_Database_Exceptions_BadRequest $ex) {
                            return false;
                        }
                    }
                }
            }            
            return false;     
        }
        public function DropAllFk() {
            $found = false;
            $sql = 'ALTER TABLE IF EXISTS '
            .pdoMap_Database_Request_Adapters_MySQL_Builder::escapeTable(
                $this->name, 
                $this->database
            );
            foreach($this->fields as $field) {
                if ($field->type == pdoMap_Mapping_Metadata_Field::FIELD_TYPE_FK) {
                    $sql .= ' DROP FOREIGN KEY '.pdoMap_Database_Request_Adapters_MySQL_Builder::escapeEntity($this->name.'_'.$field->name).', ';
                    $found = true;
                }
            }            
            if (!$found) return true;
            $sql = substr($sql, 0, strlen($sql) - 3);
            try {
                return pdoMap::database()->Request($this->database, $sql);
            } catch(pdoMap_Database_Exceptions_BadRequest $ex) {
                return false;
            }                                 
        }
        public function JoinAll() {
            $found = false;
            $sql = 'ALTER TABLE '
                    .pdoMap_Database_Request_Adapters_MySQL_Builder::escapeTable(
                        $this->name, 
                        $this->database
                    )."\n";
            foreach($this->fields as $field) {
                if ($field->type == pdoMap_Mapping_Metadata_Field::FIELD_TYPE_FK) {
                    $sql .= ' ADD CONSTRAINT '.pdoMap_Database_Request_Adapters_MySQL_Builder::escapeEntity($this->name.'_'.$field->name).' FOREIGN KEY(';
                    $sql .= pdoMap_Database_Request_Adapters_MySQL_Builder::escapeEntity($field->name);
                    $sql .= ') REFERENCES ';
                    $ref = pdoMap::structure($field->adapter);
                    if (!$ref) {
                        throw new Exception('Could not join '.$field->bind.' to an undefined table '.$field->adapter);
                    }
                    $sql .= pdoMap_Database_Request_Adapters_MySQL_Builder::escapeTable($ref->name, $ref->db);
                    $sql .= ' ('.pdoMap_Database_Request_Adapters_MySQL_Builder::escapeEntity($ref->getPk()->name).')';
                    $sql .= ' ON DELETE CASCADE, '."\n";
                    $found = true;
                }
            }            
            if (!$found) return true;
            $sql = substr($sql, 0, strlen($sql) - 3);
            return pdoMap::database()->Request($this->database, $sql);             
        }
    }    