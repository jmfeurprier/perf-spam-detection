<?php

namespace perf\SpamDetection;

class SpamNotDetected extends SpamEvaluationBase
{
    public function isSpam(): bool
    {
        return false;
    }
}
