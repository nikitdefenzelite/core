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

        // Ensure the URL changes to the create user page
        cy.visit(baseUrl + 'admin/items/edit/eyJpdiI6IlRMZHdOQWFaNWtVVjlXRjFUaHg2cnc9PSIsInZhbHVlIjoiQ203UkVSU2V3cVN0dVY3UFdpUWliQT09IiwibWFjIjoiOGU3N2Q1MTg5OGZlOGQ3NTc4ODllZTNjMDIzOWRmZDM0ODMzMmJmMjk2NDQzOTFkYzZjMDdhZGM4YzkzNTBiZCIsInRhZyI6IiJ9');

        // Additional form fields
        cy.get('#name').should('be.visible').type('Arjun Kumawat', { force: true });
        cy.get('#title').should('be.visible').type('arjun-kumawat', { force: true });
        cy.get('#short_description').should('be.visible').type('ertertyrtyr', { force: true });
        cy.get('#sku').should('be.visible').type('rtyry', { force: true });

        // Meta Config form fields
        cy.get('#meta_title').should('be.visible').type('ryr', { force: true });
        cy.get('.bootstrap-tagsinput > input').should('be.visible').type('rtyry', { force: true });
        cy.get('#meta_description').should('be.visible').type('rtyrtyr', { force: true });

        // New form fields
        cy.get('#select2-category_id-container').click();
        cy.wait(2000); // Wait for the dropdown options to appear (not recommended, use better alternatives like `cy.waitUntil` or wait for specific loading indicators)
        cy.get('.select2-results__option').should('be.visible').contains('Mobile Phone').click(); // Selecting "Mobile Phone" category from dropdown
        
        cy.get('#sell_price').should('be.visible').type('100', { force: true });
        cy.get('#mrp_price').should('be.visible').type('120', { force: true });
        cy.get('#buy_price').should('be.visible').type('80', { force: true });
        cy.get('#tax_percent').should('be.visible').type('10', { force: true });
        cy.get('#identifier').should('be.visible').type('1', { force: true });
       
        // Submit the form
        cy.get('.btn.btn-primary.floating-btn.ajax-btn').should('be.visible').click();
    });
});


