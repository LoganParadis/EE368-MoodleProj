@tool @tool_bulkenrol @_file_upload
Feature: An admin can bulk enrol users into courses using a CSV file
  In order to bulk enrol using a CSV file
  As an admin
  I need to be able to upload a CSV file and navigate through the import process

  Background:
    Given the following "courses" exist:
      | fullname                    | shortname | idnumber |  |
      | Intro to Computer Science 1 | CS141     | 3141     |  |
      | Intro to Computer Science 2 | CS142     | 3142     |  |
      | Software Engineering        | EE368     | 5368     |  |
    And I log in as "admin"
    And the following "users" exist:
      | firstname | lastname | username   | email                | idnumber |  |
      | Test      | User1    | test_user1 | donahuj@clarkson.edu | 11       |  |
    Given I navigate to "Courses > Bulk Enrollments" in site administration

  @javascript
  Scenario: Invalid: invalid course and role
    Given I upload "admin/tool/bulkenrol/tests/fixtures/enrol_bad_course_and_role.csv" file to "File" filemanager
    When I click on "Preview" "button"
    Then I should see "Could not resolve course by shortname"
    And I should see "Could not resolve role by shortname"
    When I click on "Bulk Enrollments" "button"
    Then I should see "Could not resolve course by shortname"
    And I should see "Could not resolve role by shortname"
    And I should see "bulkusers total: 1"
    And I should see "bulkusers enrolled: 0"
    And I should see "bulkusers errors: 1"
    Then I click on "Continue" "button"
    And I am on site homepage
    And I click on "Intro to Computer Science 1" "link"
    And I navigate to course participants
    And I should not see "Test User1"
    And I am on site homepage
    And I click on "Intro to Computer Science 2" "link"
    And I navigate to course participants
    And I should not see "Test User1"

  @javascript
  Scenario: Enrolling student/teacher successfully via user email, course shortname, and role shortname
    Given I upload "admin/tool/bulkenrol/tests/fixtures/enrol_success_1.csv" file to "File" filemanager
    And I click on "Preview" "button"
    Then I should see "Upload users preview"
    And I should see "donahuj@clarkson.edu"
    And I should see "Intro to Computer Science 1"
    And I should see "student"
    And I should see "donahuj@clarkson.edu"
    And I should see "Intro to Computer Science 2"
    And I should see "teacher"
    When I click on "Bulk Enrollments" "button"
    Then I should see "Upload users results"
    And I should see "donahuj@clarkson.edu"
    And I should see "Intro to Computer Science 1"
    And I should see "student"
    And I should see "User enrolled"
    And I should see "donahuj@clarkson.edu"
    And I should see "Intro to Computer Science 2"
    And I should see "teacher"
    And I should see "User enrolled"
    And I should see "bulkusers total: 2"
    And I should see "bulkusers enrolled: 2"
    And I should see "bulkusers errors: 0"
    Then I click on "Continue" "button"
    And I am on site homepage
    And I click on "Intro to Computer Science 1" "link"
    And I navigate to course participants
    And I should see "Test User1"
    And I am on site homepage
    And I click on "Intro to Computer Science 2" "link"
    And I navigate to course participants
    And I should see "Test User1"

  @javascript
  Scenario: Enrolling student/teacher successfully via username, course id number, and role id
    Given I upload "admin/tool/bulkenrol/tests/fixtures/enrol_success_2.csv" file to "File" filemanager
    And I set the field "Resolve User By" to "Username"
    And I set the field "Resolve Course By" to "Course ID Number"
    And I set the field "Resolve Role By" to "Role ID"
    And I click on "Preview" "button"
    Then I should see "Upload users preview"
    And I should see "donahuj@clarkson.edu"
    And I should see "Intro to Computer Science 1"
    And I should see "student"
    And I should see "donahuj@clarkson.edu"
    And I should see "Intro to Computer Science 2"
    And I should see "teacher"
    When I click on "Bulk Enrollments" "button"
    Then I should see "Upload users results"
    And I should see "donahuj@clarkson.edu"
    And I should see "Intro to Computer Science 1"
    And I should see "student"
    And I should see "User enrolled"
    And I should see "donahuj@clarkson.edu"
    And I should see "Intro to Computer Science 2"
    And I should see "teacher"
    And I should see "User enrolled"
    And I should see "bulkusers total: 2"
    And I should see "bulkusers enrolled: 2"
    And I should see "bulkusers errors: 0"
    Then I click on "Continue" "button"
    And I am on site homepage
    And I click on "Intro to Computer Science 1" "link"
    And I navigate to course participants
    And I should see "Test User1"
    And I am on site homepage
    And I click on "Intro to Computer Science 2" "link"
    And I navigate to course participants
    And I should see "Test User1"

  @javascript
  Scenario: Invalid: user does not exist
    Given I upload "admin/tool/bulkenrol/tests/fixtures/enrol_user_does_not_exist.csv" file to "File" filemanager
    When I click on "Preview" "button"
    Then I should see "Could not resolve user by email"
    When I click on "Bulk Enrollments" "button"
    Then I should see "Could not resolve user by email"
    And I should see "bulkusers total: 1"
    And I should see "bulkusers enrolled: 0"
    And I should see "bulkusers errors: 1"
    Then I click on "Continue" "button"
    And I am on site homepage
    And I click on "Intro to Computer Science 1" "link"
    And I navigate to course participants
    And I should not see "Test User1"
    And I am on site homepage
    And I click on "Intro to Computer Science 2" "link"
    And I navigate to course participants
    And I should not see "Test User1"

  @javascript
  Scenario: Invalid: student/teacher is already enrolled or a student tries to enroll as a student or a teacher tries to enrol as a student
    Given I upload "admin/tool/bulkenrol/tests/fixtures/enrol_success_1.csv" file to "File" filemanager
    And I click on "Preview" "button"
    And I click on "Bulk Enrollments" "button"
    And I click on "Continue" "button"
    When I upload "admin/tool/bulkenrol/tests/fixtures/enrol_student_already_enrolled.csv" file to "File" filemanager
    And I click on "Preview" "button"
    Then I should see "Upload users preview"
    And I should see "The user is enrolled and update is not allowed"
    And I should see "The user is enrolled and update is not allowed"
    And I should see "The user is enrolled and update is not allowed"
    When I click on "Bulk Enrollments" "button"
    Then I should see "Upload users results"
    And I should see "The user is enrolled and update is not allowed"
    And I should see "The user is enrolled and update is not allowed"
    And I should see "The user is enrolled and update is not allowed"
    And I should see "bulkusers total: 3"
    And I should see "bulkusers enrolled: 0"
    And I should see "bulkusers errors: 3"

