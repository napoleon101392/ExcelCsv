<?php

namespace Napoleon\ExcelCsv;

use RuntimeException;
use InvalidArgumentException;

// (new Csv)->data([])->get()
// (new Csv)->file()->data()->get()
// (new Csv)->file()->data()->filter([])->exact()->get()
class Csv
{
    /**
     * Path to CSV file
     *
     * @var string
     */
    protected $file = null;

    /**
     * filter type
     * 
     * true: Exact match of a string
     * false: String contains
     * 
     * @var boolean
     */
    protected $exact = true;

    /**
     * To catch filters
     *
     * @var array
     */
    protected $filters = [];

    /**
     * Constructed data from file
     *
     * @var array
     */
    protected $data = [];

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

    /**
     * Construct file
     *
     * @return void
     */
    public function data(array $data = [])
    {
        if (!empty($data)) {
            $this->data = $data;

            return $this;
        }

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

        $this->data = $data;

        return $this;
    }

    /**
     * To set the filter options
     *
     * @param boolean $exact
     * @return void
     */
    public function exact(bool $exact = true)
    {
        $this->exact = $exact;

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

        if (empty($this->data)) {
            throw new RuntimeException('Run the data() first');
        }

        self::search();

        return $this;
    }

    /**
     * Get array of data from csv
     *
     * @return array
     */
    public function get()
    {
        return $this->data;
    }

    /**
     * Search for a specific column and value
     *
     * @param array $data
     * @return array
     */
    private function search()
    {
        $filteredData = [];

        foreach ($this->data as $row) {
            $conditions = [];
            foreach($this->filters as $column => $value) {
                $conditions[] = $this->exact ? $row[$column] === $value : strstr($row[$column], $value);
            }

            if (!in_array(false, $conditions)) {
                $filteredData[] = $row;
            }
        }

        $this->data = $filteredData;

        return $this;
    }
}
