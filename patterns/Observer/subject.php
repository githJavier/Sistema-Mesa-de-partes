<?php

namespace Patterns\Observer;

interface Subject {
    public function attach(Observer $observer): void;
    public function detach(Observer $observer): void;
    public function notify(array $data): void;
}
