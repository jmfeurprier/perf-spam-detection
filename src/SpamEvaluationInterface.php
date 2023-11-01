<?php

namespace perf\SpamDetection;

interface SpamEvaluationInterface
{
    public function isSpam(): bool;

    public function getScore(): int;

    /**
     * @return SpamKeywordInterface[]
     */
    public function getMatchedKeywords(): iterable;
}
