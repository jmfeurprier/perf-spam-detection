<?php

namespace perf\SpamDetection;

abstract class SpamEvaluationBase implements SpamEvaluationInterface
{
    private int $score;

    /**
     * @var SpamKeywordInterface[]
     */
    private array $matchedKeywords;

    /**
     * @param SpamKeywordInterface[] $matchedKeywords
     */
    public function __construct(
        int $score,
        array $matchedKeywords = []
    ) {
        $this->score           = $score;
        $this->matchedKeywords = $matchedKeywords;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    /**
     * {@inheritDoc}
     */
    public function getMatchedKeywords(): array
    {
        return $this->matchedKeywords;
    }
}
