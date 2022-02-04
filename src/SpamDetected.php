<?php

namespace perf\SpamDetection;

class SpamDetected extends SpamEvaluationBase
{
    public function isSpam(): bool
    {
        return true;
    }
}
