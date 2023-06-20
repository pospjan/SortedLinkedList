<?php declare(strict_types = 1);

namespace Posp\SortedLinkedList;

class Node
{

    public function __construct(
        readonly public int|string $value,
        public ?Node $next
    )
    {
    }

}
