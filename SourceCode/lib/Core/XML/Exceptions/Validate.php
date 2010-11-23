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
     * @subpackage      Exceptions
     * @link            www.pdomap.net
     * @since           2.*
     * @version         $Revision$
     */

    class pdoMap_Core_XML_Exceptions_Validate 
        extends 
            pdoMap_Core_Exception 
    {
        public function __construct($file, $errors = null) {
            $details = null;
            if (is_array($errors)) {
                foreach($errors as $err) $details .= $this->getError($err);
                libxml_clear_errors();
            }
            parent::__construct(
                'Unable to validate xml file : '.$file.
                $details
            );
        }
        
        protected function getError($error)
        {
            $return = "<br/>\n";
            switch ($error->level) {
                case LIBXML_ERR_WARNING:
                    $return .= "<b>Warning $error->code</b>: ";
                    break;
                case LIBXML_ERR_ERROR:
                    $return .= "<b>Error $error->code</b>: ";
                    break;
                case LIBXML_ERR_FATAL:
                    $return .= "<b>Fatal Error $error->code</b>: ";
                    break;
            }
            $return .= "\n".trim($error->message);
            $return .= "\n on line <b>$error->line</b>\n";
        
            return $return;
        } 
    }
    