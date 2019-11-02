Feature: Place book on hold

  Scenario: A regular patron cannot place on hold restricted book
    When a regular patron place on hold restricted book on 7 days
    Then place on hold should fail with reason "Regular patrons cannot hold restricted books"
