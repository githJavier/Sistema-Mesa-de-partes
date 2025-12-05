<?php

namespace Patterns\Observer;

class TramiteSubject implements Subject {

    private array $observers = [];

    public function attach(Observer $observer): void {
        $this->observers[] = $observer;
    }

    public function detach(Observer $observer): void {
        foreach ($this->observers as $key => $obs) {
            if ($obs === $observer) {
                unset($this->observers[$key]);
            }
        }
    }

    public function notify(array $data): void {
        foreach ($this->observers as $observer) {
            $observer->update($data);
        }
    }
}
