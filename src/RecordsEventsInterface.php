<?php

namespace Crawly\EventDispatcher;

interface RecordsEventsInterface
{
    /**
     * @return object[]
     */
    public function getRecordedEvents();

    /**
     * Clears recorded events
     */
    public function clearRecordedEvents();
}
