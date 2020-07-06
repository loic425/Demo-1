@viewing_pets
Feature: Ask for a visit for a pet
    In order to ask a visit for a pet
    As a Visitor
    I want to be able to ask a visit for a pet

    Background:
        Given pets are classified under "Cats" and "Dogs" categories
        And there is a pet with name "Gizmo"
        And this pet belongs to "Dogs"
        And there is a user "francis@underwood.com" identified by "whitehouse"
        And I am logged in as "francis@underwood.com"

    @ui
    Scenario: Ask for a visit for a pet
        Given I want to ask for a visit this pet
        And I confirm my choice
        And I should see my request has been send
        Then the pet "Gizmo" has been booked
