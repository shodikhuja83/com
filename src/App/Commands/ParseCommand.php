<?php
namespace Console\App\Commands;
 
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
define("SPACE", " ");
class ParseCommand extends Command
{	
    protected function configure()
    {
        $this->setName('parse')
            ->setDescription('Парсинг файла и обработка данных')
            ->setHelp('Demonstration of custom commands created by Symfony Console component.')
            ->addArgument('path', InputArgument::REQUIRED, 'Input path.')
            ->addArgument('operator', InputArgument::REQUIRED, 'Input operator (+,-,*,/).');
    }
	
	private function calc($path, $operation) {
		$handle = fopen($path, "r");
		$positive = array();
		$negative = array();
		while (!feof($handle)) {
			$buffer = fgets($handle, 4096);
			$row = explode(" ", $buffer);
			eval("\$res = floatval(".implode($operation,$row).");");
			if($res > 0) {
				$positive[] = floatval($row[0]).SPACE.$operation.SPACE.floatval($row[1]).SPACE."=".SPACE.$res;
			} else {
				$negative[] = floatval($row[0]).SPACE.$operation.SPACE.floatval($row[1]).SPACE."=".SPACE.$res;
			}
		}
		fclose($handle);
		
		if(count($positive) > 0) {
			file_put_contents("C:/xampp/htdocs/com/positive.txt", implode(PHP_EOL,$positive));
		}
		if(count($negative) > 0) {
			file_put_contents("C:/xampp/htdocs/com/negative.txt", implode(PHP_EOL, $negative));
		}
		return;
	}
	
    protected function execute(InputInterface $input, OutputInterface $output)
    {
		$this->calc($input->getArgument('path'),$input->getArgument('operator'));
        $output->writeln(sprintf('Parsing completed!, path = %s, operator = %s', $input->getArgument('path'),$input->getArgument('operator')));
    }
}