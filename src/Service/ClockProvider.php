<?php

namespace IWF\ClockProviderBundle\Service;

use DateTimeImmutable;
use DateTimeZone;
use Symfony\Component\Clock\ClockInterface;
use Symfony\Component\Clock\DatePoint;
use Symfony\Component\Clock\MockClock;
use Symfony\Component\HttpFoundation\Exception\SessionNotFoundException;
use Symfony\Component\HttpFoundation\RequestStack;

class ClockProvider implements ClockProviderInterface
{
    private ClockInterface $clock;
    private string $sessionKey;
    private string $queryParam;
    private RequestStack $requestStack;

    public function __construct(
        ClockInterface $clock,
        string         $sessionKey,
        string         $queryParam,
        RequestStack   $requestStack
    )
    {
        $this->clock = $clock;
        $this->sessionKey = $sessionKey;
        $this->queryParam = $queryParam;
        $this->requestStack = $requestStack;
    }

    /**
     * Setzt ein neues Datum in der Session
     */
    public function modify(string $dateString): bool
    {
        if (!$this->canModifyTime()) {
            return false;
        }

            $date = \DateTimeImmutable::createFromFormat('Y-m-d', $dateString);

            if ($date === false) {
                throw new \InvalidArgumentException('Ungültiges Datumsformat. Format: YYYY-MM-DD');
            }
            try {
                $session = $this->requestStack->getSession();
                $session->set($this->sessionKey, $date->format('Y-m-d'));
            } catch (SessionNotFoundException $e) {
                // there is no session when calling from tests
            }

            if (!$this->clock instanceof MockClock) {
                return false;
            }

            $this->clock->modify($date->format('Y-m-d H:i:s'));

            return true;
    }

    public function modifyOnRequestEvent(): bool
    {
        $session = $this->requestStack->getSession();
        $query = $this->requestStack->getCurrentRequest()->query;

        if ($session->has($this->sessionKey)) {
            $dateString = $session->get($this->sessionKey);
        } elseif ($query->has($this->queryParam)) {
            $dateString = $query->get($this->queryParam);
        } else {
            return false;
        }
        $date = \DateTimeImmutable::createFromFormat('Y-m-d', $dateString);
        try {
            $this->clock->modify($date->format('Y-m-d H:i:s'));
            $session->set($this->sessionKey, $dateString);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Entfernt das Datum aus der Session
     */
    public function reset(): bool
    {
        $session = $this->requestStack->getSession();

        if ($session->has($this->sessionKey)) {
            $session->remove($this->sessionKey);

            // Zurück auf aktuelle Zeit setzen
            if ($this->clock instanceof MockClock) {
                $now = new \DateTimeImmutable();
                $this->clock->modify($now->format('Y-m-d H:i:s'));
            }

            return true;
        }

        return false;
    }

    /**
     * Prüft, ob die Zeit angepasst werden kann
     */
    public function canModifyTime(): bool
    {
        return $this->clock instanceof MockClock;
    }

    /**
     * Holt das aktuelle Datum aus der Session (falls vorhanden)
     */
    public function getSessionDate(): ?string
    {
        $session = $this->requestStack->getSession();

        if ($session->has($this->sessionKey)) {
            return $session->get($this->sessionKey, null);
        }

        return null;
    }

    /**
     * Gibt die aktuelle Zeit zurück
     */
    public function now(): DateTimeImmutable {
        return $this->clock->now();
    }

    public function sleep(float|int $seconds): void {
        $this->clock->sleep($seconds);
    }

    public function withTimeZone(\DateTimeZone|string $timezone): static {
        $this->clock->withTimeZone($timezone);
    }
}