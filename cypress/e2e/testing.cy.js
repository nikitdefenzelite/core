describe('template spec', () => {
    it('passes', () => {
      cy.visit('https://zstarter.dze-labs.xyz/4jSmdmdDoLCQR/jx3azBhhpuRclGem');
      cy.get('#floatingInput').click();
      cy.get('#floatingInput').type('admin@test.com');
      cy.get('#password-field').type('admin1234');
      cy.get('.btn').click();
      cy.url().should('contains', 'https://zstarter.dze-labs.xyz/');
      cy.get('header.wrapper > .navbar > .container > .navbar-collapse > .offcanvas-body > .navbar-nav > .pt-3 > .btn').click()
      cy.url().should('contains', 'https://zstarter.dze-labs.xyz/admin/dashboard');
      cy.viewport(window.screen.width, window.screen.height)
    
      
      cy.get('#main-menu-navigation > :nth-child(2) > [href="#"]').click();
      cy.get('[href="https://zstarter.dze-labs.xyz/admin/orders"]').click();
      cy.get('.justicy-content-right > .btn-sm').click();
     
      cy.url().should('contains', 'https://zstarter.dze-labs.xyz/admin/orders');
      cy.url().should('contains', 'https://zstarter.dze-labs.xyz/admin/orders/create');
      cy.get('#select2-user_id-container').click();
      cy.get('.select2-results__option--highlighted').click();
    
      cy.get('#select2-to_address-container').click();
      cy.get('#select2-from_address-container').click();
      cy.get('.container-fluid > .row').click();
      cy.get('#qty').type('10');
      cy.get('.floating-btn').click();
      cy.url().should('contains', 'https://zstarter.dze-labs.xyz/admin/orders');
      cy.visit('https://zstarter.dze-labs.xyz/admin/orders?from=2024-04-01&to=2024-04-30');
  
    })
  })