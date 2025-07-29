<?php
class TravelFilter {
    private $hotelName;
    private $city;
    private $country;
    private $travelDate;
    private $duration;

    public function __construct(string $hotelName, string $city, string $country, string $travelDate, int $duration) {
        $this->hotelName = htmlspecialchars($hotelName);
        $this->city = htmlspecialchars($city);
        $this->country = htmlspecialchars($country);
        $this->travelDate = htmlspecialchars($travelDate);
        $this->duration = $duration;
    }

    public function getSearchSummary(): string {
        return "Buscando hoteles en {$this->city}, {$this->country}. Hotel: {$this->hotelName}, Fecha: {$this->travelDate}, Duración: {$this->duration} días";
    }
}
?>
