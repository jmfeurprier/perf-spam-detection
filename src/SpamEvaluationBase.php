<?php

namespace perf\SpamDetection;

abstract class SpamEvaluationBase implements SpamEvaluationInterface
{
    /**
     * @param SpamKeywordInterface[] $matchedKeywords
     */
    public function __construct(
        private readonly int $score,
        private readonly iterable $matchedKeywords = []
    ) {
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function getMatchedKeywords(): iterable
    {
        return $this->matchedKeywords;
    }
}
