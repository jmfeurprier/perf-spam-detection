<?php

namespace perf\SpamDetection;

interface SpamKeywordRepositoryInterface
{
    /**
     * @return SpamKeywordInterface[]
     */
    public function getSpamKeywords(): array;
}
