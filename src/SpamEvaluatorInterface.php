<?php

namespace perf\SpamDetection;

interface SpamEvaluatorInterface
{
    public function evaluate(string $string): SpamEvaluationInterface;
}
