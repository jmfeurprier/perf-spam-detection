Spam detection
==============

Allows detection of spam from contact forms, etc.

## Installation

```shell script
composer require perf/spam-detection
```

## Configuration

Implement a spam key word repository, such as this one:

```php
use perf\SpamDetection\SpamKeyword;
use perf\SpamDetection\SpamKeywordRepositoryInterface;

class SpamKeywordRepository implements SpamKeywordRepositoryInterface
{
    public function getSpamKeywords(): iterable
    {
        return [
            new SpamKeyword('viagra', 150),
            new SpamKeyword('casino', 100),
        ];       
    }
}
```

## Usage

Now you can detect spam:

```php
use perf\SpamDetection\SpamEvaluator;

$spamEvaluator = new SpamEvaluator(
    new SpamKeywordRepository(),
    100 // Threshold
);

$submittedContent = 'Buy Viagra, and then go to the casino.'

$outcome = $spamEvaluator->evaluate($submittedContent);

if ($outcome->isSpam()) {
    echo "This is definitely spam.";
}
```
