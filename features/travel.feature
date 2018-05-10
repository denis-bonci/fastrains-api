Feature:
  In order to receive a travel itinerary
  As anonimous user
  I want to receive a travel itinerary

  Scenario: It receive a travel itinerary
    Given an api rest
    When i send a requesto to "/travel" with departure to "RM" and arrival to "TO"
    Then i receive a travel itinerary with 1 change