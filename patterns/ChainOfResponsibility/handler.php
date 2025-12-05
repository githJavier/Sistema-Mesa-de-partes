<?php

namespace Patterns\ChainOfResponsibility;

interface Handler {
    public function setNext(Handler $handler): Handler;
    public function handle(array $request);
}
