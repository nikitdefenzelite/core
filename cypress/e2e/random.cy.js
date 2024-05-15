describe('Example Test Suite', () => {
    it('should get a random item from the specified array', () => {
      cy.getRandom('code').then(randomItem => {
        cy.log('Random Code Item:', randomItem);
      });
  
      cy.getRandom('name').then(randomItem => {
        cy.log('Random Name Item:', randomItem);
      });
  
      cy.getRandom('email').then(randomItem => {
        cy.log('Random Email Item:', randomItem);
      });
  
      cy.getRandom('firstName').then(randomItem => {
        cy.log('Random First Name Item:', randomItem);
      });
    });
});
  