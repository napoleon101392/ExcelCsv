# ExcelCsv
[![CI](https://github.com/napoleon101392/ExcelCsv/actions/workflows/ci.yml/badge.svg)](https://github.com/napoleon101392/ExcelCsv/actions/workflows/ci.yml)

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
return (new Csv)->file('path/to/file.csv')
  ->data()
  ->filter(['name' => 'jane'])
  ->get();

response: [['Name' => 'Jane', 'Age'  => 36, 'Gender' => 'Female']]
```

## Todo
- include Excel file
- able to sort
- able to calculate
- Ordering by column
- can merge data
- Convert array to csv/excel
