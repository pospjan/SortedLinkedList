<?php declare(strict_types = 1);

namespace Posp\SortedLinkedList;

final class SortedLinkedList implements \Iterator, \Countable
{

    public const SORT_ASC = 1;
    public const SORT_DESC = 2;

    public ?Node $head = null;

    private int $position = 0;

    private int $sortOrder;

    public function __construct(
        int $sortOrder = self::SORT_ASC
    )
    {
        if ($sortOrder !== self::SORT_ASC && $sortOrder !== self::SORT_DESC) {
            throw new \InvalidArgumentException('Unknown sort order.');
        }

        $this->sortOrder = $sortOrder;
    }

    public function addItem(int|string $item): self
    {
        if ($this->head !== null && gettype($this->head->value) !== gettype($item)) {
            throw new \InvalidArgumentException('List can contain integers or strings, but not both.');
        }

        if ($this->head === null) {
            $this->head = new Node($item, null);
        } elseif ($this->compare($item, $this->head->value)) {
            $this->head = new Node($item, $this->head);
        } else {
            $currentNode = $this->head;

            while ($currentNode->next !== null && $this->compare($currentNode->next->value, $item)) {
                $currentNode = $currentNode->next;
            }

            $currentNode->next = new Node($item, $currentNode->next);
        }

        return $this;
    }

    public function removeItem(int|string $item): self
    {
        if ($this->head === null) {
            return $this;
        }

        $currentNode = $this->head;
        $nodeWithPreviousValue = null;
        $removing = false;
        while ($currentNode !== null) {
            if ($currentNode->value === $item) {
                $removing = true;
                if ($currentNode === $this->head && $currentNode->next === null) {
                    $this->head = null;
                    break;
                }
                if ($nodeWithPreviousValue === null) {
                    $this->head = $currentNode->next;
                } else {
                    $nodeWithPreviousValue->next = $currentNode->next;
                }

            }

            if (!$removing) {
                $nodeWithPreviousValue = $currentNode;
            }

            // we can stop searching when we reach higher/lower values then item being searched
            if ($this->compare($item, $currentNode->value)) {
                break;
            }

            $currentNode = $currentNode->next;

        }

        return $this;
    }

    private function compare(int|string $a, int|string $b): bool
    {
        if ($this->head !== null && gettype($this->head->value) === 'string') {
            if ($this->sortOrder === self::SORT_ASC) {
                return strcmp((string) $a, (string) $b) === -1;
            }
            return strcmp((string) $a, (string) $b) === 1;
        }

        if ($this->sortOrder === self::SORT_ASC) {
            return $a < $b;
        }
        return $a > $b;
    }

    /**
     * Intentionally not using Stringable interface
     * and __toString() method. This "list visualisation" is only for debugging
     */
    public function getAsString(): string
    {
        $ret = '';
        $currentNode = $this->head;

        while ($currentNode !== null) {
            $ret .= ',' . $currentNode->value;
            $currentNode = $currentNode->next;
        }

        return trim($ret, ',');
    }

    public function current(): Node
    {
        $i = 0;
        $currentNode = $this->head;
        while ($currentNode !== null) {
            if ($i === $this->position) {
                return $currentNode;
            }
            $currentNode = $currentNode->next;
            $i++;
        }

        throw new \OutOfBoundsException();
    }

    public function next(): void
    {
        $this->position++;
    }

    public function key(): int
    {
        return $this->position;
    }

    public function valid(): bool
    {
        $i = 0;
        $currentNode = $this->head;
        while ($currentNode !== null) {
            if ($i === $this->position) {
                return true;
            }
            $currentNode = $currentNode->next;
            $i++;
        }

        return false;
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function count(): int
    {
        $count = 0;
        $currentNode = $this->head;
        while ($currentNode !== null) {
            $currentNode = $currentNode->next;
            $count++;
        }

        return $count;
    }

}
