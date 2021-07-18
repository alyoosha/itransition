<?php

namespace App\Command;

use App\Entity\Product;
use App\Parser\Parser;
use League\Csv\Reader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Doctrine\ORM\EntityManagerInterface;

class CsvImportCommand extends Command
{

	//Опрелеялем имя команды, по которой бдем запускать импорт
    protected static $defaultName = 'csv:run-import';
    protected static $defaultDescription = 'Import CSV';

	private $em;
	private $project_dir;

	public function __construct(EntityManagerInterface $em, string $project_dir)
	{
		parent::__construct();

		$this->em = $em;
		$this->project_dir = $project_dir;
	}

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('test', null, InputOption::VALUE_NONE, 'Запуск импорта без внесения данных в базу данных')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }

        //Получаем объект Reader с файлом csv
	    if(!file_exists($this->project_dir . '/public/stock.csv')) {
		    $io->error('Файла для импорта не найдено');

		    return Command::FAILURE;
	    }

	    $reader = Reader::createFromPath($this->project_dir . '/public/stock.csv');

	    //Получаем все строки
	    $reader = $reader->getRecords();

	    //Создаём объект класса Parser, который был создан для обрадотки полученных данных из csv
	    $parser = new Parser($reader);

	    //Получаем данные, которые были отфильтрованы
	    $result = $parser->parse();

	    //Если импорт был запущен с опцией test, тогда выводим только информацию об обработанных данных без занесения в базу данных
        if ($input->getOption('test')) {
	        $this->sendMessage($io, $result);

	        return Command::SUCCESS;
        }

	    //Заносим данные в базу данных и выводим сообщение
	    foreach ($result['products'] as $item) {
		    $product = (new Product())
			    ->setStrProductCode($item[0])
			    ->setStrProductName($item[1])
			    ->setStrProductDesc($item[2])
			    ->setIntProductQty($item[3])
			    ->setIntProductPrice($item[4])
			    ->setDtmDiscontinued($item[5])
			    ->setDtmAdded(new \DateTime())
			    ->setStmTimestamp(new \DateTime());

			    $this->em->persist($product);

			    $this->em->flush();
	    }

	    $this->sendMessage($io, $result);

        return Command::SUCCESS;
    }

    private function sendMessage(SymfonyStyle $io, $result) {
	    $io->success("Всего было обработано: $result[all]. Успешно: $result[success], Пропущено: $result[error]. 
	    \nНекорректные продукты: " . implode(', ',$result["incorrect"])
	    );
    }
}
