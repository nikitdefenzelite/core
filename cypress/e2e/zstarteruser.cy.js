describe('template spec', () => {
    beforeEach(() => {
        // Ignore uncaught exceptions
        Cypress.on('uncaught:exception', () => {
            return false;
        });
    });

    const baseUrl = 'https://zstarter.dze-labs.xyz/';
    const endPointUrl = '4jSmdmdDoLCQR/jx3azBhhpuRclGem';
    const email = 'admin@test.com';
    const password = 'admin1234';

    const newemail = '####f_email####';
    const newpassword = '123456@Admin';
    const firstName = '####f_firstName####';
    const lastName = '####f_lastName####';
    const phoneNumber = '####f_phoneNumber####'; // Update with a valid phone number
    const gender = 'Male'; // Update with appropriate gender
    const dob = '1990-01-01'; // Update with a valid date of birth
    const sendMail = true; // Update according to your requirement
    const verifyMail = true; // Update according to your requirement

    it('passes', () => {
        cy.visit(baseUrl + endPointUrl);
        cy.get('#floatingInput').click().type(email);
        cy.get('#password-field').type(password);
        cy.get('.btn').click();

        cy.url().should('contain', baseUrl);
        cy.get('header.wrapper > .navbar > .container > .navbar-collapse > .offcanvas-body > .navbar-nav > .pt-3 > .btn').click();
        cy.url().should('contain', baseUrl + 'admin/dashboard');

        // Ensure the URL changes to the create user page
        cy.visit(baseUrl + 'admin/users/create?role=User');

        // Wait for the form elements to become visible and type into them
        cy.get('#first_name').should('be.visible').type(firstName, { force: true });
        cy.get('#last_name').should('be.visible').type(lastName, { force: true });
        cy.get('#email').should('be.visible').type(newemail, { force: true });
        cy.get('#phone').should('be.visible').type(phoneNumber, { force: true });
        cy.get('input[name="gender"][value="' + gender + '"]').check({ force: true });
        cy.get('#dob').should('be.visible').type(dob, { force: true });

        // Additional fields
        cy.get('#password').should('be.visible').type(newpassword, { force: true });
        if (sendMail) {
            cy.get('#send_mail').check({ force: true });
        }
        if (verifyMail) {
            cy.get('#verify_mail').check({ force: true });
        }

        // Submit the form
        cy.get('.btn.btn-primary.floating-btn.ajax-btn').click();
    });
});
