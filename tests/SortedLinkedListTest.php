<?php declare(strict_types = 1);

namespace Posp\SortedLinkedList;

use PHPUnit\Framework\TestCase;

class SortedLinkedListTest extends TestCase
{

    public function testEmptyListShouldBeEmpty(): void
    {
        $sortedLinkedList = new SortedLinkedList();
        self::assertCount(0, $sortedLinkedList);
        self::assertSame('', $sortedLinkedList->getAsString());
    }

    public function testMultipleIntegersCanBeAddedAndSorted(): void
    {
        $sortedLinkedList = new SortedLinkedList();
        $sortedLinkedList->addItem(1);
        $sortedLinkedList->addItem(3);
        $sortedLinkedList->addItem(2);
        self::assertCount(3, $sortedLinkedList);
        self::assertSame('1,2,3', $sortedLinkedList->getAsString());
    }

    public function testMultipleIntegersSomeOfThemWithSameValueCanBeAddedAndSorted(): void
    {
        $sortedLinkedList = new SortedLinkedList();
        $sortedLinkedList->addItem(1);
        $sortedLinkedList->addItem(3);
        $sortedLinkedList->addItem(2);
        $sortedLinkedList->addItem(1);
        $sortedLinkedList->addItem(1);
        $sortedLinkedList->addItem(3);
        self::assertCount(6, $sortedLinkedList);
        self::assertSame('1,1,1,2,3,3', $sortedLinkedList->getAsString());
    }

    public function testMultipleIntegersCanBeAddedAndSortedInReverseOrder(): void
    {
        $sortedLinkedList = new SortedLinkedList(
            SortedLinkedList::SORT_DESC
        );
        $sortedLinkedList->addItem(1);
        $sortedLinkedList->addItem(3);
        $sortedLinkedList->addItem(2);
        self::assertCount(3, $sortedLinkedList);
        self::assertSame('3,2,1', $sortedLinkedList->getAsString());
    }

    public function testMultipleStringsCanBeAddedAndSorted(): void
    {
        $sortedLinkedList = new SortedLinkedList();
        $sortedLinkedList->addItem('a');
        $sortedLinkedList->addItem('c');
        $sortedLinkedList->addItem('b');
        self::assertCount(3, $sortedLinkedList);
        self::assertSame('a,b,c', $sortedLinkedList->getAsString());
    }

    public function testInvalidSortOrderCantByUsed(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Unknown sort order.');

        new SortedLinkedList(123);
    }

    public function testStringsIntegersCanBeAdded(): void
    {
        $sortedLinkedList = new SortedLinkedList();
        $sortedLinkedList->addItem('a');
        $sortedLinkedList->addItem('b');
        self::assertCount(2, $sortedLinkedList);
        self::assertSame('a,b', $sortedLinkedList->getAsString());
    }

    public function testIntegerCantBeAddedToStringList(): void
    {
        $sortedLinkedList = new SortedLinkedList();
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('List can contain integers or strings, but not both.');
        $sortedLinkedList->addItem('a');
        $sortedLinkedList->addItem(1);
    }

    public function testStringCantBeAddedToIntegerList(): void
    {
        $sortedLinkedList = new SortedLinkedList();
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('List can contain integers or strings, but not both.');
        $sortedLinkedList->addItem(1);
        $sortedLinkedList->addItem('a');
    }

    public function testItemCouldBeRemoved(): void
    {
        $sortedLinkedList = new SortedLinkedList();
        $sortedLinkedList->addItem(1);
        $sortedLinkedList->addItem(3);
        $sortedLinkedList->addItem(2);
        self::assertCount(3, $sortedLinkedList);
        self::assertSame('1,2,3', $sortedLinkedList->getAsString());

        $sortedLinkedList->removeItem(2);
        self::assertCount(2, $sortedLinkedList);
        self::assertSame('1,3', $sortedLinkedList->getAsString());

        $sortedLinkedList->removeItem(3);
        self::assertCount(1, $sortedLinkedList);
        self::assertSame('1', $sortedLinkedList->getAsString());

        $sortedLinkedList->removeItem(1);
        self::assertCount(0, $sortedLinkedList);
        self::assertSame('', $sortedLinkedList->getAsString());

        $sortedLinkedList->addItem(1);
        $sortedLinkedList->addItem(2);
        self::assertCount(2, $sortedLinkedList);
        self::assertSame('1,2', $sortedLinkedList->getAsString());

        $sortedLinkedList->removeItem(1);
        self::assertCount(1, $sortedLinkedList);
        self::assertSame('2', $sortedLinkedList->getAsString());
    }

