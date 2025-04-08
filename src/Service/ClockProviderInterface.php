<?php

namespace IWF\ClockProviderBundle\Service;

interface ClockProviderInterface
{
    /**
     * Setzt ein neues Datum in der Session
     *
     * @param string $dateString Datum im Format YYYY-MM-DD
     * @return bool True wenn erfolgreich, False wenn nicht
     */
    public function modify(string $dateString): bool;

    /**
     * Setzt das Datum basierend auf Anfrage-Event
     *
     * @return bool True wenn erfolgreich, False wenn nicht
     */
    public function modifyOnRequestEvent(): bool;

    /**
     * Entfernt das Datum aus der Session
     *
     * @return bool True wenn erfolgreich, False wenn nicht
     */
    public function reset(): bool;

    /**
     * Prüft, ob die Zeit angepasst werden kann
     *
     * @return bool True wenn die Zeit angepasst werden kann
     */
    public function canModifyTime(): bool;

    /**
     * Holt das aktuelle Datum aus der Session (falls vorhanden)
     *
     * @return string|null Datum im Format YYYY-MM-DD oder null
     */
    public function getSessionDate(): ?string;
}