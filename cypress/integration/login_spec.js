describe('My Test Suite', () => {
    it('should visit a page', () => {
      cy.visit('https://zstarter.dze-labs.xyz/4jSmdmdDoLCQR/jx3azBhhpuRclGem');
      cy.get('.row').click();
      cy.get('#floatingInput').click();
      cy.get('#floatingInput').type('admin@test.com');
      cy.get('#password-field').type('admin1234');
      cy.get('.btn').click();
      cy.url().should('contains', 'https://zstarter.dze-labs.xyz/');
      
      cy.get('header.wrapper > .navbar > .container > .navbar-collapse > .offcanvas-body > .navbar-nav > .pt-3 > .btn').click()
      cy.url().should('contains', 'https://zstarter.dze-labs.xyz/admin/dashboard');
      
  });
  });