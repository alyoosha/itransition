<?php

namespace App\Tests\Parser;

use App\Parser\Parser;
use League\Csv\Reader;
use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase
{
	/**
	 * @dataProvider parserProvider
	 */
    public function testParse($data): void
    {
	    $this->assertIsArray($data);
	    $parser = new Parser($data);
        $this->assertIsArray($parser->parse());
    }

    public function parserProvider() {
	    $reader = Reader::createFromPath(dirname(__DIR__) . '/../public/stock.csv');

	    return [
    		[
    			[$reader],
    			[Parser::class],
			    [null],
			    [[]],
			    [true],
			    [1],
			    ['1'],
			    [1,1],
    			[[1,'1'], ['1', '1']],
    			[[1,'1'], ['1', '1', '1', '1', '1']],
    			[[1,'1'], ['1', '1', '1', '1', '1', '1'],[1, [], [1,'2',], '1', '1', null]],
    			[['a' => 1, 'b' => [], ['c' => 1,'2',], '1', '1']],
		    ]
	    ];
    }
}