    public function testMultipleItemOfSameValueCouldBeRemoved(): void
    {
        $sortedLinkedList = new SortedLinkedList();
        $sortedLinkedList->addItem(1);
        $sortedLinkedList->addItem(1);
        $sortedLinkedList->addItem(3);
        $sortedLinkedList->addItem(3);
        $sortedLinkedList->addItem(2);
        $sortedLinkedList->addItem(2);
        self::assertCount(6, $sortedLinkedList);
        self::assertSame('1,1,2,2,3,3', $sortedLinkedList->getAsString());

        $sortedLinkedList->removeItem(2);
        self::assertCount(4, $sortedLinkedList);
        self::assertSame('1,1,3,3', $sortedLinkedList->getAsString());

        $sortedLinkedList->removeItem(3);
        self::assertCount(2, $sortedLinkedList);
        self::assertSame('1,1', $sortedLinkedList->getAsString());

        $sortedLinkedList->removeItem(1);
        self::assertCount(0, $sortedLinkedList);
        self::assertSame('', $sortedLinkedList->getAsString());
    }

    public function testMultipleItemOfSameValueFromDescendingListCouldBeRemoved(): void
    {
        $sortedLinkedList = new SortedLinkedList(SortedLinkedList::SORT_DESC);
        $sortedLinkedList->addItem(1);
        $sortedLinkedList->addItem(1);
        $sortedLinkedList->addItem(3);
        $sortedLinkedList->addItem(3);
        $sortedLinkedList->addItem(2);
        $sortedLinkedList->addItem(2);
        self::assertCount(6, $sortedLinkedList);
        self::assertSame('3,3,2,2,1,1', $sortedLinkedList->getAsString());

        $sortedLinkedList->removeItem(2);
        self::assertCount(4, $sortedLinkedList);
        self::assertSame('3,3,1,1', $sortedLinkedList->getAsString());

        $sortedLinkedList->removeItem(3);
        self::assertCount(2, $sortedLinkedList);
        self::assertSame('1,1', $sortedLinkedList->getAsString());

        $sortedLinkedList->removeItem(1);
        self::assertCount(0, $sortedLinkedList);
        self::assertSame('', $sortedLinkedList->getAsString());
    }

    public function testRemovingOfNonExistingItemShouldBeValid(): void
    {
        $sortedLinkedList = new SortedLinkedList();
        $sortedLinkedList->addItem(1);
        $sortedLinkedList->addItem(3);
        $sortedLinkedList->addItem(2);
        self::assertCount(3, $sortedLinkedList);
        self::assertSame('1,2,3', $sortedLinkedList->getAsString());

        $sortedLinkedList->removeItem(10);
        self::assertCount(3, $sortedLinkedList);
        self::assertSame('1,2,3', $sortedLinkedList->getAsString());
    }

    public function testItemCouldBeRemovedEvenFromEmptyList(): void
    {
        $sortedLinkedList = new SortedLinkedList();
        self::assertCount(0, $sortedLinkedList);
        self::assertSame('', $sortedLinkedList->getAsString());

        $sortedLinkedList->removeItem(30);
        self::assertCount(0, $sortedLinkedList);
        self::assertSame('', $sortedLinkedList->getAsString());
    }

    public function testListCanBeIterated(): void
    {
        $sortedLinkedList = new SortedLinkedList();
        $sortedLinkedList->addItem('a');
        $sortedLinkedList->addItem('c');
        $sortedLinkedList->addItem('b');

        $items = [];
        foreach ($sortedLinkedList as $node) {
            $items[] = $node->value;
        }

        self::assertSame(['a', 'b', 'c'], $items);
    }

}
