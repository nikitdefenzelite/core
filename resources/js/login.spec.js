const projectUrl = Cypress.env('https://zstarter.dze-labs.xyz/'); // Default URL if not provided

describe('Login and Logout', () => {
  it('Logs in successfully', () => {
    cy.visit(`${projectUrl}/login`) // Assuming your login page is at /login

    cy.get('input[name="email"]').type('example@example.com')
    cy.get('input[name="password"]').type('password')
    cy.get('form').submit()

    cy.url().should('include', `${projectUrl}/dashboard`)
    cy.contains('Welcome to Dashboard').should('exist')
  })

  it('Logs out successfully', () => {
    cy.visit(`${projectUrl}/dashboard`)

    cy.contains('Logout').click()

    cy.url().should('include', `${projectUrl}/login`)
    cy.contains('Login').should('exist')
  })
})