<?php

namespace IWF\ClockProviderBundle\Service;

interface ClockProviderInterface
{
    /**
     * Sets a new date in the session
     *
     * @param string $dateString Date im format YYYY-MM-DD
     * @return bool
     */
    public function modify(string $dateString): bool;

    /**
     * Sets the date based on request event
     *
     * @return bool
     */
    public function modifyOnRequestEvent(): bool;

    /**
     * Removes the date from the session
     *
     * @return bool
     */
    public function reset(): bool;

    /**
     * Checks whether the time can be adjusted
     *
     * @return bool
     */
    public function canModifyTime(): bool;

    /**
     * Retrieves the current date from the session (if available)
     *
     * @return string|null Date in format YYYY-MM-DD oder null
     */
    public function getSessionDate(): ?string;
}