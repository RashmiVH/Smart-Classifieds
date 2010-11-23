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
     * @subpackage     Mapping
     * @link           www.pdomap.net
     * @since          2.*
     * @version        $Revision$
     */     

    /**
     * Adapter helper
     */         
    abstract class pdoMap_Mapping_Adapter 
        extends 
            pdoMap_Mapping_Adapter_Event 
    {        
        /**
         * @var string Adapter type
         */                 
        protected $type;
        
        /**
         * Constructor
         */                 
        public function __construct($type) {
            $this->type = $type;
            parent::__construct();
        }
        /**
         * Get adapter type
         */    
        public function getType() { return $this->type; }             
        /**
         * Magic Service WakeUp
         */                 
        public static function __set_state($values) {
            $class = get_called_class();
            $ret = new $class();
            unset($values['type']);
            unset($values['observers']);
            foreach($values as $property => $value) {
                $ret->$property = $value;
            }
            return $ret;
        }        
        /**
         * Get entity structure
         */                 
        public function getStructure() { 
            return pdoMap::structure($this->type); 
        }        
        /**
         * Get the request manager
         */         
        public function getRequest() { 
            return pdoMap::request()->get($this->type); 
        }        
        /**
         * Select an entity
         */                 
        public function SelectEntity($id) {
            if (pdoMap::cache()->hasEntity($this->type, $id)) {
                return pdoMap::cache()->getEntity($this->type, $id);
            } else {
                return $this->SelectFirst(
                    $this->getStructure()->getPk()->bind, 
                    $id
                );
            }
        }
        /**
         * Select with a criteria
         */                 
        public function SelectBy($field, $value) {
            return $this->getRequest()
                ->Select()
                ->Where()
                    ->Cond($field, '=', $value)
                ->Run();
        }
        /**
         * Select first item with a criteria
         */                 
        public function SelectFirst($field = null, $value = null) {
            $ret = $this->getRequest()
                    ->Select()
                    ->Where();
            if (!is_null($field)) {
                $ret->Cond($field, '=', $value);
            }
            $ret = $ret->Limit(0, 1)->Run();
            if (sizeof($ret) == 1) {
                return $ret->current();
            } else return null;
        }
        /**
         * Delete items with a criteria
         */                 
        public function DeleteBy($field, $value) {
            foreach($this->SelectBy($field, $value) as $entity) {
                $this->Delete($entity);
            }
        }
        /**
         * Delete first item with a criteria
         */                 
        public function DeleteFirst($field, $value) {
            foreach($this->SelectFirst($field, $value) as $entity) {
                $this->Delete($entity);
            }
        }
        /**
         * Select all items
         */                 
        public function SelectAll() {
            return $this->getRequest()->Select()->run();
        }
        /**
         * Delete all items
         */                 
        public function DeleteAll() {
            foreach($this->SelectAll() as $entity) {
                $this->Delete($entity);
            }
        }
        /**
         * Delete an entity
         * @throws pdoMap_Mapping_Exceptions_EntityValidate         
         */                 
        public function Delete(pdoMap_Mapping_Entity &$entity) {
            if (!$entity->isDbLink) {
                throw new pdoMap_Mapping_Exceptions_EntityValidate($entity);
            }
            $event = $this->raise(
                'Delete', 
                new pdoMap_Mapping_Adapter_Args($entity)
            );
            if ($event) {
                $event->entity->isDbLink = false;
                $ok = $this->getRequest()
                            ->Delete()
                                ->Where()
                                ->Cond(
                                    $this->getStructure()->getPk()->bind, 
                                    '=', 
                                    $event->entity->getPk()
                                )
                                ->Limit(1)
                                ->Run();
                if ($ok) {
                    pdoMap::cache()->removeEntity($event->entity);
                    $event->entity->isDbLink = false;
                    $event->entity->isUpdated = false;                
                    $event->entity->setValue(
                        $this->getStructure()->getPk()->bind,
                        null
                    );
                    return true;
                } else return false;
            } else return false;
        }
        /**
         * Create a new entity instance
         */                 
        public function &Create($values = null) {
            if ($values) {
                if (isset($values[$this->getStructure()->getPk()->bind])) {
                    $id = $values[$this->getStructure()->getPk()->bind];
                    if (pdoMap::cache()->hasEntity($this->type, $id)) {
                        $entity = &pdoMap::cache()->getEntity($this->type, $id);
                        foreach($values as $key => $val) {
                            $entity->setValue($key, $val);
                        }
                        return $entity;
                    }
                } 
            }            
            $class = $this->getStructure()->entity;
            $entity = new $class($values);
            return $entity;
        }
        /**
         * Update an entity
         * @throws pdoMap_Mapping_Exceptions_EntityValidate         
         */                 
        public function Update(pdoMap_Mapping_Entity &$entity) {
            if (!$this->Validate($entity))  
                throw new pdoMap_Mapping_Exceptions_EntityValidate($entity);
            $event = $this->raise(
                'Update', 
                new pdoMap_Mapping_Adapter_Args(
                    $entity
                )
            );
            if ($event) {
                $request = $this->getRequest()->Update();
                foreach($this->getStructure()->getFields() as $field) {
                    pdoMap::field()->PrepareRequestSetter(
                        $event->entity,
                        $field,
                        $request
                    );
                }
                $ok = $request->Where()
                        ->Cond(
                            $this->getStructure()->getPk()->bind, 
                            '=', 
                            $event->entity->getPk()
                        )
                        ->Limit(1)
                        ->Run();
                if ($ok) {
                    $event->entity->Commit();
                    return true;
                } else {
                    throw new pdoMap_Mapping_Exceptions_TransactionError(
                        'update', 
                        $entity
                    );
                }
            } else return false;
        }
        /**
         * Insert an entity
         * @returns mixed Returns inserted ID if ok, or false         
         * @throw pdoMap_Mapping_Exceptions_EntityValidate         
         */                 
        public function Insert(pdoMap_Mapping_Entity &$entity) {
            // VALIDATE ENTITY
            if (!$this->Validate($entity)) 
                throw new pdoMap_Mapping_Exceptions_EntityValidate($entity);
            // START INSERT EVENT
            $event = $this->raise(
                'Insert', 
                new pdoMap_Mapping_Adapter_Args($entity)
            );
            if ($event) {
                $request = $this->getRequest()->Insert();            
                foreach($this->getStructure()->getFields() as $field) {
                    pdoMap::field()->PrepareRequestSetter(
                        $event->entity,
                        $field,
                        $request
                    );
                }
                $id = $request->Run();
                if ($id) {
                     $event->entity->setValue(
                        $this->getStructure()->getPk()->bind,
                        $id
                    );
                    $event->entity->isDbLink = true;
                    $event->entity->Commit();                
                    pdoMap::cache()->setEntity($event->entity);
                    return $id; // RETURNS INSERTED ID
                } else {
                    throw new pdoMap_Mapping_Exceptions_TransactionError(
                        'insert', 
                        $entity
                    );
                }
            } else return false; // EVENT WAS CANCEL
        }
        /**
         * Validate entity values
         * @throw pdoMap_Mapping_Exceptions_EntityValidateIsNull
         * @throw pdoMap_Mapping_Exceptions_EntityValidateType          
         */                 
        public function Validate(pdoMap_Mapping_Entity &$entity) {
            $event = $this->raise(
                'Validate', 
                new pdoMap_Mapping_Adapter_Args($entity)
            );
            if ($event) {
                // AUTOMATIC FIELD VALIDATION
                foreach($this->getStructure()->getFields() as $field) {
                    // SET DEFAULT VALUE
                    if (
                        is_null($event->entity->getValue($field->bind))
                        && !is_null($field->DefaultValue())
                    ) {
                        $event->entity->__set(
                            $field->bind, $field->DefaultValue()
                        );
                    }
                    // READ VALUE
                    try {
                        $value = $event->entity->__get($field->bind);                
                    } catch (Exception $ex) {
                        throw new pdoMap_Mapping_Exceptions_EntityValidateType(
                            $event->entity, $field
                        );
                    }
                    // CHECK NULL CONSTRAINT
                    if (
                        !$field->IsNull() 
                        && is_null($value) 
                        && $field->type != 'Primary'
                    ) {
                    throw new pdoMap_Mapping_Exceptions_EntityValidateIsNull(
                            $event->entity, $field
                        );
                    }
                    // VALIDATE FIELD VALUE
                    if (
                        !is_null($value) && 
                        !pdoMap::field()->Validate(
                            $event->entity, $field, $value
                        )
                    ) {
                        throw new pdoMap_Mapping_Exceptions_EntityValidateType(
                            $event->entity, $field
                        );
                    }
                }
                return true;
            } else {
                return false;
            }
        }    
    }