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
     * @subpackage     Database::Events
     * @link           www.pdomap.net
     * @since          2.*
     * @version        $Revision$
     */     
     
    /**
     * Observer declaration
     */
    interface pdoMap_Database_Manager_IEvent {
        /**
         * Event raised when connecting to a database
         */                         
        function onConnect(
            pdoMap_Database_Manager &$sender, 
            pdoMap_Database_Manager_Args &$args);
        /**
         * Event raised when closing connection to a database
         */                         
        function onClose(
            pdoMap_Database_Manager &$sender, 
            pdoMap_Database_Manager_Args &$args);
        /**
         * Event raised when requesting data
         */                         
        function onQuery(
            pdoMap_Database_Manager &$sender, 
            pdoMap_Database_Manager_Args &$args);
        /**
         * Event raised when request is bad
         */                         
        function onError(
            pdoMap_Database_Manager &$sender, 
            pdoMap_Database_Manager_Args &$args);
    }

/* implementation template : 
        public function onConnect(
            pdoMap_Database_Manager &$sender, 
            pdoMap_Database_Manager_Args &$args            
        ) { 
            // Put your code here                     
        }
        public function onClose(
            pdoMap_Database_Manager &$sender, 
            pdoMap_Database_Manager_Args &$args
        ) { 
            // Put your code here                     
        }
        public function onQuery(
            pdoMap_Database_Manager &$sender, 
            pdoMap_Database_Manager_Args &$args
        ) { 
            // Put your code here                     
        }
        public function onError(
            pdoMap_Database_Manager &$sender, 
            pdoMap_Database_Manager_Args &$args
        ) { 
            // Put your code here                     
        }            
*/        