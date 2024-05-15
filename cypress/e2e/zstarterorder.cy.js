describe('template spec', () => {
    beforeEach(() => {
      // Ignore uncaught exceptions
      cy.on('uncaught:exception', () => {
        return false;
      });
    });
  
    const baseUrl = 'https://zstarter.dze-labs.xyz/';
    const endPointUrl = '4jSmdmdDoLCQR/jx3azBhhpuRclGem';
    const email = 'admin@test.com';
    const password = 'admin1234';
  
    it('passes', () => {
        cy.visit(baseUrl + endPointUrl);
        cy.get('#floatingInput').click().type(email);
        cy.get('#password-field').type(password);
        cy.get('.btn').click();

        cy.url().should('contain', baseUrl);
        cy.get('header.wrapper > .navbar > .container > .navbar-collapse > .offcanvas-body > .navbar-nav > .pt-3 > .btn').click();
        cy.url().should('contain', baseUrl + 'admin/dashboard');

        // Navigate to the orders page
        cy.visit(baseUrl + 'admin/orders');

        // Verify if the page is loaded successfully
        cy.url().should('contain', baseUrl + 'admin/orders');

        // Click on the button to create a new order
        cy.get('.justicy-content-right > .btn-sm').click();

        // Ensure the URL changes to the create order page
        cy.url().should('contain', baseUrl + 'admin/orders/create');
        
        // Select user from dropdown
        cy.get('#select2-user_id-container').click();
        cy.wait(5000);
        cy.get('.select2-results__option').should('be.visible').contains('ARUN KUMAR | #UID93 | arun@zstarter.com').click();

        // Select item from dropdown
        cy.get('#select2-items-container').click();
        cy.wait(5000);
        cy.get('.select2-results__option').should('be.visible').contains('Cell Phone Tabletop Stand Tablet Stand | ₹5000 | #IID53 | Available').click();
      
        // Enter quantity
        cy.get('#qty').type('1');

        // Enter discount (optional)
        cy.get('#discount').type('0'); 

        // Enter shipping charges
        cy.get('#shipping').type('10');

        // Submit the form
        cy.get('.btn.btn-primary.floating-btn.ajax-btn').click();

    });
});
