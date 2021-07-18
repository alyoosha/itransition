<?php


namespace App\Parser;


use CallbackFilterIterator;

class Parser
{
	/**
	 * @var CallbackFilterIterator
	 */
	protected $reader;

	/**
	 * @var array
	 */
	protected $data = ['all' => 0, 'success' => 0, 'error' => 0, 'product' => []];

	/**
	 * @var int $count_all Количество обработанных продуктов
	 */
	protected $count_all = 0;

	/**
	 * @var int Количество успешно обработанных продуктов
	 */
	protected $count_success = 0;

	/**
	 * @var int Количество пропущенных обработанных продуктов
	 */
	protected $count_error = 0;

	/**
	 * @var int Количество некорректных продуктов
	 */
	protected $count_incorrect = 0;

	public function __construct(array $reader)
	{
		$this->reader = $reader;
	}

	public function parse(): array {
		$first_row = [];

		//Перебираем массив из данных, полученых из CSV
		foreach ($this->reader as $key => $row) {
			if(!is_array($row)) continue;

			$code = '';
			$name = '';

			$this->data['all'] = ++$this->count_all;

			//Пропускаем строку с названиеями столбцов
			if($key == 0) {
				$first_row = $row;
				continue;
			}

			//Пропускаем строку, если длина массива не равна длине строки с заголовками
			if(count($row) !== count($first_row)) {
				$this->data['error'] = ++$this->count_error;

				if(isset($row[0])) $code = $row[0];
				if(isset($row[1])) $name = $row[1];

				$this->data['incorrect'][] = "Код продукта: $code, Название продукта: $name";
				continue;
			}

			//Пропускаем строку, если кол-во продукта меньше 10
			if($row[3] < 10) {
				$this->data['error'] = ++$this->count_error;
				continue;
			}

			//Пропускаем строку, если цена продукта меньше 5 или больше 1000
			if($row[4] < 5 || $row[4] > 1000) {
				$this->data['error'] = ++$this->count_error;
				continue;
			}

			//Если указано, что продукт снят с производства, помечаем датой снятия
			$row[5] = $row[5] != '' ? $row[5] = new \DateTime() : null;

			$this->data['products'][] = $row;
			$this->data['success'] = ++$this->count_success;
		}

		return $this->data;
	}
}