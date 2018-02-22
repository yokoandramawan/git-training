<?php
namespace Ticket\V1\Console\Controller;

use RuntimeException;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\Console\Controller\AbstractConsoleController;
use Zend\View\Model\ViewModel;
use Zend\Console\Request as ConsoleRequest;
use Zend\Math\Rand;
use Ticket\Mapper\Ticket as TicketMapper;
use Psr\Log\LoggerAwareTrait;

class TicketController extends AbstractConsoleController
{
    /* ... */
    use LoggerAwareTrait;

    protected $ticketMapper;

    public function __construct(
        TicketMapper $ticketMapper
    ) {

        $this -> setTicketMapper($ticketMapper);
    }

    public function setTicketMapper($ticketMapper)
    {
        $this -> ticketMapper = $ticketMapper;
        // return $this;
    }

    public function getTicketMapper()
    {
        return $this -> ticketMapper;
    }

    public function fetchbyidAction()
    {
        $request = $this->getRequest();
        // var_dump($request);exit;

        // Make sure that we are running in a console, and the user has not
        // tricked our application into running this action from a public web
        // server:
        if (! $request instanceof ConsoleRequest) {
            throw new RuntimeException('You can only use this action from a console!');
        }

        // Get user email from the console, and check if the user requested
        // verbosity:
        $id   = $request->getParam('uuid');
        $verbose     = $request->getParam('verbose') || $request->getParam('v');

        // Reset new password
        $newPassword = Rand::getString(16);

        // Fetch the user and change his password, then email him ...
        /* ... */

        if ($verbose) {
            try{
                $ticket = $this->getTicketMapper()->getEntityRepository()->findOneBy(['uuid' => $id]);
                // var_dump($ticket);exit;
                $ticketObj = new \stdClass();
                $ticketObj->uuid = $ticket->getUuid();
                $ticketObj->name = $ticket->getName();
                $ticketObj->description = $ticket->getDescription();
                $ticketObj->status = $ticket->getStatus();
                $ticketObj->code = $ticket->getCode();
                
                $this->logger->log(\Psr\Log\LogLevel::INFO, "=={function}== 
                UUID : {uuid}
                NAME : {name}
                DESCRIPTION : {description}
                STATUS : {status}
                CODE : {code}", 
                    [
                        'uuid' => $ticketObj->uuid,
                        'name' => $ticketObj->name,
                        'description' => $ticketObj->description,
                        'status' => $ticketObj->status,
                        'code' => $ticketObj->code,
                        "function" => __FUNCTION__
                    ]);
                
                return "Success! UUID ini '$id' Berhasil di Fetch.\n";
                    // . "It has also been emailed to him.\n $ticketObj->uuid \n";
                
                
            }
            catch (\Exception $e) {
                $this->logger->log(\Psr\Log\LogLevel::ERROR, "{function} : Something Error! \nError_message: ".$e->getMessage(), ["function" => __FUNCTION__]);
            }            
        }

        try{
            $ticket = $this->getTicketMapper()->getEntityRepository()->findOneBy(['uuid' => $id]);
            // var_dump($ticket);exit;
            $ticketObj = new \stdClass();
            $ticketObj->uuid = $ticket->getUuid();
            $ticketObj->name = $ticket->getName();
            $ticketObj->description = $ticket->getDescription();
            $ticketObj->status = $ticket->getStatus();
            $ticketObj->code = $ticket->getCode();
            
            $this->logger->log(\Psr\Log\LogLevel::INFO, "=={function}== 
            UUID : {uuid}
            NAME : {name}
            DESCRIPTION : {description}
            STATUS : {status}
            CODE : {code}", 
                [
                    'uuid' => $ticketObj->uuid,
                    'name' => $ticketObj->name,
                    'description' => $ticketObj->description,
                    'status' => $ticketObj->status,
                    'code' => $ticketObj->code,
                    "function" => __FUNCTION__
                ]);
            
            return "Success! UUID ini '$id' Berhasil di Fetch.\n";
                // . "It has also been emailed to him.\n $ticketObj->uuid \n";
            
            
        }
        catch (\Exception $e) {
            $this->logger->log(\Psr\Log\LogLevel::ERROR, "{function} : Something Error! \nError_message: ".$e->getMessage(), ["function" => __FUNCTION__]);
        } 
        // return "Done! $userEmail has received an email with his new password.\n";

    }
}