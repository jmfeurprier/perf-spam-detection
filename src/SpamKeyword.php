<?php

namespace perf\SpamDetection;

readonly class SpamKeyword implements SpamKeywordInterface
{
    public function __construct(
        private string $pattern,
        private int $weight,
    ) {
    }

    public function getPattern(): string
    {
        return $this->pattern;
    }

    public function getScore(): int
    {
        return $this->weight;
    }
}
