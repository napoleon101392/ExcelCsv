<?php

namespace Napoleon\ExcelCsv;

use RuntimeException;
use InvalidArgumentException;

// (new Csv)->data([])->get()
// (new Csv)->file()->data()->get()
// (new Csv)->file()->data()->filter([])->get()
class Csv
{
    /**
     * Path to CSV file
     *
     * @var string
     */
    protected $file = null;

    /**
     * To catch filters
     *
     * @var array
     */
    protected $filters = [];

    /**
     * To check string that contains what
     *
     * @var array
     */
    protected $contains = [];

    /**
     * Path to CSV file
     *
     * @param string $file
     * @return self
     */
    public function file($file)
    {
        if (!is_string($file) || !file_exists($file)) {
            throw new InvalidArgumentException('Invalid file path provided.');
        }

        $this->file = $file;

        return $this;
    }

    public function contains(array $contains)
    {
        $this->contains = $contains;

        return $this;
    }

    /**
     * Conditions to be checked
     *
     * @param array $filters
     * @return self
     */
    public function filter(array $filters)
    {
        $this->filters = $filters;

        return $this;
    }

    /**
     * Get array of data from csv
     *
     * @return array
     */
    public function get()
    {
        if (empty($this->file)) {
            throw new RuntimeException('No CSV file specified.');
        }

        if (($handle = fopen($this->file, 'r')) === false) {
            throw new RuntimeException('Error reading CSV file');
        }
        
        $headers = fgetcsv($handle);

        $data = [];
        while (($row = fgetcsv($handle)) !== false) {
            $data[] = array_combine($headers, $row);
        }

        fclose($handle);

        if (!empty($this->contains)) {
            return self::checkContains($data);
        }
        
        if (!empty($this->filters)) {
            return self::search($data);
        }

        return $data;
    }

    /**
     * check if has contains
     *
     * @param [type] $data
     * @return void
     */
    private function checkContains($data)
    {
        $filteredData = [];
        foreach ($data as $row) {
            $conditions = [];
            foreach($this->contains as $column => $value) {
                $conditions[] = strstr($row[$column], $value);
            }

            if (!in_array(false, $conditions)) {
                $filteredData[] = $row;
            }
        }

        if (empty($filteredData)) {
            throw new RuntimeException('No matching rows found.');
        }

        return $filteredData;
    }

    /**
     * Search for a specific column and value
     *
     * @param array $data
     * @return array
     */
    private function search($data)
    {
        $filteredData = [];
        foreach ($data as $row) {
            $conditions = [];
            foreach($this->filters as $column => $value) {
                $conditions[] = $row[$column] === $value;
            }

            if (!in_array(false, $conditions)) {
                $filteredData[] = $row;
            }
        }

        if (empty($filteredData)) {
            throw new RuntimeException('No matching rows found.');
        }

        return $filteredData;
    }
}
