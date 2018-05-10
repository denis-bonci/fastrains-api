Feature:
  In order to get enabled stations list
  As anonimous user
  I want to receive the stations list in json format

  Scenario: It receive a stations list in json format
    Given an api rest
    When sends a request to "/stations"
    Then i receive a stations list