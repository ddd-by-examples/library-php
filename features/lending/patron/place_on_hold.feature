Feature: Place book on hold
  In order to read a book Patrons should be able to place book on hold

  Scenario: A regular patron cannot place on hold restricted book
    When a regular patron place on hold restricted book on 7 days
    Then place on hold should fail with reason "Regular patrons cannot hold restricted books"

  Scenario Outline: A researcher patron can hold any number of circulating books
    When a researcher patron with <holds> holds place on hold circulating book
    Then place on hold should succeed

    Examples:
      | holds |
      | 0     |
      | 1     |
      | 2     |
      | 3     |
      | 4     |
      | 5     |
      | 1000  |
