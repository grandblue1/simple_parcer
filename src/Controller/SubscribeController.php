<?php 

namespace Src\Controller;
use Src\Model\Linker;
use Src\Model\Subscription;
use Src\Service\LinkerService;


class SubscribeController extends Controller {
    
    public function subscribe(){
        try{
            $link = $_POST['link'] ?? null;
            $email = $_POST['email'] ?? null;

            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $this->renderError("Email isn't correct");
            }
            if(!empty($link)){
                $price = LinkerService::parsePrice($link);
            }else {
                $this->renderError("Link is Invalid");
            }
            // Parse the price using LinkerService
            $priceInfo = LinkerService::parsePrice($link);

            // Check if the parsing was successful
            if($priceInfo['price'] === null){
                throw new \Exception("Failed to parse price from the provided link");
            }
            $price = $priceInfo['price'];

            // Create a new Linker instance
            $linker = new Linker($link, $price);

            // Add the link to the database
            $linkID = $linker->addLink();
            
             // Subscribe the user to the link
            $subscription = new Subscription();
            
            $subscription->subscribe($email,$linkID);

            ini_set('smtp_port', 1025);
            ini_set('SMTP', 'mailhog');
            ini_set('sendmail_from', 'your_email@gmail.com');
            ini_set('sendmail_path', '/usr/sbin/sendmail -t -i');

            //PRG Pattern
            header('Location: /successful', true, 303);
            exit();

        }catch(\Exception $e){
            $this->renderError($e->getMessage());
        }
    }
    public function successful(){       
        return $this->render('successful');
    }
}