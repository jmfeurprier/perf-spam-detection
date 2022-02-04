<?php

namespace perf\SpamDetection;

class SpamEvaluator implements SpamEvaluatorInterface
{
    private const CHARSET_DEFAULT = 'UTF-8';

    private SpamKeywordRepositoryInterface $spamKeywordRepository;

    private int $spamScoreThreshold;

    private string $charset;

    private string $string;

    private int $spamScore;

    private array $matchedKeywords;

    public function __construct(
        SpamKeywordRepositoryInterface $spamKeywordRepository,
        int $spamScoreThreshold,
        string $charset = self::CHARSET_DEFAULT
    ) {
        $this->spamKeywordRepository = $spamKeywordRepository;
        $this->spamScoreThreshold    = $spamScoreThreshold;
        $this->charset               = $charset;
    }

    public function evaluate(string $string): SpamEvaluationInterface
    {
        $this->init($string);

        foreach ($this->getSpamKeywords() as $spamKeyword) {
            $this->processSpamKeyword($spamKeyword);
        }

        if ($this->isSpamDetected()) {
            return $this->spamDetected();
        }

        return $this->spamNotDetected();
    }

    private function init(string $string): void
    {
        $this->string          = $string;
        $this->spamScore       = 0;
        $this->matchedKeywords = [];
    }

    /**
     * @return SpamKeywordInterface[]
     */
    private function getSpamKeywords(): array
    {
        return $this->spamKeywordRepository->getSpamKeywords();
    }

    private function processSpamKeyword(SpamKeywordInterface $spamKeyword): void
    {
        if (false !== mb_strpos($this->string, $spamKeyword->getPattern(), 0, $this->charset)) {
            $this->spamScore         += $spamKeyword->getScore();
            $this->matchedKeywords[] = $spamKeyword;
        }
    }

    private function isSpamDetected(): bool
    {
        return ($this->spamScore >= $this->spamScoreThreshold);
    }

    private function spamDetected(): SpamEvaluationInterface
    {
        return new SpamDetected($this->spamScore, $this->matchedKeywords);
    }

    private function spamNotDetected(): SpamEvaluationInterface
    {
        return new SpamNotDetected($this->spamScore, $this->matchedKeywords);
    }
}
