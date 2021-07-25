<?php

namespace Cda0521Framework\Testing\Interfaces;

interface TestCase
{
    function getDescription(): string;
    
    function execute(): void;
}
