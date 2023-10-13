# ExcelCsv
[![CI](https://github.com/napoleon101392/ExcelCsv/actions/workflows/ci.yml/badge.svg)](https://github.com/napoleon101392/ExcelCsv/actions/workflows/ci.yml)

[![PHP Compatibility](https://github.com/napoleon101392/ExcelCsv/actions/workflows/php.yml/badge.svg)](https://github.com/napoleon101392/ExcelCsv/actions/workflows/php.yml)

Usage:
1. result: ['name' => 'john', 'name' => 'jane']
```php
$data = ['name' => 'john', 'name' => 'jane'];
$csv = (new Csv)->data($data);
$csv->get();
```

2. Gives you array of rows on that csv
```php
return (new Csv)->file('path/to/file.csv')->data()->get();
```

3. consider the table below as csv

| Name        | Age           | Gender  |
| ------------- |:-------------:| -----:|
| John      | 18           | Male |
| Jane      | 36            |   Female |
```php
(new Csv)->file('path/to/file.csv')
  ->data()
  ->filter(['Name' => 'Jane'])
  ->get();
// return [['Name' => 'Jane', 'Age'  => 36, 'Gender' => 'Female']]

(new Csv)->file('path/to/file.csv')
  ->data()
  ->filter(['Name' => 'J'], false)
  ->get();
// return
// [
//  ['Name' => 'John', 'Age'  => 18, 'Gender' => 'Male'],
//  ['Name' => 'Jane', 'Age'  => 36, 'Gender' => 'Female']
// ]
```

## Todo
- include Excel file
- able to sort
- able to calculate
- Ordering by column
- can merge data
- Convert array to csv/excel