#  The following behat test would give successful results for testing the course id and user id options available
#  However, behat automatic test cases do not provide autgenerated values such as course id and user id
#  So, we cannot test these automatically
#
#  @javascript
#  Scenario: Enrolling student/teacher successfully via user id, course id, and role shortname
#    Given I upload "admin/tool/bulkenrol/tests/fixtures/enrol_success_4.csv" file to "File" filemanager
#    And I set the field "Resolve User By" to "User ID"
#    And I set the field "Resolve Course By" to "Course ID"
#    And I click on "Preview" "button"
#    Then I should see "Upload users preview"
#    And I should see "donahuj@clarkson.edu"
#    And I should see "Intro to Computer Science 1"
#    And I should see "student"
#    And I should see "donahuj@clarkson.edu"
#    And I should see "Intro to Computer Science 2"
#    And I should see "teacher"
#    When I click on "Bulk Enrollments" "button"
#    Then I should see "Upload users results"
#    And I should see "donahuj@clarkson.edu"
#    And I should see "Intro to Computer Science 1"
#    And I should see "student"
#    And I should see "User enrolled"
#    And I should see "donahuj@clarkson.edu"
#    And I should see "Intro to Computer Science 2"
#    And I should see "teacher"
#    And I should see "User enrolled"
#    And I should see "bulkusers total: 2"
#    And I should see "bulkusers enrolled: 2"
#    And I should see "bulkusers errors: 0"
#    Then I click on "Continue" "button"
#    And I am on site homepage
#    And I click on "Intro to Computer Science 1" "link"
#    And I navigate to course participants
#    And I should see "Test User1"
#    And I am on site homepage
#    And I click on "Intro to Computer Science 2" "link"
#    And I navigate to course participants
#    And I should see "Test User1"