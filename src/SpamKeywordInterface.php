<?php

namespace perf\SpamDetection;

interface SpamKeywordInterface
{
    public function getPattern(): string;

    public function getScore(): int;
}
