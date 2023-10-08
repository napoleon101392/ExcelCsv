<?php

namespace Napoleon\ExcelCsv;

use Napoleon\ExcelCsv\Csv;
use PHPUnit\Framework\TestCase;

class CsvTest extends TestCase
{
    public function test_should_return_invalidargumentexception_no_file()
    {
        try {
            (new Csv())->file('path/to/file')->data()->get();
        } catch (\InvalidArgumentException $e) {
            $this->assertSame('Invalid file path provided.', $e->getMessage());
        }
    }

    public function test_should_return_invalidargumentexception_array_data()
    {
        try {
            (new Csv())->file([])->data()->get();
        } catch (\InvalidArgumentException $e) {
            $this->assertSame('Invalid file path provided.', $e->getMessage());
        }
    }

    public function test_return_data()
    {
        $data = (new Csv())->data(['test' => 'one'])->get();

        $this->assertTrue(is_array($data));
    }

    public function test_convert_csv_to_array()
    {
        $csv = __DIR__ . "/file.csv";

        $csvData = (new Csv())->file($csv)->data()->get();

        $this->assertTrue(is_array($csvData));
    }

    public function test_can_filter_exact_true()
    {
        $csv = __DIR__ . "/file.csv";

        $csvData = (new Csv())->file($csv)->data()->filter(['City' => 'Youngstown'])->get();

        $this->assertEquals($csvData[0]['State'], ' OH');
        $this->assertTrue(!empty($csvData));
    }

    public function test_can_filter_exact_false()
    {
        $csv = __DIR__ . "/file.csv";

        $csvData = (new Csv())->file($csv)->data()->filter(['City' => 'Topeka'])->exact(false)->get();

        $this->assertEquals($csvData[0]['State'], ' KS');
        $this->assertTrue(!empty($csvData));
    }
}
