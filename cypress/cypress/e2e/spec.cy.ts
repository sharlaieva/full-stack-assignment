it('loads page', () => {
    cy.visit('/')
    cy.contains('John Doe')
})
