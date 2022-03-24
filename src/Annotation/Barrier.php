<?php

declare(strict_types=1);
/**
 * This file is part of DTM-PHP.
 *
 * @license  https://github.com/dtm-php/dtm-client/blob/master/LICENSE
 */
namespace DtmClient\Annotation;

use Hyperf\Di\Annotation\AbstractAnnotation;

/**
 * @Annotation
 * @Target("METHOD")
 * Class Barrier
 */
class Barrier extends AbstractAnnotation
{
    public string $dbType = 'mysql';

    public function __construct(string $dbType = 'mysql')
    {
    }
}
