describe('template spec', () => {
    beforeEach(() => {
        // Ignore uncaught exceptions
        Cypress.on('uncaught:exception', () => {
            return false;
        });
    });

    const baseUrl = '####s_url:https://zstarter.dze-labs.xyz/####';
    const endPointUrl = '####s_endpoint:4jSmdmdDoLCQR/jx3azBhhpuRclGem####';
    const email = '####s_email:admin@test.com####';
    const password = '####s_password:admin1234####';

    const newemail = '####f_email####';
    const newpassword = '####f_password####';
    const firstName = '####f_firstname####';
    const lastName = '####f_lastname####';
    const phoneNumber = '####f_phoneNumber####';
    const gender = '####f_gender####';
    const dob = '####f_dob####'; 
    const sendMail = true;
    const verifyMail = true;

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
