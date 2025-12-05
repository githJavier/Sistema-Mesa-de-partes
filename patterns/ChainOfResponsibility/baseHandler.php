<?php

namespace Patterns\ChainOfResponsibility;

abstract class BaseHandler implements Handler {

    protected ?Handler $next = null;

    public function setNext(Handler $handler): Handler {
        $this->next = $handler;
        return $handler;  // Permite encadenar → $a->setNext($b)->setNext($c)
    }

    public function handle(array $request) {
        if ($this->next) {
            return $this->next->handle($request);
        }

        return $request;
    }
}
