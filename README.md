## Installation

```
composer require posp/sorted-linked-list
```

## Usage

```php
<?php
require __DIR__.'/vendor/autoload.php';
use Posp\SortedLinkedList;

$sortedLinkedList = new SortedLinkedList();
```

Default sorting mode is ascending, if you want descending list: 

```php
$sortedLinkedList = new SortedLinkedList(SortedLinkedList::SORT_DESC);
```

Adding items:

```php
$sortedLinkedList->addItem(1); // 1
$sortedLinkedList->addItem(3); // 1->3
$sortedLinkedList->addItem(2); // 1->2->3
```

Removing items:

```php
$sortedLinkedList->removeItem(2); // 1->3
```

```SortedLinkedList``` implements both Countable and Iterator interfaces:

```php
$sortedLinkedList = new SortedLinkedList();
$sortedLinkedList->addItem(1);
$sortedLinkedList->addItem(3);

echo count($sortedLinkedList); // 2

foreach($sortedLinkedList as $item) {
    echo $item; 
}


```





## Tools

Run tests: composer test

Run PhpStan: composer phpstan

Run coding standards: composer cs