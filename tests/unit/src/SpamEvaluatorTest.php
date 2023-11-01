<?php

namespace perf\SpamDetection;

use PHPUnit\Framework\TestCase;

class SpamEvaluatorTest extends TestCase
{
    /**
     * @var SpamKeywordInterface[]
     */
    private iterable $spamKeywords = [];

    private int $spamScoreThreshold;

    private SpamEvaluationInterface $evaluation;

    public function testEvaluateWithEmptySpamKeywordRepository(): void
    {
        $this->givenSpamScoreThreshold(123);

        $this->whenEvaluate('foo');

        $this->thenNotSpam();
        $this->thenScore(0);
        $this->thenMatchedSpamKeywordCount(0);
    }

    public function testEvaluateWithOneMatchedSpamKeywordBelowThreshold(): void
    {
        $this->givenSpamKeyword('foo', 100);
        $this->givenSpamScoreThreshold(123);

        $this->whenEvaluate('foo');

        $this->thenNotSpam();
        $this->thenScore(100);
        $this->thenMatchedSpamKeywordCount(1);
    }

    public function testEvaluateWithOneMatchedSpamKeywordAboveThreshold(): void
    {
        $this->givenSpamKeyword('foo', 200);
        $this->givenSpamScoreThreshold(123);

        $this->whenEvaluate('foo');

        $this->thenSpam();
        $this->thenScore(200);
        $this->thenMatchedSpamKeywordCount(1);
    }

    public function testEvaluateWithBothMatchedAndUnmatchedSpamKeywords(): void
    {
        $this->givenSpamKeyword('foo', 100);
        $this->givenSpamKeyword('bar', 200);
        $this->givenSpamScoreThreshold(150);

        $this->whenEvaluate('foo');

        $this->thenNotSpam();
        $this->thenScore(100);
        $this->thenMatchedSpamKeywordCount(1);
    }

    private function givenSpamKeyword(
        string $pattern,
        int $score
    ): void {
        $spamKeyword = $this->createMock(SpamKeywordInterface::class);
        $spamKeyword->method('getPattern')->willReturn($pattern);
        $spamKeyword->method('getScore')->willReturn($score);

        $this->spamKeywords[] = $spamKeyword;
    }

    private function givenSpamScoreThreshold(int $threshold): void
    {
        $this->spamScoreThreshold = $threshold;
    }

    private function whenEvaluate(string $string): void
    {
        $spamKeywordRepository = $this->createMock(SpamKeywordRepositoryInterface::class);
        $spamKeywordRepository->method('getSpamKeywords')->willReturn($this->spamKeywords);

        $evaluator = new SpamEvaluator(
            $spamKeywordRepository,
            $this->spamScoreThreshold
        );

        $this->evaluation = $evaluator->evaluate($string);
    }

    private function thenSpam(): void
    {
        $this->assertTrue($this->evaluation->isSpam());
    }

    private function thenNotSpam(): void
    {
        $this->assertFalse($this->evaluation->isSpam());
    }

    private function thenScore(int $score): void
    {
        $this->assertSame($score, $this->evaluation->getScore());
    }

    private function thenMatchedSpamKeywordCount(int $count): void
    {
        $this->assertCount($count, $this->evaluation->getMatchedKeywords());
    }
}
