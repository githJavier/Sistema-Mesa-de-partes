<?php
// controllers/Command/BaseCommand.php

namespace Command;

interface CommandInterface {
    public function execute(): array;
}

abstract class BaseCommand implements CommandInterface {
    protected $params;
    
    public function __construct(array $params = []) {
        $this->params = $params;
    }
    
    abstract public function execute(): array;
}