Feature:
  In order to see the directory structure
  As a UNIX user
  I need to be able to list the current directories contents

  #will apply to both Scenarios
  Background:
    Given I have a file named "john"

  Scenario: List 2 files in a directory
    And I have a file named "hammond"
    When I run "ls"
    Then I should see "john" in the output
    And I should see "hammond" in the output
    
  Scenario: List 1 file and 1 directory
    And a directory named "ingen"
    When I run "ls"
    Then I should see "john" in the output
    And I should see "ingen" in the output