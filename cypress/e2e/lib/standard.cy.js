describe('template spec', () => {
    it('passes', () => {
      cy.visit('####LOGIN_HOST_URL####');
      cy.get('#floatingInput').click();
      cy.get('#floatingInput').type('####EMAIL####');
      cy.get('#password-field').type('####PASSWORD####');
      cy.get('.btn').click();
      cy.url().should('contains', '####HOST_URL####');
      cy.get('header.wrapper > .navbar > .container > .navbar-collapse > .offcanvas-body > .navbar-nav > .pt-3 > .btn').click()
      cy.url().should('contains', '####ROUTE_HOST_URL####');
      cy.viewport(window.screen.width, window.screen.height);
      cy.wait(1000);
    })
  })