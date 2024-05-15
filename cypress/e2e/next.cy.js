describe('test_name', function() {

    it('what_it_does', function() {
   
       cy.viewport(1366, 641);
    
       cy.visit('https://nextlevel.app/');
    
       cy.get('.chakra-ui-light > #__next > .landing-page > .flex > .justify-between').click();
    
       cy.get('.landing-page > .bg-white > .flex > .flex > .text-dark:nth-child(1)').click();
       
       cy.get('input[name="email"]').type('mayank02fd@defenzelite.com');
       cy.wait(1000);
       cy.contains('button', 'Continue').click();
      
       cy.get('input[type="password"]').click();

       cy.get('input[type="password"]').type('3#X2yeq.Zkd4HS7');
       
       cy.get('.chakra-input__group > .chakra-input__right-element > button > svg').click();
       
       cy.get('.max-w-2xl > .flex > .absolute > .max-w-2xl > .cursor-pointer').click();
       
       cy.get('.bg-blue').click();
       cy.get('.w-full > .font-extrabold').click();
    })
   
   })
   