<?php

namespace Dev\TaskBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Guzzle\Http\Exception\ClientErrorResponseException;

class AppAdvertiserIdCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
			// the name of the command (the part after "bin/console")
            ->setName('app:advertiser-id')
			// the short description shown while running "php bin/console list"
            ->setDescription('...')
			// the argument expected after the name of the command 
            ->addArgument('argument', InputArgument::OPTIONAL, 'Argument description')
            //->addOption('option', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
		// the input argument from user
        $argument = $input->getArgument('argument');
		
		// Status Code variable
		$statusCode = 0;

		// Offer variable - to be incremented
		$offer_id = 1;
		
		while($statusCode != 404)
		{	
			// Route to retrieve all the offers data for the given advertiser ID
			$url = 'http://process.xflirt.com/advertiser/'.$argument.'/offers/'.$offer_id;
			echo $url. PHP_EOL;
			
			// Increment $offer_id
			$offer_id++;
			
			// Guzzle HTTP Client
			$client = new \GuzzleHttp\Client(['http_errors' => false]);
			$res = $client->request('GET', $url);
			
			$statusCode = $res->getStatusCode();
			
			if($statusCode == 200)
			{
				// Data is available 
				//echo 'Status Code: '.$res->getStatusCode().PHP_EOL;
				
				// Get contents
				$contents = $res->getBody();
				$json = json_decode($contents);
				
				$advertiser_id = $json->advertiser_id;

				if($advertiser_id == 1)
				{
					$payout_amount = $json->payout_amount;
					$platform = $json->mobile_platform;
					$name = $json->name;
					$country = $json->countries[0];			
				}
				elseif($advertiser_id == 2)
				{
					$payout_amount = $json->campaigns->points/1000;
					$platform = $json->app_details->platform;
					$name = '';
					$country = $json->campaigns->countries[0];
				}
			}else{
				// No data available
				//echo 'No content'.PHP_EOL;
			}
		}	
		
		//$yourController = $this->newAction();
		
		$Controller = new \Dev\TaskBundle\Controller\OfferController();
		$Controller->addrowAction();
					
		//$OfferController = new $OfferController();
		//$addRowVar = $OfferController->addRow();
		
        $output->writeln(' Done.');
		//$output->writeln("Providen text : ".$advertiser_id);
		//$output->writeln("Text: ".$res->getHeader('advertiser_id'));
    }
}
