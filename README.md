# ExcelCsv

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
  ->exact()
  ->get()

response: [['name' => 'jane', 'age'  => 36]]
```

## Todo
- include Excel file
- able to sort
- able to calculate
- Ordering by column
- can merge data
