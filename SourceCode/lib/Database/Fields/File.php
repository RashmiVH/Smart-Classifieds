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
     * @subpackage     Database::Fields
     * @link           www.pdomap.net
     * @since          2.*
     * @version        $Revision$
     */

    /**
     * Implements a file manager
     */         
    class pdoMap_Database_Fields_File
       implements
           pdoMap_Database_IField        
    {
        /**
         * Get database field definition
         * @params pdoMap_Mapping_Metadata_Field Field to manage
         * @returns array of pdoMap_Mapping_Metadata_Field                     
         */                 
        public function getMeta(            
            pdoMap_Mapping_Metadata_Field $field
        ) {
            if ($field->type != 'File') {
                throw new pdoMap_Database_Fields_Exceptions_BadType(
                    $field, 'File'
                );                
            }        
            return array(
                new pdoMap_Mapping_Metadata_Field(
                    $field->name.'_name',
                    $field->bind.'Name',
                    pdoMap_Mapping_Metadata_Field::FIELD_TYPE_TEXT,
                    array(
                        'size' => 255,
                        'indexed' => 'true'
                    ) 
                ),
                new pdoMap_Mapping_Metadata_Field(
                    $field->name.'_path',
                    $field->bind.'Path',
                    pdoMap_Mapping_Metadata_Field::FIELD_TYPE_TEXT,
                    array(
                        'size' => 255
                    )  
                ),
                new pdoMap_Mapping_Metadata_Field(
                    $field->name.'_type',
                    $field->bind.'Type',
                    pdoMap_Mapping_Metadata_Field::FIELD_TYPE_TEXT,
                    array(
                        'size' => 32,
                        'indexed' => 'true'
                    )  
                ),
                new pdoMap_Mapping_Metadata_Field(
                    $field->name.'_date_create',
                    $field->bind.'DateCreate',
                    pdoMap_Mapping_Metadata_Field::FIELD_TYPE_DATE
                ),
                new pdoMap_Mapping_Metadata_Field(
                    $field->name.'_date_update',
                    $field->bind.'DateUpdate',
                    pdoMap_Mapping_Metadata_Field::FIELD_TYPE_DATE
                )
            );
        }
        /**
         * Get a value
         * @params pdoMap_Mapping_Entity Entity to handle
         * @params pdoMap_Mapping_Metadata_Field Field to manage
         * @params mixed Value to handle                
         * @returns pdoMap_Utils_File              
         */                 
        public function getter(
            pdoMap_Mapping_Entity &$entity, 
            pdoMap_Mapping_Metadata_Field &$field,
            $value
        ) {
            // @todo
        }
        /**
         * Set a value
         * @params pdoMap_Mapping_Entity Entity to handle
         * @params pdoMap_Mapping_Metadata_Field Field to manage
         * @params mixed Value to handle       
         * @returns string         
         * @throw pdoMap_Mapping_Exceptions_EntityValidateType                        
         */         
        public function setter(
            pdoMap_Mapping_Entity &$entity, 
            pdoMap_Mapping_Metadata_Field &$field,
            $value
        ) {
            // @todo
        }
        /**
         * Validate a value 
         * @params pdoMap_Mapping_Entity Entity to handle
         * @params pdoMap_Mapping_Metadata_Field Field to manage
         * @params mixed Value to handle                      
         * @returns boolean True if value is valid or false if not         
         */                
        public function Validate(
            pdoMap_Mapping_Entity &$entity, 
            pdoMap_Mapping_Metadata_Field &$field,
            $value
        ) {
            // @todo
        }        
        /**
         * Prepare the request set 
         * @params pdoMap_Mapping_Entity Entity to handle
         * @params pdoMap_Mapping_Metadata_Field Field to manage
         * @params pdoMap_Database_Request_Adapters_ISetter Request setter                    
         */
        public function PrepareRequestSetter(
            pdoMap_Mapping_Entity &$entity, 
            pdoMap_Mapping_Metadata_Field &$field,
            pdoMap_Database_Request_Adapters_ISetter &$setter        
        ) {
            // @todo
        }           
    }